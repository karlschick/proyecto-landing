<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\ProductDownload;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductDownloadNotification extends Notification
{
    use Queueable;

    protected Order $order;
    protected array $downloads;

    public function __construct(Order $order, array $downloads)
    {
        $this->order = $order;
        $this->downloads = $downloads;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $settings = \App\Models\Setting::getSettings();

        $message = (new MailMessage)
            ->subject('✅ Tu compra está lista - ' . ($settings->site_name ?? config('app.name')))
            ->greeting('¡Hola ' . $this->order->shippingAddress->full_name . '!')
            ->line('Tu pago ha sido confirmado. ¡Gracias por tu compra!')
            ->line('')
            ->line('**Orden #' . $this->order->order_number . '**')
            ->line('**Total pagado:** $' . number_format($this->order->total, 0, ',', '.'))
            ->line('')
            ->line('**📚 Tus productos digitales están listos:**')
            ->line('');

        // Agregar cada producto con su link de descarga
        foreach ($this->downloads as $download) {
            $product = $download->product;
            $downloadUrl = route('downloads.file', $download->download_token);

            $message->line('**' . $product->name . '**')
                    ->line('📥 Descargas disponibles: ' . $download->getRemainingDownloads() . ' de ' . $download->max_downloads)
                    ->line('⏰ Válido por: ' . $download->getRemainingDays() . ' días')
                    ->action('Descargar ' . $product->name, $downloadUrl)
                    ->line('');
        }

        $message->line('---')
                ->line('')
                ->line('**⚠️ Importante:**')
                ->line('• Guarda este correo en un lugar seguro')
                ->line('• Los links de descarga tienen un límite de descargas')
                ->line('• Si tienes problemas, contáctanos')
                ->line('')
                ->line('**Información de contacto:**')
                ->line('• Email: ' . ($settings->contact_email ?? 'soporte@example.com'))
                ->line('• Teléfono: ' . ($settings->contact_phone ?? 'N/A'))
                ->line('')
                ->salutation('Atentamente, ' . ($settings->site_name ?? config('app.name')));

        return $message;
    }
}
