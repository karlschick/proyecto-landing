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
        // ✅ SIN consultar base de datos con imágenes, solo valores necesarios
        $siteName = config('app.name', 'FitnessSuit');

        return (new MailMessage)
            ->subject('✅ Hemos recibido tu mensaje - ' . $siteName)
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
            ->line('• Email: maurofit5asesorados@gmail.com')
            ->line('• Teléfono: +57 311 893 9652')
            ->line('')
            ->line('¡Esperamos poder ayudarte pronto!')
            ->salutation('Atentamente, ' . $siteName);
    }
}
