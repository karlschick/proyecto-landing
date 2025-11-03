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
        'category_id',
        'title',
        'slug',
        'description',
        'short_description',
        'client',
        'project_date',
        'url',
        'featured_image',
        'is_featured',
        'is_active',
        'order',
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
        return Cache::remember("project_image_{$this->id}", 3600, function() {
            if (!$this->featured_image) {
                return asset('images/projects/default.jpg');
            }

            $paths = [
                public_path('images/projects/' . $this->featured_image),
                public_path($this->featured_image)
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) {
                    return asset(str_replace(public_path(), '', $path));
                }
            }

            \Log::warning("Image not found for project {$this->id}: {$this->featured_image}");
            return asset('images/projects/default.jpg');
        });
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
