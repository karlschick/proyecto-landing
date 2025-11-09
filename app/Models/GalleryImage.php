<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    /**
     * Helper para obtener URL de imagen
     */
    public function getImageUrl(): string
    {
        // Si no hay imagen, retornar imagen por defecto
        if (!$this->image) {
            return asset('images/gallery/default.jpg');
        }

        // Construir la ruta completa del archivo
        $imagePath = public_path('images/gallery/' . $this->image);

        // Verificar si el archivo existe
        if (file_exists($imagePath)) {
            return asset('images/gallery/' . $this->image);
        }

        // Si no existe, registrar warning y retornar imagen por defecto
        \Log::warning("Image not found for gallery {$this->id}: {$this->image}", [
            'expected_path' => $imagePath,
            'image_field' => $this->image
        ]);

        return asset('images/gallery/default.jpg');
    }

    /**
     * Helper para obtener categorías únicas
     */
    public static function getCategories()
    {
        return Cache::remember('gallery_categories', 3600, function() {
            return self::active()
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category')
                ->sort()
                ->values();
        });
    }

    /**
     * Limpiar caché al actualizar
     */
    protected static function booted()
    {
        static::updated(function ($image) {
            Cache::forget('gallery_categories');
        });

        static::deleted(function ($image) {
            Cache::forget('gallery_categories');
        });

        static::created(function ($image) {
            Cache::forget('gallery_categories');
        });
    }
}
