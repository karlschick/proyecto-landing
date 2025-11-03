<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'icon',
        'image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title') && empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    /**
     * Scope para servicios activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenar
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Helper para obtener URL de imagen (con caché)
     */
    public function getImageUrl(): string
    {
        return Cache::remember("service_image_{$this->id}", 3600, function() {
            if (!$this->image) {
                return asset('images/services/default.jpg');
            }

            $paths = [
                public_path('images/services/' . $this->image),
                public_path($this->image)
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) {
                    return asset(str_replace(public_path(), '', $path));
                }
            }

            \Log::warning("Image not found for service {$this->id}: {$this->image}");
            return asset('images/services/default.jpg');
        });
    }

    /**
     * Limpiar caché de imagen al actualizar
     */
    protected static function booted()
    {
        static::updated(function ($service) {
            Cache::forget("service_image_{$service->id}");
        });

        static::deleted(function ($service) {
            Cache::forget("service_image_{$service->id}");
        });
    }
}
