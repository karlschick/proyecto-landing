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
        'type',
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

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    /**
     * Helper para verificar si es video
     */
    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    /**
     * Helper para obtener URL de imagen/video
     */
    public function getImageUrl(): string
    {
        if (!$this->image) {
            return asset('images/gallery/default.jpg');
        }

        $folder = $this->isVideo() ? 'videos' : 'gallery';
        $filePath = public_path("images/{$folder}/" . $this->image);

        if (file_exists($filePath)) {
            return asset("images/{$folder}/" . $this->image);
        }

        \Log::warning("File not found for gallery {$this->id}: {$this->image}");
        return asset('images/gallery/default.jpg');
    }

    /**
     * Helper para obtener thumbnail del video
     */
    public function getVideoThumbnail(): string
    {
        if (!$this->isVideo()) {
            return $this->getImageUrl();
        }

        // Buscar thumbnail con el mismo nombre pero extensión .jpg
        $thumbnailName = pathinfo($this->image, PATHINFO_FILENAME) . '.jpg';
        $thumbnailPath = public_path('images/videos/thumbnails/' . $thumbnailName);

        if (file_exists($thumbnailPath)) {
            return asset('images/videos/thumbnails/' . $thumbnailName);
        }

        // Retornar placeholder de video
        return asset('images/video-placeholder.jpg');
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
