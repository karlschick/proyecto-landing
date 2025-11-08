<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;

class PaymentService
{
    /**
     * Procesar pago (stub - implementar según pasarela)
     */
    public function processPayment(Order $order, string $paymentMethod, array $paymentData = []): Payment
    {
        // TODO: Integrar con pasarela de pago real
        // Ejemplos: MercadoPago, PayU, Stripe, etc.

        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $this->generateTransactionId(),
            'payment_method' => $paymentMethod,
            'payment_gateway' => $paymentData['gateway'] ?? 'manual',
            'amount' => $order->total,
            'currency' => $order->currency,
            'status' => 'pending',
            'metadata' => $paymentData,
        ]);

        return $payment;
    }

    /**
     * Confirmar pago exitoso
     */
    public function confirmPayment(Payment $payment): void
    {
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        $payment->order->markAsPaid();
    }

    /**
     * Marcar pago como fallido
     */
    public function failPayment(Payment $payment, string $reason = null): void
    {
        $metadata = $payment->metadata ?? [];
        $metadata['failure_reason'] = $reason;

        $payment->update([
            'status' => 'failed',
            'metadata' => $metadata,
        ]);
    }

    /**
     * Procesar reembolso
     */
    public function refundPayment(Payment $payment): void
    {
        // TODO: Implementar lógica de reembolso según pasarela

        $payment->update([
            'status' => 'refunded',
        ]);

        $payment->order->update(['status' => 'refunded']);
    }

    /**
     * Generar ID de transacción único
     */
    protected function generateTransactionId(): string
    {
        return 'TXN-' . strtoupper(uniqid());
    }

    /**
     * Verificar estado de pago con pasarela
     */
    public function verifyPaymentStatus(string $transactionId): string
    {
        // TODO: Consultar estado real en la pasarela
        return 'completed';
    }
}
