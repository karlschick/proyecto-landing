<x-app-layout>

@section('title', 'Confirmación de Orden')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Mensaje de Éxito -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">¡Pedido Confirmado!</h1>
                <p class="text-lg text-gray-600 mb-6">
                    Hemos recibido tu orden exitosamente.
                    Te enviaremos una confirmación por email.
                </p>
                <div class="inline-block bg-blue-50 px-6 py-3 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Número de orden</p>
                    <p class="text-2xl font-bold text-blue-600">#{{ $order->order_number }}</p>
                </div>
            </div>

            <!-- Detalles de la Orden -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Detalles de tu Pedido</h2>
                </div>

                <div class="p-6">
                    <!-- Productos -->
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        @foreach($order->items as $item)
                        <div class="flex gap-4">
                            @if($item->product)
                            <img src="{{ $item->product->getFeaturedImageUrl() }}"
                                 alt="{{ $item->product_name }}"
                                 class="w-20 h-20 object-cover rounded-lg">
                            @else
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                                <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                                <p class="text-sm text-gray-600">Cantidad: {{ $item->quantity }} x ${{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">${{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totales -->
                    <div class="space-y-2 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span class="font-semibold">${{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>IVA (19%):</span>
                            <span class="font-semibold">${{ number_format($order->tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Envío:</span>
                            <span class="font-semibold">${{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between text-2xl font-bold text-gray-900 mb-6">
                        <span>Total:</span>
                        <span class="text-blue-600">${{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Dirección de Envío -->
                    @if($order->shippingAddress)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-3">Dirección de Envío</h3>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p class="font-medium">{{ $order->shippingAddress->full_name }}</p>
                            <p>{{ $order->shippingAddress->phone }}</p>
                            <p>{{ $order->shippingAddress->email }}</p>
                            <p class="mt-2">{{ $order->shippingAddress->getFullAddress() }}</p>
                            @if($order->shippingAddress->notes)
                            <div class="mt-3 p-3 bg-yellow-50 rounded">
                                <p class="text-xs font-medium text-yellow-800">Notas de entrega:</p>
                                <p class="text-sm text-yellow-700">{{ $order->shippingAddress->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Información de Pago -->
            @if($order->payment)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Método de Pago</h3>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 capitalize">
                            {{ str_replace('_', ' ', $order->payment->payment_method) }}
                        </p>
                        @if($order->payment->payment_method === 'cash_on_delivery')
                        <p class="text-sm text-gray-600">Pagarás en efectivo al recibir tu pedido</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Próximos Pasos -->
            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">¿Qué sigue?</h3>
                <div class="space-y-3 text-sm text-gray-700">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">
                            1
                        </div>
                        <div>
                            <p class="font-semibold">Confirmación por Email</p>
                            <p class="text-gray-600">Te enviaremos los detalles de tu pedido a {{ $order->shippingAddress->email ?? 'tu correo' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">
                            2
                        </div>
                        <div>
                            <p class="font-semibold">Procesamiento</p>
                            <p class="text-gray-600">Verificaremos y prepararemos tu pedido (1-2 días hábiles)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">
                            3
                        </div>
                        <div>
                            <p class="font-semibold">Envío</p>
                            <p class="text-gray-600">Tu pedido será enviado a la dirección proporcionada</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">
                            4
                        </div>
                        <div>
                            <p class="font-semibold">Entrega</p>
                            <p class="text-gray-600">Recibirás tu pedido en 3-5 días hábiles</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-center transition">
                    Seguir Comprando
                </a>
                @auth
                <a href="{{ route('dashboard') }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-semibold text-center transition">
                    Ver Mis Órdenes
                </a>
                @endauth
            </div>

            <!-- Contacto -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>¿Tienes preguntas sobre tu pedido?</p>
                <p class="mt-1">
                    Contáctanos:
                    <a href="mailto:soporte@tutienda.com" class="text-blue-600 hover:text-blue-800 font-medium">soporte@tutienda.com</a>
                    o al
                    <a href="tel:+573001234567" class="text-blue-600 hover:text-blue-800 font-medium">+57 300 123 4567</a>
                </p>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
