<?php

namespace App\Services;

use App\Models\Order;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DaviplataService
{
    protected string $phoneNumber;
    protected string $accountName;

    public function __construct()
    {
        $this->phoneNumber = config('services.daviplata.phone', '3118939652');
        $this->accountName = config('services.daviplata.name', 'Carlos Mauricio Gomez Salas');
    }

    /**
     * Generar QR de Daviplata para una orden
     */
    public function generateQRCode(Order $order): string
    {
        // Formato del QR para Daviplata
        $qrData = $this->buildQRData($order);

        // Generar QR como SVG (más ligero y escalable)
        return QrCode::size(300)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($qrData);
    }

    /**
     * Construir datos del QR
     * Daviplata usa formato: daviplata://pago?phone={phone}&amount={amount}&ref={ref}
     */
    protected function buildQRData(Order $order): string
    {
        $params = http_build_query([
            'phone' => $this->phoneNumber,
            'amount' => number_format($order->total, 0, '', ''),
            'reference' => $order->order_number,
            'description' => 'Orden ' . $order->order_number,
        ]);

        return "daviplata://pago?" . $params;
    }

    /**
     * Generar enlace de pago directo (alternativa al QR)
     */
    public function getPaymentLink(Order $order): string
    {
        return "https://api.whatsapp.com/send?phone=57{$this->phoneNumber}&text=" .
               urlencode("Hola, quiero pagar la orden #{$order->order_number} por $" . number_format($order->total, 0, ',', '.'));
    }

    /**
     * Obtener información de la cuenta
     */
    public function getAccountInfo(): array
    {
        return [
            'phone' => $this->phoneNumber,
            'name' => $this->accountName,
            'formatted_phone' => '+57 ' . substr($this->phoneNumber, 0, 3) . ' ' .
                                substr($this->phoneNumber, 3, 4) . ' ' .
                                substr($this->phoneNumber, 7, 4),
        ];
    }

    /**
     * Validar referencia de pago (para verificación manual)
     */
    public function validatePaymentReference(string $reference): bool
    {
        // Aquí podrías implementar lógica adicional
        // Por ahora solo verifica que no esté vacío
        return !empty($reference) && strlen($reference) >= 6;
    }
}
