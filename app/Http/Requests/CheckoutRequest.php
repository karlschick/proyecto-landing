<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\CartService;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cartService = app(CartService::class);
        $cart = $cartService->getCart();
        $cart->load('items.product.category');

        $isDigitalOnly = $cart->hasOnlyDigitalProducts();

        // 🔥 Métodos de pago actualizados: Bre-b, Transferencia, QR, Tarjeta, Contra Entrega
        $rules = [
            'full_name'        => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'phone'            => ['required', 'string', 'max:30'],

            // ✅ Nuevos métodos de pago
            'payment_method'   => ['required', 'in:manual_breb,manual_transfer,manual_qr,card,cash_on_delivery'],

            'terms_accepted'   => ['required', 'accepted'],
        ];

        // 🟡 Dirección requerida SOLO para productos físicos
        if (!$isDigitalOnly) {
            $rules = array_merge($rules, [
                'address_line_1' => ['required', 'string', 'max:255'],
                'address_line_2' => ['nullable', 'string', 'max:255'],
                'city'           => ['required', 'string', 'max:100'],
                'state'          => ['nullable', 'string', 'max:100'],
                'postal_code'    => ['required', 'string', 'max:20'],
                'country'        => ['required', 'string', 'max:100'],
                'notes'          => ['nullable', 'string', 'max:500'],
            ]);
        }
        // 🟢 Digital only → permitir nulos
        else {
            $rules = array_merge($rules, [
                'address_line_1' => ['nullable', 'string', 'max:255'],
                'address_line_2' => ['nullable', 'string', 'max:255'],
                'city'           => ['nullable', 'string', 'max:100'],
                'state'          => ['nullable', 'string', 'max:100'],
                'postal_code'    => ['nullable', 'string', 'max:20'],
                'country'        => ['nullable', 'string', 'max:100'],
                'notes'          => ['nullable', 'string', 'max:500'],
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // Campos generales
            'full_name.required'      => 'El nombre completo es obligatorio.',
            'email.required'          => 'El email es obligatorio.',
            'email.email'             => 'El email debe ser válido.',
            'phone.required'          => 'El teléfono es obligatorio.',

            // Dirección
            'address_line_1.required' => 'La dirección es obligatoria.',
            'city.required'           => 'La ciudad es obligatoria.',
            'postal_code.required'    => 'El código postal es obligatorio.',
            'country.required'        => 'El país es obligatorio.',

            // Método de pago
            'payment_method.required' => 'Debes seleccionar un método de pago.',
            'payment_method.in'       => 'El método de pago seleccionado no es válido. Los métodos disponibles son: Bre-b, Transferencia, QR, Tarjeta o Contra Entrega.',

            // Términos
            'terms_accepted.required' => 'Debes aceptar los términos y condiciones.',
            'terms_accepted.accepted' => 'Debes aceptar los términos y condiciones.',
        ];
    }

    /**
     * Obtener nombres legibles de los métodos de pago (opcional)
     */
    public function attributes(): array
    {
        return [
            'full_name'      => 'nombre completo',
            'email'          => 'correo electrónico',
            'phone'          => 'teléfono',
            'address_line_1' => 'dirección',
            'city'           => 'ciudad',
            'postal_code'    => 'código postal',
            'country'        => 'país',
            'payment_method' => 'método de pago',
            'terms_accepted' => 'términos y condiciones',
        ];
    }

    /**
     * Validación personalizada adicional (opcional)
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $cartService = app(CartService::class);
            $cart = $cartService->getCart();

            // Validar que "cash_on_delivery" solo esté disponible para productos físicos
            if ($this->payment_method === 'cash_on_delivery' && $cart->hasOnlyDigitalProducts()) {
                $validator->errors()->add(
                    'payment_method',
                    'El pago contra entrega solo está disponible para productos físicos.'
                );
            }

            // Validar que métodos digitales estén disponibles para productos digitales
            $digitalMethods = ['manual_breb', 'manual_qr', 'manual_transfer', 'card'];
            if (in_array($this->payment_method, $digitalMethods) && !$cart->hasOnlyDigitalProducts() && $this->payment_method !== 'manual_transfer' && $this->payment_method !== 'card') {
                // Permitir transferencia y tarjeta para ambos tipos
            }
        });
    }
}
