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
     * Helper para obtener URL de foto (con caché)
     */
    public function getPhotoUrl(): ?string
    {
        if (!$this->client_photo) {
            return null;
        }

        return Cache::remember("testimonial_photo_{$this->id}", 3600, function() {
            $paths = [
                public_path('images/testimonials/' . $this->client_photo),
                public_path($this->client_photo)
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) {
                    return asset(str_replace(public_path(), '', $path));
                }
            }

            return null;
        });
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
