<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use App\Services\PaymentService;
use App\Mail\PaymentApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    // ============================================
    // FLUJO PÚBLICO - CLIENTE
    // ============================================

    /**
     * Paso 1: Mostrar productos
     */
    public function index()
    {
        $products = Product::where('is_active', true)->get();

        // Productos de ejemplo si no hay en BD
        if ($products->isEmpty()) {
            $products = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Curso Completo de Laravel',
                    'description' => 'Aprende Laravel desde cero hasta nivel avanzado.',
                    'type' => 'digital',
                    'price' => 150000,
                    'image' => '💻',
                    'sku' => 'CURSO-LARAVEL-001'
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Proteína Whey Premium 2kg',
                    'description' => 'Proteína de suero de leche de alta calidad.',
                    'type' => 'physical',
                    'price' => 150000,
                    'image' => '💪',
                    'sku' => 'PROT-WP-2KG'
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Consultoría Personalizada',
                    'description' => 'Servicio de consultoría para tu negocio.',
                    'type' => 'service',
                    'price' => 200000,
                    'image' => '🛠️',
                    'sku' => 'SERV-CONSULT'
                ]
            ]);
        }

        return view('payment.product', compact('products'));
    }

    /**
     * Paso 2: Seleccionar método de pago (POST)
     */
    public function selectPaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'product_type' => 'required|in:digital,physical,service',
            'product_id' => 'required',
        ]);

        session([
            'checkout_product_type' => $validated['product_type'],
            'checkout_product_id' => $validated['product_id'],
        ]);

        return view('payment.select-method', [
            'product_type' => $validated['product_type']
        ]);
    }

    /**
     * Paso 2b: Mostrar página de selección de método (GET)
     */
    public function showSelectMethodPage()
    {
        $productType = session('checkout_product_type');
        $productId = session('checkout_product_id');

        if (!$productType || !$productId) {
            return redirect()->route('payment.index')
                ->with('error', 'Por favor selecciona un producto primero.');
        }

        return view('payment.select-method', [
            'product_type' => $productType
        ]);
    }

    /**
     * Paso 3: Redirigir a formulario específico según método
     */
    public function showCheckoutForm(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:manual_breb,manual_transfer,manual_qr,card',
        ]);

        $productType = session('checkout_product_type');
        $paymentMethod = $validated['payment_method'];

        session(['checkout_payment_method' => $paymentMethod]);

        $viewData = [
            'product_type' => $productType,
            'payment_method' => $paymentMethod,
            'needs_shipping' => $productType === 'physical'
        ];

        // Redirigir a vista específica según método
        switch ($paymentMethod) {
            case 'manual_breb':
                return view('payment.methods.breb', $viewData);

            case 'manual_transfer':
                return view('payment.methods.transfer', $viewData);

            case 'manual_qr':
                return view('payment.methods.qr', $viewData);

            case 'card':
                return view('payment.methods.card', $viewData);

            default:
                return view('payment.checkout-form', $viewData);
        }
    }

    /**
     * Paso 4: Crear orden
     */
    public function createOrder(Request $request)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:manual_breb,manual_transfer,manual_qr,card',
        ];

        // Validar dirección solo para productos físicos
        if ($request->product_type === 'physical') {
            $rules['address'] = 'required|string';
            $rules['city'] = 'required|string';
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            // Obtener producto
            $product = Product::find(session('checkout_product_id'));
            $productPrice = $product ? $product->price : 150000;
            $productName = $product ? $product->name : "Producto";
            $productType = $request->product_type ?? session('checkout_product_type');

            $quantity = $validated['quantity'];
            $subtotal = $productPrice * $quantity;

            // Envío solo para productos físicos
            $shippingCost = $productType === 'physical' ? 15000 : 0;
            $total = $subtotal + $shippingCost;

            // Crear orden
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'product_type' => $productType,
                'subtotal' => $subtotal,
                'tax' => 0,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'currency' => 'COP',
            ]);

            // Crear item de la orden
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product ? $product->id : null,
                'product_name' => $productName,
                'product_sku' => $product ? $product->sku : 'PROD-' . uniqid(),
                'quantity' => $quantity,
                'price' => $productPrice,
                'subtotal' => $subtotal,
            ]);

            // Crear dirección de envío/contacto
            $addressData = [
                'order_id' => $order->id,
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'country' => 'Colombia',
            ];

            if ($productType === 'physical') {
                $addressData['address_line_1'] = $validated['address'];
                $addressData['city'] = $validated['city'];
            }

            ShippingAddress::create($addressData);

            // Crear registro de pago
            $payment = $this->paymentService->createPayment(
                $order,
                $validated['payment_method']
            );

            DB::commit();

            // Limpiar sesión
            session()->forget(['checkout_product_type', 'checkout_product_id', 'checkout_payment_method']);

            return redirect()->route('payment.instructions', $order->id)
                ->with('success', 'Orden creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creando orden: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Paso 5: Instrucciones de pago
     */
    public function showInstructions($orderId)
    {
        $order = Order::with(['items', 'shippingAddress', 'payment'])->findOrFail($orderId);

        // Obtener información del método de pago
        $paymentInfo = $this->paymentService->getPaymentInfo($order->payment->method);

        return view('payment.instructions', compact('order', 'paymentInfo'));
    }

    /**
     * Paso 6: Formulario para subir comprobante
     * Vista ubicada en: resources/views/payment/instructions/upload.blade.php
     */
    public function showUploadForm($orderId)
    {
        $order = Order::with('payment')->findOrFail($orderId);

        return view('payment.instructions.upload', compact('order'));
    }

    /**
     * Paso 6b: Procesar subida de comprobante
     */
    public function subirComprobante(Request $request, $paymentId)
    {
        $payment = Payment::with('order')->findOrFail($paymentId);

        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'payment_reference' => 'nullable|string|max:255',
        ]);

        try {
            // Actualizar referencia si se proporciona
            if ($request->filled('payment_reference')) {
                $payment->update(['reference' => $request->payment_reference]);
            }

            // Subir comprobante
            $path = $this->paymentService->uploadReceipt($payment, $request->file('receipt'));

            // Actualizar estado del pago
            $payment->update(['status' => 'pending']);

            Log::info('Comprobante subido', [
                'payment_id' => $payment->id,
                'order_number' => $payment->order->order_number,
                'path' => $path
            ]);

            return redirect()->route('payment.confirmation', $payment->order->id)
                ->with('success', 'Comprobante enviado correctamente. Revisaremos tu pago pronto.');

        } catch (\Exception $e) {
            Log::error('Error subiendo comprobante: ' . $e->getMessage());
            return back()->with('error', 'Error al subir el comprobante: ' . $e->getMessage());
        }
    }

    /**
     * Paso 7: Confirmación de pago enviado
     */
    public function confirmation($orderId)
    {
        $order = Order::with(['items', 'payment', 'shippingAddress'])->findOrFail($orderId);

        return view('payment.instructions.confirmation', compact('order')); // ← corregido
    }

    // ============================================
    // PANEL DE ADMINISTRACIÓN
    // ============================================

    /**
     * Listar todos los pagos
     */
    public function adminIndex()
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para acceder al panel de administración.');
        }

        $payments = Payment::with(['order.items', 'order.shippingAddress'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Listar pagos pendientes de QR Daviplata
     */
    public function pending()
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        $payments = Payment::with(['order.items', 'order.shippingAddress'])
            ->where('payment_method', 'qr_payment')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.payments.pending', compact('payments'));
    }

    /**
     * Verificar/Aprobar pago QR
     */
    public function verify(Request $request, Payment $payment)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar pago
            $payment->update([
                'status' => 'approved',
                'transaction_reference' => $request->transaction_reference,
                'admin_notes' => $request->notes,
                'verified_at' => now(),
                'verified_by' => auth()->id()
            ]);

            // Actualizar orden
            $payment->order->update(['status' => 'paid']);

            DB::commit();

            Log::info('Pago QR verificado', [
                'payment_id' => $payment->id,
                'order_number' => $payment->order->order_number,
                'verified_by' => auth()->user()->name
            ]);

            return redirect()->route('admin.payments.pending')
                ->with('success', '✅ Pago verificado y aprobado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error verificando pago: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar pago QR
     */
    public function reject(Request $request, Payment $payment)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar pago
            $payment->update([
                'status' => 'rejected',
                'admin_notes' => $request->rejection_reason,
                'rejected_at' => now(),
                'rejected_by' => auth()->id()
            ]);

            // Cancelar orden
            $payment->order->update(['status' => 'cancelled']);

            DB::commit();

            Log::info('Pago QR rechazado', [
                'payment_id' => $payment->id,
                'order_number' => $payment->order->order_number,
                'reason' => $request->rejection_reason,
                'rejected_by' => auth()->user()->name
            ]);

            return redirect()->route('admin.payments.pending')
                ->with('success', '❌ Pago rechazado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error rechazando pago: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Aprobar pago y enviar email
     */
    public function aprobar(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        $request->validate([
            'delivery_link' => 'nullable|url|max:500',
        ]);

        try {
            $payment = Payment::with(['order.items', 'order.shippingAddress'])->findOrFail($id);
            $deliveryLink = $request->input('delivery_link');

            // Guardar link de entrega en la orden
            if (!empty($deliveryLink)) {
                $payment->order->delivery_link = $deliveryLink;
                $payment->order->save();
            }

            // Aprobar pago
            $payment->update(['status' => 'approved']);
            $payment->order->update(['status' => 'paid']);

            // Refrescar datos
            $payment->refresh();
            $payment->load(['order.items', 'order.shippingAddress']);

            // Enviar email de confirmación
            $customerEmail = $payment->order->shippingAddress->email ?? null;

            if ($customerEmail) {
                Mail::to($customerEmail)->send(new PaymentApproved($payment, $deliveryLink));

                Log::info('Pago aprobado y email enviado', [
                    'payment_id' => $payment->id,
                    'order_number' => $payment->order->order_number,
                    'email' => $customerEmail,
                    'delivery_link' => $deliveryLink
                ]);
            }

            return back()->with('success', '✅ Pago aprobado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error aprobando pago: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar pago
     */
    public function rechazar(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        $request->validate(['reason' => 'nullable|string|max:500']);

        try {
            $payment = Payment::findOrFail($id);
            $reason = $request->input('reason', 'Pago rechazado por el administrador');

            // Rechazar pago
            $payment->update([
                'status' => 'rejected',
                'admin_notes' => $reason
            ]);

            $payment->order->update(['status' => 'payment_rejected']);

            Log::info('Pago rechazado', [
                'payment_id' => $payment->id,
                'order_number' => $payment->order->order_number,
                'reason' => $reason,
                'rejected_by' => auth()->user()->name ?? 'Admin'
            ]);

            return back()->with('success', '❌ Pago rechazado.');

        } catch (\Exception $e) {
            Log::error('Error rechazando pago: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ============================================
    // INSTRUCCIONES POR MÉTODO DE PAGO
    // ============================================

    /**
     * Mostrar instrucciones Transferencia Bancaria
     */
    public function showInstructionsTransfer($orderId)
    {
        $order = Order::with(['payment', 'items.product', 'shippingAddress'])->findOrFail($orderId);
        $paymentInfo = [
            'bank' => 'Bancolombia',
            'account_type' => 'Ahorros',
            'account_number' => '12345678901',
            'holder' => 'SkuboxIT SAS',
            'nit' => '900123456-7'
        ];
        return view('payment.instructions.transfer', compact('order', 'paymentInfo'));
    }

    /**
     * Mostrar instrucciones QR Daviplata
     */
    public function showInstructionsQr($orderId)
    {
        $order = Order::with(['payment', 'items.product', 'shippingAddress'])->findOrFail($orderId);
        $paymentInfo = [
            'qr_image' => '/images/qr/qrbreb.jpg',
            'phone' => '+57 311 893 9652',
            'name' => 'Daviplata'
        ];
        return view('payment.instructions.qr', compact('order', 'paymentInfo'));
    }

    /**
     * Mostrar instrucciones Tarjeta
     */
    public function showInstructionsCard($orderId)
    {
        $order = Order::with(['payment', 'items.product', 'shippingAddress'])->findOrFail($orderId);
        $paymentInfo = [];
        return view('payment.instructions.card', compact('order', 'paymentInfo'));
    }

    /**
     * Mostrar instrucciones Breb
     */
    public function showInstructionsBreb($orderId)
    {
        $order = Order::with(['payment', 'items.product', 'shippingAddress'])->findOrFail($orderId);
        $paymentInfo = [
            'bank'           => 'Breb',
            'account_type'   => 'Ahorros',
            'account_number' => 'XXXXXXXXXXXX', // Reemplaza con tu número real
            'holder'         => 'Tu Nombre o Empresa',
            'phone'          => '+57 311 893 9652',
        ];
        return view('payment.instructions.breb', compact('order', 'paymentInfo'));
    }
}
