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

        <!-- Instrucciones Tarjeta -->
        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-lg p-6 border-2 border-indigo-300">
            <div class="flex items-center mb-4">
                <div class="text-4xl mr-4">💳</div>
                <div>
                    <h3 class="text-2xl font-bold text-indigo-900">Pago con Tarjeta</h3>
                    <p class="text-indigo-700">Pago seguro con tarjeta débito o crédito</p>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6">
                <!-- Información del monto -->
                <div class="bg-green-50 border border-green-300 rounded-lg p-4 mb-6 text-center">
                    <p class="text-sm text-gray-600 mb-1">Total a Pagar</p>
                    <p class="text-4xl font-bold text-green-600">${{ number_format($order->total, 0) }} COP</p>
                </div>

                <!-- Método en implementación -->
                <div class="bg-blue-50 border border-blue-300 rounded-lg p-6 text-center mb-6">
                    <div class="text-6xl mb-4">🚧</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Pasarela de Pago en Implementación</h4>
                    <p class="text-gray-600 mb-4">
                        Estamos integrando nuestro sistema de pago con tarjeta para ofrecerte una experiencia más completa y segura.
                    </p>
                    <div class="flex justify-center space-x-4 text-sm text-gray-500">
                        <span>✓ PayU</span>
                        <span>✓ MercadoPago</span>
                        <span>✓ Wompi</span>
                    </div>
                </div>

                <!-- Opción alternativa -->
                <div class="border-t pt-6">
                    <h4 class="font-bold text-lg mb-3 text-center">💡 Mientras tanto, puedes pagar con:</h4>

                    <div class="grid md:grid-cols-3 gap-4">
                        <a href="{{ route('payment.instructions.breb', $order->id) }}"
                           class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg p-4 text-center hover:from-blue-600 hover:to-blue-700 transition shadow-lg">
                            <div class="text-3xl mb-2">🔑</div>
                            <h5 class="font-bold mb-1">Bre-b</h5>
                            <p class="text-xs opacity-90">Pago con llave</p>
                        </a>

                        <a href="{{ route('payment.instructions.transfer', $order->id) }}"
                           class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg p-4 text-center hover:from-green-600 hover:to-green-700 transition shadow-lg">
                            <div class="text-3xl mb-2">🏦</div>
                            <h5 class="font-bold mb-1">Transferencia</h5>
                            <p class="text-xs opacity-90">Todos los bancos</p>
                        </a>

                        <a href="{{ route('payment.instructions.qr', $order->id) }}"
                           class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg p-4 text-center hover:from-purple-600 hover:to-purple-700 transition shadow-lg">
                            <div class="text-3xl mb-2">📱</div>
                            <h5 class="font-bold mb-1">Código QR</h5>
                            <p class="text-xs opacity-90">Escanea y paga</p>
                        </a>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <h5 class="font-bold mb-2">🔒 Seguridad garantizada</h5>
                    <p class="text-sm text-gray-700 mb-3">
                        Cuando esté disponible, nuestro sistema de pago con tarjeta incluirá:
                    </p>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            Certificado SSL de seguridad
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            Encriptación de datos bancarios
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            Cumplimiento PCI DSS
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            Autenticación 3D Secure
                        </li>
                    </ul>
                </div>

                <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Aviso:</strong> Tu orden quedará registrada. Puedes elegir otro método de pago haciendo clic en los botones de arriba.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center text-sm text-gray-600">
                <p><strong>Número de Orden:</strong> {{ $order->order_number }}</p>
                <p class="mt-1"><strong>Referencia de Pago:</strong> {{ $order->payment->reference }}</p>
                <p class="mt-2 text-xs">¿Necesitas ayuda? Contáctanos por WhatsApp: <strong>311 576 5959</strong></p>
            </div>
        </div>

        <!-- Ayuda -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <h3 class="font-bold text-gray-900 mb-2">¿Necesitas ayuda?</h3>
            <p class="text-gray-700 mb-4">Nuestro equipo está disponible para asistirte</p>
            <div class="flex justify-center gap-4">
                <a href="https://wa.me/573115765959" target="_blank"
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
