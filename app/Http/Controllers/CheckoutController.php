<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;

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
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();

        if ($cart->isEmpty()) {
            return redirect()
                ->route('shop.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $cart->load('items.product.category');

        // Calcular costo de envío estimado (solo si tiene productos físicos)
        $estimatedShipping = $cart->hasOnlyDigitalProducts() ? 0 : 20000;

        return view('landing.checkout.index', compact('cart', 'estimatedShipping'));
    }

    public function process(CheckoutRequest $request)
    {
        $cart = $this->cartService->getCart();

        if ($cart->isEmpty()) {
            return redirect()
                ->route('shop.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        try {
            $cart->load('items.product.category');

            // Preparar datos de envío (solo si NO es solo productos digitales)
            $shippingData = null;
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

                // Calcular costo de envío
                $shippingCost = $this->calculateShipping($request->city);
            } else {
                // Para productos digitales, solo necesitamos email y nombre
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

            // Procesar según método de pago
            if ($request->payment_method === 'qr_payment') {
                // Pago QR para productos digitales
                $payment = $this->paymentService->processPayment(
                    $order,
                    'qr_payment',
                    $request->only(['payment_method', 'payment_gateway'])
                );

                return redirect()
                    ->route('orders.qr-payment', $order)
                    ->with('success', 'Por favor completa el pago escaneando el código QR.');
            }

            if ($request->payment_method === 'cash_on_delivery') {
                return redirect()
                    ->route('orders.confirmation', $order)
                    ->with('success', '¡Orden creada exitosamente! Pagarás contra entrega.');
            }

            // Otros métodos de pago
            return redirect()
                ->route('orders.confirmation', $order)
                ->with('success', '¡Orden creada exitosamente!');

        } catch (\Exception $e) {
            \Log::error('Error en checkout: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error al procesar la orden: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function confirmation($order)
    {
        $order = \App\Models\Order::with(['items.product', 'shippingAddress', 'payment'])
            ->where('id', $order)
            ->firstOrFail();

        return view('landing.orders.confirmation', compact('order'));
    }

    /**
     * Vista de pago QR
     */
    public function qrPayment($order)
    {
        $order = \App\Models\Order::with(['items.product', 'payment'])
            ->where('id', $order)
            ->firstOrFail();

        return view('landing.orders.qr-payment', compact('order'));
    }

    /**
     * Calcular costo de envío
     */
    protected function calculateShipping(string $city): float
    {
        $mainCities = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla'];

        if (in_array($city, $mainCities)) {
            return 15000; // $15.000
        }

        return 25000; // $25.000
    }
}
