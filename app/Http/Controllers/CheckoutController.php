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

        $cart->load('items.product');

        return view('landing.checkout.index', compact('cart'));
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

            // Calcular costo de envío (puedes implementar lógica más compleja)
            $shippingCost = $this->calculateShipping($request->city);

            // Crear orden
            $order = $this->orderService->createFromCart(
                $cart,
                $shippingData,
                $shippingCost
            );

            // Procesar pago
            $payment = $this->paymentService->processPayment(
                $order,
                $request->payment_method,
                $request->only(['payment_method', 'payment_gateway'])
            );

            // Si es pago contra entrega, marcar como pendiente
            if ($request->payment_method === 'cash_on_delivery') {
                return redirect()
                    ->route('orders.confirmation', $order)
                    ->with('success', '¡Orden creada exitosamente! Pagarás contra entrega.');
            }

            // Redirigir a pasarela de pago
            // TODO: Implementar integración con pasarela real
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
     * Calcular costo de envío
     */
    protected function calculateShipping(string $city): float
    {
        // TODO: Implementar lógica real de cálculo de envío
        $mainCities = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla'];

        if (in_array($city, $mainCities)) {
            return 15000; // $15.000
        }

        return 25000; // $25.000
    }
}
