@extends('landing.layout')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Finalizar Compra</h1>

        @if($cart->hasOnlyDigitalProducts())
        <!-- Mensaje para productos digitales -->
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-1">📚 Productos Digitales</h3>
                    <p class="text-sm text-blue-800">Tu compra contiene solo productos digitales. Recibirás el acceso por email inmediatamente después del pago. No se requiere dirección de envío.</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Mensajes de sesión (success / error) --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Resumen de errores de validación --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded">
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Formulario -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Información de Contacto -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Información de Contacto</h2>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                                <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name ?? '') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('full_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @if($cart->hasOnlyDigitalProducts())
                                <p class="text-xs text-gray-500 mt-1">Recibirás tus productos digitales en este email</p>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required
                                       placeholder="+57 3## ### ###"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dirección de Envío (solo si hay productos físicos) -->
                    @if(!$cart->hasOnlyDigitalProducts())
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Dirección de Envío</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                                <input type="text" name="address_line_1" value="{{ old('address_line_1') }}" required
                                       placeholder="Calle, carrera, avenida..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('address_line_1')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Complemento (Apartamento, oficina, etc.)</label>
                                <input type="text" name="address_line_2" value="{{ old('address_line_2') }}"
                                       placeholder="Apto 101, Torre B, etc."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('address_line_2')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('city')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
                                    <input type="text" name="state" value="{{ old('state') }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('state')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Código Postal *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('postal_code')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">País *</label>
                                    <input type="text" name="country" value="{{ old('country', 'Colombia') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('country')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notas de Entrega (Opcional)</label>
                                <textarea name="notes" rows="3"
                                          placeholder="Instrucciones especiales para la entrega..."
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Método de Pago -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Método de Pago</h2>

                        {{-- 🔥 Grid que se adapta automáticamente --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            @if($cart->hasOnlyDigitalProducts())
                                <!-- Bre-b (Llave) - Solo productos digitales -->
                                <label class="cursor-pointer payment-option">
                                    <input type="radio" name="payment_method" value="manual_breb" class="hidden peer payment-radio" checked required>
                                    <div class="bg-white rounded-lg shadow p-4 border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition hover:shadow-md h-full">
                                        <div class="flex items-start">
                                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center mt-0.5 radio-visual">
                                                <div class="w-3 h-3 rounded-full bg-blue-600 hidden radio-dot"></div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-2xl">🔑</span>
                                                    <h3 class="text-base font-bold">Bre-b (Llave)</h3>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-2">Pago manual con llave Bre-b</p>
                                                <div class="text-xs text-gray-500 space-y-1">
                                                    <p>✓ Fácil y rápido</p>
                                                    <p>✓ Sin comisiones extra</p>
                                                    <p>✓ Confirmación en 24h</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Pago QR - Solo productos digitales -->
                                <label class="cursor-pointer payment-option">
                                    <input type="radio" name="payment_method" value="manual_qr" class="hidden peer payment-radio" required>
                                    <div class="bg-white rounded-lg shadow p-4 border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition hover:shadow-md h-full">
                                        <div class="flex items-start">
                                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center mt-0.5 radio-visual">
                                                <div class="w-3 h-3 rounded-full bg-blue-600 hidden radio-dot"></div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-2xl">📱</span>
                                                    <h3 class="text-base font-bold">Código QR</h3>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-2">Escanea y paga</p>
                                                <div class="text-xs text-gray-500 space-y-1">
                                                    <p>✓ Escanea con tu app</p>
                                                    <p>✓ Rápido y seguro</p>
                                                    <p>✓ Confirmación en 24h</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @else
                                <!-- Pago Contra Entrega - Solo productos físicos -->
                                <label class="cursor-pointer payment-option">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" class="hidden peer payment-radio" checked required>
                                    <div class="bg-white rounded-lg shadow p-4 border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition hover:shadow-md h-full">
                                        <div class="flex items-start">
                                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center mt-0.5 radio-visual">
                                                <div class="w-3 h-3 rounded-full bg-blue-600 hidden radio-dot"></div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-2xl">💵</span>
                                                    <h3 class="text-base font-bold">Pago Contra Entrega</h3>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-2">Paga en efectivo al recibir tu pedido</p>
                                                <div class="text-xs text-gray-500 space-y-1">
                                                    <p>✓ Paga en efectivo</p>
                                                    <p>✓ Al momento de entrega</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endif

                            <!-- Transferencia Bancaria -->
                            <label class="cursor-pointer payment-option">
                                <input type="radio" name="payment_method" value="manual_transfer" class="hidden peer payment-radio" required>
                                <div class="bg-white rounded-lg shadow p-4 border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition hover:shadow-md h-full">
                                    <div class="flex items-start">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center mt-0.5 radio-visual">
                                            <div class="w-3 h-3 rounded-full bg-blue-600 hidden radio-dot"></div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-2xl">🏦</span>
                                                <h3 class="text-base font-bold">Transferencia Bancaria</h3>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2">Pago por transferencia</p>
                                            <div class="text-xs text-gray-500 space-y-1">
                                                <p>✓ Transferencia tradicional</p>
                                                <p>✓ Todos los bancos</p>
                                                <p>✓ Confirmación en 24h</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Tarjeta de Crédito/Débito -->
                            <label class="cursor-pointer payment-option">
                                <input type="radio" name="payment_method" value="card" class="hidden peer payment-radio" required>
                                <div class="bg-white rounded-lg shadow p-4 border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition hover:shadow-md h-full">
                                    <div class="flex items-start">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center mt-0.5 radio-visual">
                                            <div class="w-3 h-3 rounded-full bg-blue-600 hidden radio-dot"></div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-2xl">💳</span>
                                                <h3 class="text-base font-bold">Tarjeta Débito/Crédito</h3>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2">Pago con tarjeta</p>
                                            <div class="text-xs text-gray-500 space-y-1">
                                                <p>✓ Aprobación inmediata</p>
                                                <p>✓ Todas las tarjetas</p>
                                                <p>✓ 100% seguro</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms_accepted" value="1" required
                                class="w-5 h-5 text-blue-600 rounded mt-0.5">
                            <span class="ml-3 text-sm text-gray-700">
                                Acepto los
                                <a href="/terminos-y-condiciones" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium underline">
                                    términos y condiciones
                                </a>
                                y la
                                <a href="/politica-de-privacidad" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium underline">
                                    política de privacidad
                                </a>
                            </span>
                        </label>
                        @error('terms_accepted')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                {{-- 👆 CIERRE del lg:col-span-2 --}}

                <!-- Resumen del Pedido -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Resumen del Pedido</h2>

                        <!-- Productos -->
                        <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                            @foreach($cart->items as $item)
                            <div class="flex gap-3">
                                <img src="{{ $item->product->getFeaturedImageUrl() }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <p class="font-medium text-sm text-gray-900 line-clamp-2">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-600">Cantidad: {{ $item->quantity }}</p>
                                    @if($item->product->isBook())
                                    <span class="inline-block text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded mt-1">📚 Digital</span>
                                    @endif
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($item->getSubtotal(), 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

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
                                @if($cart->hasOnlyDigitalProducts())
                                <span class="font-semibold text-green-600">Gratis (Digital)</span>
                                @else
                                <span class="font-semibold">${{ number_format($estimatedShipping, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            @if(!$cart->hasOnlyDigitalProducts())
                            <p class="text-xs text-gray-500">El costo de envío se calcula según la ciudad</p>
                            @endif
                        </div>

                        <!-- Total -->
                        <div class="flex justify-between text-xl font-bold text-gray-900 mb-6">
                            <span>Total:</span>
                            <span class="text-blue-600">${{ number_format($cart->getTotal() + ($cart->hasOnlyDigitalProducts() ? 0 : $estimatedShipping), 0, ',', '.') }}</span>
                        </div>

                        <!-- Botón Finalizar -->
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-lg font-bold text-lg transition mb-3">
                            @if($cart->hasOnlyDigitalProducts())
                            Proceder al Pago
                            @else
                            Finalizar Compra
                            @endif
                        </button>

                        <a href="{{ route('cart.index') }}" class="block text-center text-blue-600 hover:text-blue-800 font-medium text-sm">
                            Volver al carrito
                        </a>

                        <!-- Seguridad -->
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Pago 100% seguro</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Datos protegidos</span>
                            </div>
                            @if($cart->hasOnlyDigitalProducts())
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <span>Entrega inmediata por email</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- 👆 CIERRE del lg:col-span-1 --}}
            </div>
            {{-- 👆 CIERRE del grid lg:grid-cols-3 --}}
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sincronizar radio buttons visuales con los ocultos
    const paymentOptions = document.querySelectorAll('.payment-option');

    // Marcar el inicial como checked
    const checkedRadio = document.querySelector('.payment-radio:checked');
    if (checkedRadio) {
        const label = checkedRadio.closest('.payment-option');
        updateVisualRadio(label, true);
    }

    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('.payment-radio');

            // Desmarcar todos
            document.querySelectorAll('.payment-option').forEach(opt => {
                updateVisualRadio(opt, false);
            });

            // Marcar el seleccionado
            radio.checked = true;
            updateVisualRadio(this, true);
        });
    });

    function updateVisualRadio(label, isChecked) {
        const radioDot = label.querySelector('.radio-dot');
        const radioVisual = label.querySelector('.radio-visual');

        if (isChecked) {
            radioDot.classList.remove('hidden');
            radioVisual.classList.add('border-blue-600');
            radioVisual.classList.remove('border-gray-300');
        } else {
            radioDot.classList.add('hidden');
            radioVisual.classList.remove('border-blue-600');
            radioVisual.classList.add('border-gray-300');
        }
    }

    // Formulario de checkout
    const form = document.querySelector('form[action*="checkout.process"]');
    if (!form) return;

    form.addEventListener('submit', function (ev) {
        console.log('checkout form submitted — timestamp:', new Date().toISOString());
        const formData = new FormData(form);
        const entries = {};
        for (const [k,v] of formData.entries()) {
            entries[k] = v;
        }
        console.log('Form data:', entries);

        // Desactivar botón temporalmente
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            setTimeout(() => submitButton.disabled = false, 1000);
        }
    });
});
</script>
@endsection
