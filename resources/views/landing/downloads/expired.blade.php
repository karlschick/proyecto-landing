@extends('landing.layout')

@section('title', 'Link Expirado')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 flex items-center">
    <div class="container mx-auto px-4 max-w-lg">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Icono de Error -->
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-4">
                Link de Descarga No Disponible
            </h1>

            @if($download->expires_at && $download->expires_at->isPast())
                <p class="text-gray-600 mb-6">
                    Este link de descarga expiró el <strong>{{ $download->expires_at->format('d/m/Y') }}</strong>
                </p>
            @else
                <p class="text-gray-600 mb-6">
                    Has alcanzado el límite de <strong>{{ $download->max_downloads }} descargas</strong> para este producto.
                </p>
            @endif

            <!-- Información del producto -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-700 mb-1">Producto:</p>
                <p class="font-semibold text-gray-900">{{ $download->product->name }}</p>
                <p class="text-xs text-gray-500 mt-2">Orden #{{ $download->order->order_number }}</p>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-red-50 rounded-lg p-3">
                    <div class="text-2xl font-bold text-red-600">
                        {{ $download->downloads_count }}
                    </div>
                    <div class="text-xs text-gray-600">Descargas Usadas</div>
                </div>
                <div class="bg-gray-100 rounded-lg p-3">
                    <div class="text-2xl font-bold text-gray-400">
                        {{ $download->max_downloads }}
                    </div>
                    <div class="text-xs text-gray-600">Límite Total</div>
                </div>
            </div>

            <!-- Ayuda -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-900 font-semibold mb-2">
                    ¿Necesitas acceso nuevamente?
                </p>
                <p class="text-sm text-blue-800">
                    Contáctanos y con gusto te ayudaremos a recuperar tu acceso.
                </p>
            </div>

            <!-- Botones -->
            <div class="space-y-3">
                <a href="mailto:{{ \App\Models\Setting::getSettings()->contact_email ?? 'soporte@example.com' }}"
                   class="w-full inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    Contactar Soporte
                </a>
                <a href="{{ route('shop.index') }}"
                   class="w-full inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                    Volver a la Tienda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
