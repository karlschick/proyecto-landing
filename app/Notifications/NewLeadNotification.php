<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification
{
    use Queueable;

    protected Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        // ✅ OPTIMIZACIÓN: Solo cargar el campo necesario (no imágenes pesadas)
        $siteName = \App\Models\Setting::select('site_name')->value('site_name')
                    ?? config('app.name');

        return (new MailMessage)
            ->from($this->lead->email, $this->lead->name)
            ->replyTo($this->lead->email, $this->lead->name)
            ->subject('🔔 Nuevo Contacto desde ' . $siteName)
            ->greeting('¡Hola!')
            ->line('Has recibido un nuevo mensaje de contacto desde tu sitio web.')
            ->line('')
            ->line('**Detalles del contacto:**')
            ->line('• **Nombre:** ' . $this->lead->name)
            ->line('• **Email:** ' . $this->lead->email)
            ->line('• **Teléfono:** ' . ($this->lead->phone ?? 'No proporcionado'))
            ->line('• **Asunto:** ' . ($this->lead->subject ?? 'Sin asunto'))
            ->line('')
            ->line('**Mensaje:**')
            ->line($this->lead->message)
            ->line('')
            ->line('**Información adicional:**')
            ->line('• Recibido: ' . $this->lead->created_at->format('d/m/Y H:i'))
            ->line('• IP: ' . $this->lead->ip_address)
            ->action('Ver en el Panel', route('admin.leads.show', $this->lead))
            ->salutation('Saludos, ' . $siteName);
    }

    public function toArray($notifiable): array
    {
        return [
            'lead_id' => $this->lead->id,
            'name' => $this->lead->name,
            'email' => $this->lead->email,
            'message' => $this->lead->message,
            'created_at' => $this->lead->created_at->toDateTimeString(),
        ];
    }
}
