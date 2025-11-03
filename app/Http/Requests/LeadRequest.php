<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',

            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debes proporcionar un email válido.',
            'email.max' => 'El email no puede exceder 255 caracteres.',

            'phone.max' => 'El teléfono no puede exceder 20 caracteres.',

            'subject.max' => 'El asunto no puede exceder 255 caracteres.',

            'message.required' => 'El mensaje es obligatorio.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
            'message.max' => 'El mensaje no puede exceder 2000 caracteres.',
        ];
    }
}
