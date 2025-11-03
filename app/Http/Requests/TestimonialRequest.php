<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'testimonial' => 'required|string',
            'client_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'client_name.required' => 'El nombre del cliente es obligatorio.',
            'testimonial.required' => 'El testimonio es obligatorio.',
            'rating.required' => 'La calificación es obligatoria.',
            'rating.min' => 'La calificación mínima es 1.',
            'rating.max' => 'La calificación máxima es 5.',
            'client_photo.image' => 'El archivo debe ser una imagen.',
            'client_photo.max' => 'La foto no puede ser mayor a 2MB.',
        ];
    }
}
