@extends('landing.layout')

@section('title', 'Pago con QR')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pago con Código QR</h1>
                <p class="text-gray-600">Orden #{{ $order->id }}</p>
            </div>

            <!-- Instrucciones -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h2 class="font-bold text-blue-900 mb-3">📱 Instrucciones de Pago</h2>
                <ol class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start gap-2">
                        <span class="font-bold flex-shrink-0">1.</span>
                        <span>Abre tu aplicación bancaria o billetera digital</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold flex-shrink-0">2.</span>
                        <span>Selecciona la opción de pagar con QR</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold flex-shrink-0">3.</span>
                        <span>Escanea el código QR a continuación</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold flex-shrink-0">4.</span>
                        <span>Confirma el pago en tu aplicación</span>
                    </li>
                </ol>
            </div>

            <!-- Código QR -->
            <div class="text-center mb-8">
                <div class="inline-block p-8 bg-white border-4 border-gray-200 rounded-2xl shadow-lg">
                    <!-- TODO: Reemplazar con QR dinámico real -->
                    <img src="{{ asset('images/qr-placeholder.png') }}"
                         alt="Código QR de Pago"
                         class="w-64 h-64 mx-auto"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22256%22 height=%22256%22%3E%3Crect width=%22256%22 height=%22256%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2220%22 fill=%22%236b7280%22%3EQR Code%3C/text%3E%3C/svg%3E'">
                    <p class="text-sm text-gray-600 mt-4 font-mono">Código: {{ strtoupper(substr(md5($order->id), 0, 8)) }}</p>
                </div>
            </div>

            <!-- Detalles del pago -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="font-bold text-gray-900 mb-4">Detalles del Pago</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Monto a pagar:</span>
                        <span class="font-bold text-gray-900 text-lg">${{ number_format($order->total, 0, ',', '.') }} COP</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Beneficiario:</span>
                        <span class="font-semibold text-gray-900">FitnessUIT</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Concepto:</span>
                        <span class="font-semibold text-gray-900">Orden #{{ $order->id }}</span>
                    </div>
                </div>
            </div>

            <!-- Productos -->
            <div class="mb-8">
                <h3 class="font-bold text-gray-900 mb-4">📚 Productos que recibirás</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="flex gap-3 p-3 bg-gray-50 rounded-lg">
                        <img src="{{ $item->product->getFeaturedImageUrl() }}"
                             alt="{{ $item->product->name }}"
                             class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-600">Cantidad: {{ $item->quantity }}</p>
                            <span class="inline-block text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded mt-1">Acceso digital inmediato</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Información adicional -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold mb-1">⏰ Importante</p>
                        <p>Una vez realizado el pago, recibirás un email de confirmación con el acceso a tus productos digitales. El proceso puede tardar hasta 5 minutos.</p>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="space-y-3">
                <button onclick="window.location.reload()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold transition">
                    Ya realicé el pago
                </button>
                <a href="{{ route('orders.confirmation', $order) }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-center px-6 py-3 rounded-lg font-medium transition">
                    Ver detalles de la orden
                </a>
                <a href="{{ route('shop.index') }}" class="block text-center text-blue-600 hover:text-blue-800 font-medium text-sm">
                    Volver a la tienda
                </a>
            </div>

            <!-- Ayuda -->
            <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 mb-2">¿Tienes problemas con el pago?</p>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    Contactar soporte
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
