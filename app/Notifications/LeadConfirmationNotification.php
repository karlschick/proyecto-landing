<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadConfirmationNotification extends Notification implements ShouldQueue
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
        $settings = \App\Models\Setting::getSettings();

        return (new MailMessage)
            ->subject('✅ Hemos recibido tu mensaje - ' . ($settings->site_name ?? config('app.name')))
            ->greeting('¡Hola ' . $this->lead->name . '!')
            ->line('Gracias por contactarnos. Hemos recibido tu mensaje correctamente.')
            ->line('')
            ->line('**Tu mensaje:**')
            ->line($this->lead->message)
            ->line('')
            ->line('Nuestro equipo revisará tu solicitud y te responderá lo antes posible.')
            ->line('Generalmente respondemos en menos de 24 horas hábiles.')
            ->line('')
            ->line('**Información de contacto:**')
            ->line('• Email: ' . ($settings->contact_email ?? 'contacto@example.com'))
            ->line('• Teléfono: ' . ($settings->contact_phone ?? 'N/A'))
            ->line('')
            ->line('¡Esperamos poder ayudarte pronto!')
            ->salutation('Atentamente, Equipo de ' . ($settings->site_name ?? config('app.name')));
    }
}
