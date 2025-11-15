<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Mostrar pagos pendientes (Daviplata)
     */
    public function pending()
    {
        $payments = Payment::with(['order.items.product', 'order.shippingAddress'])
            ->where('status', 'pending')
            ->where('payment_method', 'qr_payment')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.pending', compact('payments'));
    }

    /**
     * Verificar y aprobar pago
     */
    public function verify(Payment $payment, Request $request)
    {
        $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Actualizar pago
            $payment->update([
                'status' => 'completed',
                'transaction_id' => $request->transaction_reference,
                'paid_at' => now(),
                'metadata' => array_merge($payment->metadata ?? [], [
                    'verified_by' => auth()->id(),
                    'verified_at' => now()->toDateTimeString(),
                    'admin_notes' => $request->notes,
                ]),
            ]);

            // Actualizar orden
            $order = $payment->order;
            $order->update([
                'status' => 'processing',
                'payment_status' => 'paid',
            ]);

            // Generar tokens de descarga y enviar email
            $this->orderService->processDigitalProducts($order);

            \Log::info('Pago verificado manualmente', [
                'payment_id' => $payment->id,
                'order_id' => $order->id,
                'verified_by' => auth()->user()->email,
            ]);

            return redirect()
                ->route('admin.payments.pending')
                ->with('success', '✅ Pago verificado exitosamente. Se envió el email con los links de descarga.');

        } catch (\Exception $e) {
            \Log::error('Error al verificar pago: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error al verificar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar pago
     */
    public function reject(Payment $payment, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $payment->update([
                'status' => 'failed',
                'metadata' => array_merge($payment->metadata ?? [], [
                    'rejected_by' => auth()->id(),
                    'rejected_at' => now()->toDateTimeString(),
                    'rejection_reason' => $request->rejection_reason,
                ]),
            ]);

            $payment->order->update([
                'status' => 'cancelled',
                'payment_status' => 'failed',
            ]);

            \Log::warning('Pago rechazado', [
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'reason' => $request->rejection_reason,
                'rejected_by' => auth()->user()->email,
            ]);

            return redirect()
                ->route('admin.payments.pending')
                ->with('success', 'Pago rechazado. La orden ha sido cancelada.');

        } catch (\Exception $e) {
            \Log::error('Error al rechazar pago: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error al rechazar el pago: ' . $e->getMessage());
        }
    }
}
