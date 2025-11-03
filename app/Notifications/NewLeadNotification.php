<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Canales de notificación
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Email notification
     */
    public function toMail($notifiable): MailMessage
    {
        $settings = \App\Models\Setting::getSettings();

        return (new MailMessage)
            ->subject('🔔 Nuevo Contacto desde ' . ($settings->site_name ?? 'la Web'))
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
            ->line('Responde lo antes posible para no perder esta oportunidad.')
            ->salutation('Saludos, ' . ($settings->site_name ?? config('app.name')));
    }

    /**
     * Database notification
     */
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
