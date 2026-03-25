<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;
    protected PaymentService $paymentService;

    public function __construct(
        CartService $cartService,
        OrderService $orderService,
        PaymentService $paymentService
    ) {
        $this->cartService  = $cartService;
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    /**
     * Vista del checkout
     */
    public function index()
    {
        $cart = $this->cartService->getCart()->load('items.product.category');

        if ($cart->isEmpty()) {
            return redirect()
                ->route('shop.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $estimatedShipping = $cart->hasOnlyDigitalProducts() ? 0 : 20000;

        return view('landing.checkout.index', compact('cart', 'estimatedShipping'));
    }

    /**
     * Procesar checkout
     */
public function process(CheckoutRequest $request)
{
    $cart = $this->cartService->getCart()->load('items.product.category');

    if ($cart->isEmpty()) {
        return redirect()
            ->route('shop.index')
            ->with('error', 'Tu carrito está vacío.');
    }

    try {
        $shippingData = [];
        $shippingCost = 0;

        if (!$cart->hasOnlyDigitalProducts()) {
            $shippingData = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country ?? 'Colombia',
                'notes' => $request->notes,
            ];
            $shippingCost = $this->calculateShipping($request->city);
        } else {
            $shippingData = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => 'Colombia',
            ];
        }

        // Crear orden
        $order = $this->orderService->createFromCart(
            $cart,
            $shippingData,
            $shippingCost
        );

        Log::info('Orden creada', [
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'total' => $order->total
        ]);

        // Crear el pago y preparar redirección
        $redirect = $this->redirectToPaymentMethod($order, $request->payment_method);

        // ✅ Vaciar carrito DESPUÉS de que todo salió bien
        $cart->clear();

        return $redirect;

    } catch (\Exception $e) {
        Log::error('Error en checkout: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return back()
            ->with('error', 'Error al procesar la orden: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Redirigir a la página específica según el método de pago
     */
    protected function redirectToPaymentMethod($order, string $paymentMethod)
{
    // Crear el registro de pago
    $payment = $this->paymentService->processPayment(
        $order,
        $paymentMethod,
        []
    );

    switch ($paymentMethod) {
        case 'manual_breb':
            return redirect()
                ->route('payment.instructions.breb', $order->id)
                ->with('success', 'Orden creada. Sigue las instrucciones para pagar con Bre-b.');

        case 'manual_transfer':
            return redirect()
                ->route('payment.instructions.transfer', $order->id)
                ->with('success', 'Orden creada. Sigue las instrucciones para la transferencia bancaria.');

        case 'manual_qr':
            return redirect()
                ->route('payment.instructions.qr', $order->id)
                ->with('success', 'Completa el pago escaneando el código QR.');

        case 'card':
            return redirect()
                ->route('payment.instructions.card', $order->id)
                ->with('success', 'Orden creada. Procede con el pago con tarjeta.');

        case 'cash_on_delivery':
            return redirect()
                ->route('payment.confirmation', $order->id)
                ->with('success', 'Orden creada. Pagarás contra entrega.');

        default:
            return redirect()
                ->route('payment.confirmation', $order->id)
                ->with('warning', 'Orden creada con método de pago pendiente de configuración.');
    }
}

    /**
     * Confirmación de orden
     */
    public function confirmation($order)
    {
        $order = \App\Models\Order::with(['items.product', 'shippingAddress', 'payment'])
            ->findOrFail($order);

        return view('landing.orders.confirmation', compact('order'));
    }

    /**
     * Costo de envío dinámico
     */
    protected function calculateShipping(string $city = null): float
    {
        if (!$city) return 0;

        $mainCities = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla'];

        return in_array($city, $mainCities) ? 15000 : 25000;
    }
}
