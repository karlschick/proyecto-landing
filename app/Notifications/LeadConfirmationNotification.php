<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadConfirmationNotification extends Notification
{
    use Queueable;

    protected Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        // ✅ OPTIMIZACIÓN: Solo cargar campos necesarios (no imágenes pesadas)
        $settings = \App\Models\Setting::select('site_name', 'contact_email', 'contact_phone')
            ->first();

        return (new MailMessage)
            ->subject('✅ Hemos recibido tu mensaje - ' . ($settings->site_name ?? config('app.name')))
            ->greeting('¡Hola ' . $this->lead->name . '!')
            ->line('Gracias por contactarnos. Hemos recibido tu mensaje correctamente.')
            ->line('')
            ->line('**Tu mensaje:**')
            ->line($this->lead->message)
            ->line('')
            ->line('Revisaremos tu solicitud y te responderemos lo antes posible.')
            ->line('Generalmente respondemos en menos de 24 horas hábiles.')
            ->line('')
            ->line('**Información de contacto:**')
            ->line('• Email: ' . ($settings->contact_email ?? 'info@example.com'))
            ->line('• Teléfono: ' . ($settings->contact_phone ?? 'N/A'))
            ->line('')
            ->line('¡Esperamos poder ayudarte pronto!')
            ->salutation('Atentamente, ' . ($settings->site_name ?? config('app.name')));
    }
}
