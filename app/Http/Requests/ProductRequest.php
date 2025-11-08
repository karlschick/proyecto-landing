<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        $rules = [
            'category_id' => 'nullable|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',

            // Precios e inventario
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|gte:price',
            'cost' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'track_quantity' => 'boolean',

            // Características
            'weight' => 'nullable|numeric|min:0',

            // Imágenes
            'featured_image' => $this->isMethod('POST')
                ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
                : 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',

            // Estado
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',

            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ];

        // SKU único (excluyendo el producto actual en edición)
        if ($productId) {
            $rules['sku'] = 'nullable|string|max:100|unique:products,sku,' . $productId;
            $rules['barcode'] = 'nullable|string|max:100|unique:products,barcode,' . $productId;
        } else {
            $rules['sku'] = 'nullable|string|max:100|unique:products,sku';
            $rules['barcode'] = 'nullable|string|max:100|unique:products,barcode';
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'track_quantity' => $this->boolean('track_quantity', true),
            'is_featured' => $this->boolean('is_featured', false),
            'is_active' => $this->boolean('is_active', true),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser mayor o igual a 0.',
            'compare_price.gte' => 'El precio de comparación debe ser mayor o igual al precio de venta.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'sku.unique' => 'Este SKU ya está en uso.',
            'barcode.unique' => 'Este código de barras ya está en uso.',
            'featured_image.image' => 'La imagen destacada debe ser un archivo de imagen.',
            'featured_image.max' => 'La imagen destacada no puede ser mayor a 5MB.',
            'gallery_images.*.image' => 'Todos los archivos de galería deben ser imágenes.',
            'gallery_images.*.max' => 'Las imágenes de galería no pueden ser mayores a 5MB.',
        ];
    }
}
