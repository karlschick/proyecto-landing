<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ];

        // Imagen requerida solo en creación
        if ($this->isMethod('POST')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
        } else {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'image.required' => 'La imagen es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'image.max' => 'La imagen no puede ser mayor a 5MB.',
            'title.max' => 'El título no puede exceder 255 caracteres.',
            'category.max' => 'La categoría no puede exceder 100 caracteres.',
        ];
    }
}
