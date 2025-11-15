<?php

namespace App\Http\Controllers;

use App\Mail\LandingContactMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LandingContactController extends Controller
{
    public function send(Request $request)
    {
        // Validación
        $data = $request->validate([
            'name'    => 'required|string|max:120',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
        ]);

        // Obtener email de destino desde configuración
        $settings = Setting::getSettings();
        $to = $settings->notification_email ?? $settings->contact_email;

        if (!$to) {
            return back()->with('error', 'El sitio no tiene configurado un email de destino.');
        }

        // Enviar correo
        try {
            Mail::to($to)->send(new LandingContactMail($data));
        } catch (\Exception $e) {
            return back()->with('error', 'Error enviando correo: ' . $e->getMessage());
        }

        return back()->with('success', 'Tu mensaje fue enviado correctamente.');
    }
}
