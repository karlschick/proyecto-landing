<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Información de envío
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',

            // Información de pago
            'payment_method' => 'required|in:card,transfer,cash_on_delivery',
            'payment_gateway' => 'nullable|string|in:mercadopago,paypal,stripe',

            // Términos y condiciones
            'terms_accepted' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debes proporcionar un email válido.',
            'phone.required' => 'El teléfono es obligatorio.',
            'address_line_1.required' => 'La dirección es obligatoria.',
            'city.required' => 'La ciudad es obligatoria.',
            'postal_code.required' => 'El código postal es obligatorio.',
            'payment_method.required' => 'Debes seleccionar un método de pago.',
            'payment_method.in' => 'El método de pago seleccionado no es válido.',
            'terms_accepted.required' => 'Debes aceptar los términos y condiciones.',
            'terms_accepted.accepted' => 'Debes aceptar los términos y condiciones para continuar.',
        ];
    }
}
