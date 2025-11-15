<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_position',
        'client_company',
        'testimonial',
        'client_photo',
        'rating',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Helper para obtener URL de foto (MISMA LÓGICA QUE PROJECT/SERVICE)
     */
    public function getPhotoUrl(): string
    {
        if (!$this->client_photo) {
            return asset('images/testimonials/default.jpg');
        }

        // Normaliza ruta (quita posibles "/")
        $path = ltrim($this->client_photo, '/');

        // Si la ruta ya incluye "testimonials/" al inicio
        if (str_starts_with($path, 'testimonials/')) {
            $fullPath = public_path('images/' . $path); // images/testimonials/archivo.jpg
            if (file_exists($fullPath)) {
                return asset('images/' . $path);
            }
        }

        // Si solo es el nombre del archivo
        $fullPath = public_path('images/testimonials/' . $path);
        if (file_exists($fullPath)) {
            return asset('images/testimonials/' . $path);
        }

        \Log::warning("⚠️ Imagen no encontrada para testimonial {$this->id}: {$this->client_photo}");
        return asset('images/testimonials/default.jpg');
    }

    /**
     * Helper para obtener iniciales
     */
    public function getInitials(): string
    {
        $words = explode(' ', $this->client_name);

        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($this->client_name, 0, 2));
    }

    /**
     * Helper para obtener estrellas
     */
    public function getStarsArray(): array
    {
        return range(1, 5);
    }

    /**
     * Limpiar caché de foto al actualizar
     */
    protected static function booted()
    {
        static::updated(function ($testimonial) {
            Cache::forget("testimonial_photo_{$testimonial->id}");
        });

        static::deleted(function ($testimonial) {
            Cache::forget("testimonial_photo_{$testimonial->id}");
        });
    }
}
