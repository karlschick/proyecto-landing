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
     * Helper para obtener URL de imagen (MISMA LÓGICA QUE PROJECT)
     */
    public function getImageUrl(): string
    {
        if (!$this->image) {
            return asset('images/services/default.jpg');
        }

        // Normaliza ruta (quita posibles "/")
        $path = ltrim($this->image, '/');

        // Si la ruta ya incluye "services/" al inicio
        if (str_starts_with($path, 'services/')) {
            $fullPath = public_path('images/' . $path); // images/services/archivo.jpg
            if (file_exists($fullPath)) {
                return asset('images/' . $path);
            }
        }

        // Si solo es el nombre del archivo
        $fullPath = public_path('images/services/' . $path);
        if (file_exists($fullPath)) {
            return asset('images/services/' . $path);
        }

        \Log::warning("⚠️ Imagen no encontrada para service {$this->id}: {$this->image}");
        return asset('images/services/default.jpg');
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
