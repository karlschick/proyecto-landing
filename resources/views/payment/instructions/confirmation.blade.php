<x-guest-simple-layout>
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <div class="inline-block p-4 bg-green-100 rounded-full mb-4">
            <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h2 class="text-3xl font-bold mb-4">¡Comprobante Recibido!</h2>

        <p class="text-gray-600 mb-6">
            Hemos recibido tu comprobante de pago exitosamente.
        </p>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="font-bold mb-4">Información de tu Orden</h3>
            <div class="space-y-2 text-left">
                <div class="flex justify-between">
                    <span class="text-gray-600">Número de Orden:</span>
                    <span class="font-bold">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Referencia de Pago:</span>
                    <span class="font-bold">{{ $order->payment->reference }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold">${{ number_format($order->total, 0) }} COP</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Estado:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $order->payment->getStatusBadgeClass() }}">
                        {{ $order->payment->getStatusText() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <h4 class="font-bold mb-2">🕐 ¿Qué Sigue?</h4>
            <p class="text-sm text-gray-700">
                Nuestro equipo revisará tu pago en las próximas <strong>24 horas</strong>.
                Una vez aprobado, procederemos con el envío de tu pedido y recibirás un correo
                electrónico con la información de seguimiento.
            </p>
        </div>

        {{-- COMPROBANTE --}}
        @if($order->payment->receipt_path)
            @php
                $receiptUrl = $order->payment->getReceiptUrl();
            @endphp

            <div class="mb-6">
                <h4 class="font-bold mb-3 text-lg">📸 Tu Comprobante de Pago</h4>

                @if($receiptUrl)
                    <div class="border-2 border-blue-300 rounded-lg p-4 bg-blue-50 inline-block">
                        <img src="{{ $receiptUrl }}"
                             alt="Comprobante de Pago"
                             class="max-w-xs mx-auto rounded-lg shadow-lg"
                             onerror="this.parentElement.innerHTML='<div class=\'bg-red-50 border border-red-300 rounded p-4\'><p class=\'text-red-600 font-bold\'>❌ Error al cargar la imagen</p></div>'">
                    </div>

                    <div class="mt-4">
                        <a href="{{ $receiptUrl }}"
                           target="_blank"
                           download
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Descargar Comprobante
                        </a>
                    </div>
                @else
                    <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-6">
                        <p class="text-yellow-700 font-bold">⚠️ Comprobante registrado pero no visible</p>
                        <p class="text-xs text-yellow-600 mt-2">Path: {{ $order->payment->receipt_path }}</p>
                        <p class="text-xs text-yellow-600 mt-1">
                            Ejecuta: <code class="bg-yellow-200 px-2 py-1 rounded">php artisan storage:link</code>
                        </p>
                    </div>
                @endif
            </div>
        @else
            <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-6 mb-6">
                <p class="text-gray-600 font-bold">📭 Sin Comprobante</p>
                <p class="text-sm text-gray-500 mt-2">No se encontró comprobante de pago</p>
            </div>
        @endif

        <div class="space-y-3">
            <p class="text-sm text-gray-600">
                Si tienes alguna pregunta, contáctanos:<br>
                <strong>WhatsApp:</strong> 311 576 5959<br>
                <strong>Email:</strong> ventas@skuboxIT.com
            </p>

            <a href="{{ route('home') }}"
               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Volver al Inicio
            </a>
        </div>
    </div>
</div>
</x-guest-simple-layout>
