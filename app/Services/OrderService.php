<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ProductDownloadNotification;
use Illuminate\Support\Facades\Notification;

class OrderService
{
    /**
     * Crear orden desde carrito
     */
    public function createFromCart(Cart $cart, array $shippingData, float $shippingCost = 0, float $taxRate = 0.19): Order
    {
        if ($cart->isEmpty()) {
            throw new \Exception('El carrito está vacío');
        }

        return DB::transaction(function () use ($cart, $shippingData, $shippingCost, $taxRate) {

            $subtotal = $cart->getSubtotal();
            $tax = $subtotal * $taxRate;
            $total = $subtotal + $tax + $shippingCost;

            // Crear orden
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'currency' => 'COP',
            ]);

            // Crear items de la orden
            foreach ($cart->items as $cartItem) {
                $product = $cartItem->product;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->getSubtotal(),
                ]);

                // Reducir stock
                $product->decreaseStock($cartItem->quantity);
            }

            /**
             * Si es compra digital: NO crear dirección
             */
            $addressLine1 = $shippingData['address_line_1'] ?? null;
            $city = $shippingData['city'] ?? null;
            $postal = $shippingData['postal_code'] ?? null;

            $isDigitalOrder = empty($addressLine1) && empty($city) && empty($postal);

            if (!$isDigitalOrder) {
                ShippingAddress::create([
                    'order_id' => $order->id,
                    'full_name' => $shippingData['full_name'] ?? null,
                    'email' => $shippingData['email'] ?? null,
                    'phone' => $shippingData['phone'] ?? null,
                    'address_line_1' => $addressLine1,
                    'address_line_2' => $shippingData['address_line_2'] ?? null,
                    'city' => $city,
                    'state' => $shippingData['state'] ?? null,
                    'postal_code' => $postal,
                    'country' => $shippingData['country'] ?? 'Colombia',
                    'notes' => $shippingData['notes'] ?? null,
                ]);
            }

            // ✅ NO VACIAR EL CARRITO AQUÍ
            // Se vacía en CheckoutController después de crear el pago
            // $cart->clear();

            return $order;
        });
    }

    /**
     * Marcar orden como esperando pago por QR
     */
    public function markAsPendingQR(Order $order): void
    {
        DB::transaction(function () use ($order) {

            // Cambia estado de la orden
            $order->update([
                'status' => 'pending_qr',
            ]);

            // Crear registro del pago pendiente
            $order->payment()->create([
                'method'    => 'qr_payment',
                'reference' => 'QR-' . strtoupper(uniqid()),
                'amount'    => $order->total,
                'status'    => 'pending',
                'receipt'   => null,
            ]);
        });
    }

    /**
     * Cancelar orden
     */
    public function cancelOrder(Order $order): void
    {
        if (!$order->canBeCancelled()) {
            throw new \Exception('Esta orden no puede ser cancelada');
        }

        DB::transaction(function () use ($order) {
            $order->markAsCancelled();
        });
    }

    /**
     * Marcar orden como pagada
     */
    public function markAsPaid(Order $order, array $paymentData): void
    {
        DB::transaction(function () use ($order, $paymentData) {

            $order->markAsPaid();

            $order->payment()->create([
                'transaction_id' => $paymentData['transaction_id'] ?? null,
                'payment_method' => $paymentData['payment_method'],
                'payment_gateway' => $paymentData['payment_gateway'] ?? null,
                'amount' => $order->total,
                'currency' => $order->currency,
                'status' => 'completed',
                'paid_at' => now(),
                'metadata' => $paymentData['metadata'] ?? null,
            ]);
        });
    }

    /**
     * Actualizar estado
     */
    public function updateStatus(Order $order, string $status): void
    {
        $validStatuses = [
            'pending',
            'pending_qr',
            'paid',
            'processing',
            'shipped',
            'delivered',
            'cancelled',
            'refunded'
        ];

        if (!in_array($status, $validStatuses)) {
            throw new \Exception('Estado de orden inválido');
        }

        $order->update(['status' => $status]);

        match($status) {
            'shipped' => $order->markAsShipped(),
            'delivered' => $order->markAsDelivered(),
            'cancelled' => $order->markAsCancelled(),
            default => null,
        };
    }

    /**
     * Productos digitales
     */
    public function processDigitalProducts(Order $order): void
    {
        $downloads = [];

        foreach ($order->items as $item) {

            $product = $item->product;

            if ($product && $product->isBook() && $product->hasFile()) {
                $download = $product->createDownloadToken(
                    $order,
                    $order->shippingAddress?->email ?? $order->user->email
                );

                $downloads[] = $download;
            }
        }

        if (!empty($downloads)) {
            Notification::route('mail', $order->shippingAddress->email ?? $order->user->email)
                ->notify(new ProductDownloadNotification($order, $downloads));
        }
    }
}
