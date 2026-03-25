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

        <!-- Instrucciones Bre-b -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-6 border-2 border-blue-300">
            <div class="flex items-center mb-4">
                <div class="text-4xl mr-4">🔑</div>
                <div>
                    <h3 class="text-2xl font-bold text-blue-900">Pago con Bre-b (Llave)</h3>
                    <p class="text-blue-700">Sigue estos pasos para completar tu pago</p>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="font-bold text-lg mb-2">📱 Paso 1: Abre tu app Bre-b</h4>
                    <p class="text-gray-700">Ingresa a tu aplicación Bre-b en tu celular</p>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="font-bold text-lg mb-2">🔍 Paso 2: Busca el comercio</h4>
                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4 my-3">
                        <p class="font-bold text-gray-800 mb-2">Comercio:</p>
                        <p class="text-2xl font-mono bg-white px-3 py-2 rounded border-2 border-yellow-400 inline-block">
                            {{ $paymentInfo['comercio'] ?? 'SKUBOXIT' }}
                        </p>
                    </div>
                    <p class="text-gray-700">o utiliza la llave:</p>
                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4 my-3">
                        <p class="font-bold text-gray-800 mb-2">Llave Bre-b:</p>
                        <p class="text-xl font-mono bg-white px-3 py-2 rounded border-2 border-yellow-400 inline-block">
                            {{ $paymentInfo['key'] ?? '0091257502' }}
                        </p>
                    </div>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="font-bold text-lg mb-2">💰 Paso 3: Ingresa el monto</h4>
                    <div class="bg-green-50 border border-green-200 rounded p-4 my-3">
                        <p class="font-bold text-gray-800 mb-2">Monto a pagar:</p>
                        <p class="text-3xl font-bold text-green-600">
                            ${{ number_format($order->total, 0) }} COP
                        </p>
                    </div>
                </div>

                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="font-bold text-lg mb-2">✅ Paso 4: Confirma el pago</h4>
                    <p class="text-gray-700">Revisa que los datos sean correctos y confirma la transacción</p>
                </div>

                <div class="border-l-4 border-green-500 pl-4 bg-green-50 p-4 rounded">
                    <h4 class="font-bold text-lg mb-2">📸 Paso 5: Guarda tu comprobante</h4>
                    <p class="text-gray-700 mb-2">Después de realizar el pago:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li>Toma una captura de pantalla del comprobante</li>
                        <li>Asegúrate de que se vea el número de referencia</li>
                        <li>Guarda el monto y la fecha de la transacción</li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Importante:</strong> Una vez realizado el pago, debes subir tu comprobante para que podamos verificar y procesar tu pedido.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                <p><strong>Número de Referencia:</strong> {{ $order->payment->reference }}</p>
                <p class="mt-1"><strong>WhatsApp Soporte:</strong> {{ $paymentInfo['phone'] ?? '311 576 5959' }}</p>
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
