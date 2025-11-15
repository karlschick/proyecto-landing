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
            'type' => 'required|in:image,video',
        ];

        // Obtener el tipo seleccionado
        $type = $this->input('type', 'image');

        if ($type === 'video') {
            // Validación para videos
            if ($this->isMethod('POST')) {
                $rules['image'] = 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/mpeg|max:102400'; // 100MB
            } else {
                $rules['image'] = 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/mpeg|max:102400';
            }
        } else {
            // Validación para imágenes
            if ($this->isMethod('POST')) {
                $rules['image'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
            } else {
                $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
            }
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
            'image.required' => 'Debes seleccionar una imagen o video.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'image.mimetypes' => 'El video debe ser de tipo: mp4, mov, avi, wmv.',
            'image.max' => 'El archivo es demasiado grande. Máx: 5MB para imágenes, 100MB para videos.',
            'image.file' => 'Debes seleccionar un archivo válido.',
            'title.max' => 'El título no puede exceder 255 caracteres.',
            'category.max' => 'La categoría no puede exceder 100 caracteres.',
            'type.required' => 'Debes seleccionar el tipo de archivo.',
            'type.in' => 'El tipo debe ser imagen o video.',
        ];
    }
}
