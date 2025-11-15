<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'featured_image',
        'is_active',
        'order',
        // Campos legacy (opcionales - ya no se usan en formularios)
        'category_id',
        'short_description',
        'client',
        'project_date',
        'url',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'project_date' => 'date',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }

            // Valores por defecto para campos legacy
            if (is_null($project->is_featured)) {
                $project->is_featured = false;
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /**
     * Relaciones
     */
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

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
     * Helper para obtener URL de imagen (con caché)
     */
    public function getImageUrl(): string
    {
        if (!$this->featured_image) {
            return asset('images/projects/default.jpg');
        }

        // Normaliza ruta (quita posibles "/")
        $path = ltrim($this->featured_image, '/');

        // Si la ruta ya incluye "projects/" al inicio
        if (str_starts_with($path, 'projects/')) {
            $fullPath = public_path('images/' . $path); // images/projects/archivo.jpg
            if (file_exists($fullPath)) {
                return asset('images/' . $path);
            }
        }

        // Si solo es el nombre del archivo
        $fullPath = public_path('images/projects/' . $path);
        if (file_exists($fullPath)) {
            return asset('images/projects/' . $path);
        }

        \Log::warning("⚠️ Imagen no encontrada para project {$this->id}: {$this->featured_image}");
        return asset('images/projects/default.jpg');
    }

    /**
     * Limpiar caché de imagen al actualizar
     */
    protected static function booted()
    {
        static::updated(function ($project) {
            Cache::forget("project_image_{$project->id}");
        });

        static::deleted(function ($project) {
            Cache::forget("project_image_{$project->id}");
        });
    }
}
