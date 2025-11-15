@extends('landing.layout')

@section('title', 'Carrito de Compras')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Carrito de Compras</h1>

        @if($cart->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Tu carrito está vacío</h2>
            <p class="text-gray-500 mb-8">Explora nuestra tienda y encuentra productos increíbles</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition">
                Ir a la Tienda
            </a>
        </div>
        @else
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Items del Carrito -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">
                                Productos ({{ $cart->getTotalItems() }})
                            </h2>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('¿Estás seguro de vaciar el carrito?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    Vaciar carrito
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="divide-y divide-gray-200">
                        @foreach($cart->items as $item)
                        <div class="p-6">
                            <div class="flex gap-4">
                                <!-- Imagen -->
                                <div class="flex-shrink-0">
                                    <a href="{{ route('shop.show', $item->product->slug) }}">
                                        <img src="{{ $item->product->getFeaturedImageUrl() }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-24 h-24 object-cover rounded-lg">
                                    </a>
                                </div>

                                <!-- Información -->
                                <div class="flex-1">
                                    <a href="{{ route('shop.show', $item->product->slug) }}" class="block">
                                        <h3 class="font-semibold text-gray-900 hover:text-blue-600 transition mb-1">
                                            {{ $item->product->name }}
                                        </h3>
                                    </a>
                                    <p class="text-sm text-gray-600 mb-2">SKU: {{ $item->product->sku }}</p>

                                    <!-- Precio unitario -->
                                    <p class="text-lg font-bold text-blue-600 mb-3">
                                        ${{ number_format($item->price, 0, ',', '.') }}
                                        <span class="text-sm text-gray-500 font-normal">c/u</span>
                                    </p>

                                    <!-- Controles -->
                                    <div class="flex items-center gap-4">
                                        <!-- Cantidad -->
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                <button type="submit" class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    </svg>
                                                </button>
                                            </form>

                                            <input type="number" value="{{ $item->quantity }}" readonly
                                                   class="w-16 text-center border-0 focus:ring-0 py-2">

                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                <button type="submit" class="px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Eliminar -->
                                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-600">
                                            Subtotal: <span class="font-bold text-gray-900">${{ number_format($item->getSubtotal(), 0, ',', '.') }}</span>
                                        </p>
                                        @if($item->product->isBook())
                                        <p class="text-xs text-green-600 mt-1">
                                            <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                            </svg>
                                            Libro - Exento de IVA
                                        </p>
                                        @endif
                                    </div>

                                    <!-- Advertencia de stock -->
                                    @if($item->product->track_quantity && $item->quantity >= $item->product->quantity)
                                    <div class="mt-2 text-sm text-orange-600">
                                        <svg class="inline w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        Última unidad disponible
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Continuar Comprando -->
                <div class="mt-6">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Continuar Comprando
                    </a>
                </div>
            </div>

            <!-- Resumen del Pedido -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Resumen del Pedido</h2>

                    <!-- Totales -->
                    <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span class="font-semibold">${{ number_format($cart->getSubtotal(), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>IVA (19%):</span>
                            <span class="font-semibold">${{ number_format($cart->getTax(), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Envío:</span>
                            <span class="font-semibold">Se calcula en checkout</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between text-xl font-bold text-gray-900 mb-6">
                        <span>Total:</span>
                        <span class="text-blue-600">${{ number_format($cart->getTotal(), 0, ',', '.') }}</span>
                    </div>

                    <!-- Botón de Checkout -->
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center px-6 py-4 rounded-lg font-bold text-lg transition mb-3">
                        Proceder al Pago
                    </a>

                    <!-- Información adicional -->
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Compra 100% segura</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Envío a toda Colombia</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Múltiples métodos de pago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
