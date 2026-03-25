<x-guest-simple-layout>
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-600">
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600">Tienda</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium">Instrucciones de Pago</span>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Instrucciones de Pago</h1>
                    <p class="text-gray-600">Orden #{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Total a pagar</p>
                    <p class="text-3xl font-bold text-blue-600">${{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Instrucciones QR -->
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-6 border-2 border-purple-300">
            <div class="flex items-center mb-4">
                <div class="text-4xl mr-4">📱</div>
                <div>
                    <h3 class="text-2xl font-bold text-purple-900">Pago con Código QR</h3>
                    <p class="text-purple-700">Escanea y paga desde tu celular</p>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6">
                <div class="text-center mb-6">
                    <h4 class="font-bold text-lg mb-4">Escanea este código QR:</h4>

                    @if(!empty($paymentInfo['qr_image']) && file_exists(public_path($paymentInfo['qr_image'])))
                        <div class="inline-block p-6 bg-white border-4 border-purple-300 rounded-lg shadow-lg">
                            <img src="{{ asset($paymentInfo['qr_image']) }}"
                                 alt="Código QR de Pago"
                                 class="w-64 h-64 mx-auto">
                        </div>
                    @else
                        <div class="inline-block p-6 bg-gray-100 border-4 border-purple-300 rounded-lg shadow-lg">
                            <div class="w-64 h-64 flex items-center justify-center text-gray-400">
                                <div class="text-center">
                                    <svg class="w-32 h-32 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                    <p class="text-sm font-semibold">Código QR Daviplata</p>
                                    <p class="text-xs mt-2">+57 311 893 9652</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-green-50 border border-green-300 rounded-lg p-4 mt-6 inline-block">
                        <p class="text-sm text-gray-600 mb-1">Monto a Pagar</p>
                        <p class="text-3xl font-bold text-green-600">${{ number_format($order->total, 0) }} COP</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mt-6">
                    <h4 class="font-bold text-lg mb-3">📝 Instrucciones:</h4>
                    <ol class="space-y-3">
                        <li class="flex items-start">
                            <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">1</span>
                            <span class="text-gray-700">Abre tu aplicación Daviplata, Nequi o bancaria en tu celular</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">2</span>
                            <span class="text-gray-700">Busca la opción "Pagar con QR" o "Escanear código QR"</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">3</span>
                            <span class="text-gray-700">Escanea el código QR mostrado arriba o envía a: <strong>+57 311 893 9652</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">4</span>
                            <span class="text-gray-700">Verifica que el monto sea <strong>${{ number_format($order->total, 0) }}</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-purple-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">5</span>
                            <span class="text-gray-700">Confirma el pago en tu app</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">6</span>
                            <span class="text-gray-700">Toma captura de pantalla del comprobante</span>
                        </li>
                    </ol>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mt-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h5 class="font-bold mb-2">✅ Apps compatibles:</h5>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Daviplata</li>
                            <li>• Nequi</li>
                            <li>• Bancolombia</li>
                            <li>• BBVA</li>
                            <li>• Davivienda</li>
                            <li>• Y muchas más...</li>
                        </ul>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h5 class="font-bold mb-2">⚡ Ventajas:</h5>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Pago rápido y seguro</li>
                            <li>• Sin necesidad de datos bancarios</li>
                            <li>• Confirmación inmediata</li>
                            <li>• Desde cualquier banco</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded mt-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Importante:</strong> Después de realizar el pago, asegúrate de subir tu comprobante para que podamos verificar y procesar tu pedido.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                <p><strong>Número de Orden:</strong> {{ $order->order_number }}</p>
                <p class="mt-1"><strong>Referencia de Pago:</strong> {{ $order->payment->reference }}</p>
                <p class="mt-2"><strong>Daviplata:</strong> +57 311 893 9652</p>
            </div>
        </div>

        <!-- Botón de subir comprobante -->
        <div class="mt-8 text-center">
            <a href="{{ route('payment.upload-form', $order->id) }}"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition shadow-lg">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Subir Comprobante de Pago
            </a>
            <p class="text-sm text-gray-500 mt-2">Una vez realizado el pago, sube tu comprobante para verificación</p>
        </div>

        <!-- Ayuda -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <h3 class="font-bold text-gray-900 mb-2">¿Necesitas ayuda?</h3>
            <p class="text-gray-700 mb-4">Nuestro equipo está disponible para asistirte</p>
            <div class="flex justify-center gap-4">
                <a href="https://wa.me/573118939652" target="_blank"
                   class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
</x-guest-simple-layout>
