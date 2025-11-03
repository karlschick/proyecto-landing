<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:project_categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'client' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'url' => 'nullable|url',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
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
            'title.required' => 'El título es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'url.url' => 'La URL debe ser válida.',
            'featured_image.image' => 'El archivo debe ser una imagen.',
            'featured_image.max' => 'La imagen no puede ser mayor a 5MB.',
        ];
    }
}
