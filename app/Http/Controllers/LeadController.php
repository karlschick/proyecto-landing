<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Http\Requests\LeadRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Guardar nuevo lead y enviar emails directos (SIN notificaciones)
     */
    public function store(LeadRequest $request)
    {
        $key = 'contact-form:' . $request->ip();
        $maxAttempts = config('app.env') === 'production' ? 3 : 100;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return redirect('/#contacto')->with('error', "Demasiados intentos. Por favor espera {$seconds} segundos.");
        }

        set_time_limit(120);

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

            RateLimiter::hit($key, 3600);
            Log::info('✅ Lead creado', ['lead_id' => $lead->id, 'email' => $lead->email]);

            // ✅ 1. EMAIL AL CLIENTE (Confirmación)
            try {
                Mail::send('emails.lead-confirmation', ['lead' => $lead], function ($message) use ($lead) {
                    $message->to($lead->email, $lead->name)
                            ->subject('✅ Hemos recibido tu mensaje - ' . config('app.name'));
                });
                Log::info('✅ Email enviado al cliente', ['email' => $lead->email]);
            } catch (\Exception $e) {
                Log::error('❌ Error email cliente: ' . $e->getMessage());
            }

            // ✅ 2. EMAIL A ADMINISTRADORES (Notificación)
            try {
                // Obtener email de notificación
                $settings = DB::table('settings')
                    ->select('notification_email', 'contact_email')
                    ->first();

                $adminEmail = $settings->notification_email ?? $settings->contact_email;

                if ($adminEmail) {
                    Mail::send('emails.new-lead', ['lead' => $lead], function ($message) use ($lead, $adminEmail) {
                        $message->to($adminEmail)
                                ->replyTo($lead->email, $lead->name)
                                ->subject('🔔 Nuevo Contacto desde ' . config('app.name'));
                    });
                    Log::info('✅ Email enviado a admin', ['email' => $adminEmail]);
                }

                // Notificar a otros admins del sistema
                $admins = User::where('role', 'admin')
                    ->whereNotNull('email')
                    ->pluck('email')
                    ->toArray();

                foreach ($admins as $adminEmail) {
                    try {
                        Mail::send('emails.new-lead', ['lead' => $lead], function ($message) use ($lead, $adminEmail) {
                            $message->to($adminEmail)
                                    ->replyTo($lead->email, $lead->name)
                                    ->subject('🔔 Nuevo Contacto desde ' . config('app.name'));
                        });
                    } catch (\Exception $e) {
                        Log::error('❌ Error email admin: ' . $e->getMessage());
                    }
                }

                Log::info('✅ Emails enviados a admins', ['count' => count($admins)]);

            } catch (\Exception $e) {
                Log::error('❌ Error enviando emails a admins: ' . $e->getMessage());
            }

            return redirect('/#contacto')->with('success', '¡Mensaje enviado correctamente! Te contactaremos pronto.');

        } catch (\Exception $e) {
            Log::error('❌ Error crítico al crear lead', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect('/#contacto')
                ->with('error', 'Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.')
                ->withInput();
        }
    }
}
