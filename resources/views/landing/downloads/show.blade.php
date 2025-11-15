@extends('landing.layout')

@section('title', 'Descargar ' . $download->product->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-white text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-2">Tu Descarga Está Lista</h1>
                <p class="text-blue-100">Orden #{{ $download->order->order_number }}</p>
            </div>

            <!-- Contenido -->
            <div class="p-8">
                <!-- Información del Producto -->
                <div class="mb-8">
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                        @if($download->product->featured_image)
                        <img src="{{ $download->product->getFeaturedImageUrl() }}"
                             alt="{{ $download->product->name }}"
                             class="w-24 h-24 object-cover rounded-lg shadow-md">
                        @endif
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-gray-900 mb-2">
                                📚 {{ $download->product->name }}
                            </h2>
                            @if($download->product->short_description)
                            <p class="text-sm text-gray-600 mb-2">
                                {{ $download->product->short_description }}
                            </p>
                            @endif
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span>📄 PDF</span>
                                @if($download->product->file_size)
                                <span>💾 {{ $download->product->getFileSizeFormatted() }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas de Descarga -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-1">
                            {{ $download->getRemainingDownloads() }}
                        </div>
                        <div class="text-sm text-gray-600">Descargas Restantes</div>
                        <div class="text-xs text-gray-500 mt-1">
                            de {{ $download->max_downloads }} totales
                        </div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-1">
                            {{ $download->getRemainingDays() }}
                        </div>
                        <div class="text-sm text-gray-600">Días Disponible</div>
                        <div class="text-xs text-gray-500 mt-1">
                            hasta {{ $download->expires_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <!-- Botón de Descarga -->
                <form action="{{ route('downloads.file', $download->download_token) }}" method="GET">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar Ahora
                    </button>
                </form>

                <!-- Información Importante -->
                <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm">
                            <p class="font-semibold text-yellow-800 mb-1">⚠️ Importante</p>
                            <ul class="text-yellow-700 space-y-1">
                                <li>• Este link es personal e intransferible</li>
                                <li>• Guarda este correo/link en un lugar seguro</li>
                                <li>• Si tienes problemas, contáctanos</li>
                                <li>• El archivo se descargará automáticamente al hacer clic</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Historial (si ya descargó) -->
                @if($download->downloads_count > 0)
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">📊 Historial:</span>
                        Has descargado este archivo {{ $download->downloads_count }}
                        {{ $download->downloads_count == 1 ? 'vez' : 'veces' }}
                    </p>
                    @if($download->last_downloaded_at)
                    <p class="text-xs text-gray-500 mt-1">
                        Última descarga: {{ $download->last_downloaded_at->diffForHumans() }}
                    </p>
                    @endif
                </div>
                @endif

                <!-- Soporte -->
                <div class="mt-8 pt-6 border-t text-center">
                    <p class="text-sm text-gray-600 mb-3">¿Necesitas ayuda?</p>
                    <a href="mailto:{{ \App\Models\Setting::getSettings()->contact_email ?? 'soporte@example.com' }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contactar Soporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Enlace al sitio -->
        <div class="text-center mt-8">
            <a href="{{ route('shop.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                ← Volver a la tienda
            </a>
        </div>
    </div>
</div>
@endsection
