<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Setting;
use App\Http\Requests\LeadRequest;
use App\Notifications\NewLeadNotification;
use App\Notifications\LeadConfirmationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Guardar nuevo lead desde formulario de contacto
     */
    public function store(LeadRequest $request)
    {
        // Rate limiting: máximo 3 intentos por hora por IP
        $key = 'contact-form:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Demasiados intentos. Por favor espera {$seconds} segundos.");
        }

        try {
            // Crear el lead
            $lead = Lead::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'nuevo',
            ]);

            // Incrementar rate limiter
            RateLimiter::hit($key, 3600); // 1 hora

            // Obtener configuración
            $settings = Setting::getSettings();

            // Enviar email de confirmación al cliente
            $lead->notify(new LeadConfirmationNotification($lead));

            // Notificar a administradores
            $notificationEmail = $settings->notification_email ?? $settings->contact_email;

            if ($notificationEmail) {
                // Buscar usuario admin con ese email o crear notificación anónima
                $adminUser = User::where('email', $notificationEmail)->first();

                if ($adminUser) {
                    $adminUser->notify(new NewLeadNotification($lead));
                } else {
                    // Enviar email directo sin usuario
                    Notification::route('mail', $notificationEmail)
                        ->notify(new NewLeadNotification($lead));
                }
            }

            // Notificar a todos los admins
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new NewLeadNotification($lead));

            \Log::info('Nuevo lead creado', [
                'id' => $lead->id,
                'email' => $lead->email,
                'ip' => $request->ip()
            ]);

            return back()->with('success', '¡Mensaje enviado correctamente! Te contactaremos pronto.');

        } catch (\Exception $e) {
            \Log::error('Error al crear lead: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.')
                ->withInput();
        }
    }
}
