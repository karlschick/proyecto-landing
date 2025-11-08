<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

            // Crear dirección de envío
            ShippingAddress::create([
                'order_id' => $order->id,
                'full_name' => $shippingData['full_name'],
                'email' => $shippingData['email'],
                'phone' => $shippingData['phone'],
                'address_line_1' => $shippingData['address_line_1'],
                'address_line_2' => $shippingData['address_line_2'] ?? null,
                'city' => $shippingData['city'],
                'state' => $shippingData['state'] ?? null,
                'postal_code' => $shippingData['postal_code'],
                'country' => $shippingData['country'] ?? 'Colombia',
                'notes' => $shippingData['notes'] ?? null,
            ]);

            // Vaciar carrito
            $cart->clear();

            return $order;
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

            // Notificar al cliente (implementar según necesites)
            // event(new OrderCancelled($order));
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

            // Notificar al cliente
            // event(new OrderPaid($order));
        });
    }

    /**
     * Actualizar estado de orden
     */
    public function updateStatus(Order $order, string $status): void
    {
        $validStatuses = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];

        if (!in_array($status, $validStatuses)) {
            throw new \Exception('Estado de orden inválido');
        }

        $order->update(['status' => $status]);

        // Actualizar timestamps específicos
        match($status) {
            'shipped' => $order->markAsShipped(),
            'delivered' => $order->markAsDelivered(),
            'cancelled' => $order->markAsCancelled(),
            default => null,
        };
    }
}
