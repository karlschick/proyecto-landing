<x-guest-simple-layout>
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold mb-6">Subir Comprobante de Pago</h2>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-800">
                <strong>Orden:</strong> {{ $order->order_number }}<br>
                <strong>Total:</strong> ${{ number_format($order->total, 0) }} COP
            </p>
        </div>

        <form action="{{ route('payment.upload', $order->payment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Referencia de Pago de Daviplata *
                    </label>
                    <input type="text" name="payment_reference"
                           value="{{ old('payment_reference', $order->payment->reference ?? '') }}"
                           required
                           placeholder="Ej: 1234567890"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">
                        Ingresa el número de referencia que aparece en tu comprobante de Daviplata
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Comprobante de Pago (Captura de Pantalla) *
                    </label>
                    <input type="file" name="receipt" accept="image/*" required
                           class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">
                        Formatos permitidos: JPG, PNG. Tamaño máximo: 5MB
                    </p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="font-bold text-sm mb-2">📸 Consejos para tu captura:</h4>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>• Asegúrate de que se vea el monto pagado</li>
                        <li>• Incluye la fecha y hora de la transacción</li>
                        <li>• La imagen debe estar clara y legible</li>
                        <li>• Incluye el número de referencia</li>
                    </ul>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                    Enviar Comprobante
                </button>
            </div>
        </form>
    </div>
</div>
</x-guest-simple-layout>
