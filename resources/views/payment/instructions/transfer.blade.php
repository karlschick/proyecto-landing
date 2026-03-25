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

        <!-- Instrucciones Transferencia -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-6 border-2 border-green-300">
            <div class="flex items-center mb-4">
                <div class="text-4xl mr-4">🏦</div>
                <div>
                    <h3 class="text-2xl font-bold text-green-900">Transferencia Bancaria</h3>
                    <p class="text-green-700">Datos para realizar tu transferencia</p>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Banco</p>
                        <p class="text-xl font-bold text-gray-800">{{ $paymentInfo['bank'] ?? 'Bancolombia' }}</p>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Tipo de Cuenta</p>
                        <p class="text-xl font-bold text-gray-800">{{ $paymentInfo['account_type'] ?? 'Ahorros' }}</p>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 md:col-span-2">
                        <p class="text-sm text-gray-600 mb-1">Número de Cuenta</p>
                        <p class="text-2xl font-mono font-bold text-gray-800">{{ $paymentInfo['account_number'] ?? '12345678901' }}</p>
                    </div>

                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Titular</p>
                        <p class="text-lg font-bold text-gray-800">{{ $paymentInfo['holder'] ?? 'SkuboxIT SAS' }}</p>
                    </div>

                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">NIT</p>
                        <p class="text-lg font-bold text-gray-800">{{ $paymentInfo['nit'] ?? '900123456-7' }}</p>
                    </div>

                    <div class="bg-green-50 border border-green-300 rounded-lg p-4 md:col-span-2">
                        <p class="text-sm text-gray-600 mb-1">Monto a Transferir</p>
                        <p class="text-3xl font-bold text-green-600">${{ number_format($order->total, 0) }} COP</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mt-6">
                    <h4 class="font-bold text-lg mb-3">📝 Instrucciones:</h4>
                    <ol class="space-y-3">
                        <li class="flex items-start">
                            <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">1</span>
                            <span class="text-gray-700">Ingresa a tu banca en línea o app bancaria</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">2</span>
                            <span class="text-gray-700">Selecciona la opción "Transferir" o "Enviar dinero"</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">3</span>
                            <span class="text-gray-700">Ingresa los datos bancarios mostrados arriba</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">4</span>
                            <span class="text-gray-700">Confirma el monto exacto: <strong>${{ number_format($order->total, 0) }}</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">5</span>
                            <span class="text-gray-700">Toma captura del comprobante de transferencia</span>
                        </li>
                    </ol>
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
                                <strong>Importante:</strong> El comprobante debe mostrar claramente:
                            </p>
                            <ul class="list-disc list-inside text-sm text-yellow-700 ml-4 mt-2">
                                <li>Número de referencia o CUS</li>
                                <li>Monto transferido</li>
                                <li>Fecha y hora</li>
                                <li>Cuenta destino</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                <p><strong>Número de Orden:</strong> {{ $order->order_number }}</p>
                <p class="mt-1"><strong>Referencia de Pago:</strong> {{ $order->payment->reference }}</p>
                <p class="mt-1 text-xs text-gray-500">Menciona este número si necesitas ayuda</p>
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
    </div>
</div>
</x-guest-simple-layout>
