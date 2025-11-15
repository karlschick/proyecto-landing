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

        // Reglas base (siempre requeridas)
        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'string', 'in:cash_on_delivery,qr_payment,card,transfer'],
            'terms_accepted' => ['required', 'accepted'],
        ];

        // Si NO es solo productos digitales, agregar validación de dirección
        if (!$isDigitalOnly) {
            $rules = array_merge($rules, [
                'address_line_1' => ['required', 'string', 'max:255'],
                'address_line_2' => ['nullable', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'postal_code' => ['required', 'string', 'max:20'],
                'country' => ['required', 'string', 'max:100'],
                'notes' => ['nullable', 'string', 'max:500'],
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'phone.required' => 'El teléfono es obligatorio.',
            'address_line_1.required' => 'La dirección es obligatoria.',
            'city.required' => 'La ciudad es obligatoria.',
            'postal_code.required' => 'El código postal es obligatorio.',
            'country.required' => 'El país es obligatorio.',
            'payment_method.required' => 'Debes seleccionar un método de pago.',
            'terms_accepted.accepted' => 'Debes aceptar los términos y condiciones.',
        ];
    }
}
