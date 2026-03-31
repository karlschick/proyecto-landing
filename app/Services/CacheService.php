<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\GalleryImage;
use App\Models\Stat;

class CacheService
{
    protected const TTL = 3600; // 1 hora
    protected const SETTINGS_KEY     = 'site_settings';
    protected const SERVICES_KEY     = 'active_services';
    protected const PROJECTS_KEY     = 'active_projects';
    protected const TESTIMONIALS_KEY = 'featured_testimonials';
    protected const GALLERY_KEY      = 'active_gallery_images';
    protected const STATS_KEY        = 'active_stats'; // ← NUEVO

    /**
     * Obtener settings con caché
     */
    public static function settings()
    {
        return Cache::remember(self::SETTINGS_KEY, self::TTL, function () {
            return Setting::getSettings();
        });
    }

    /**
     * Obtener servicios activos con caché
     */
    public static function services()
    {
        return Cache::remember(self::SERVICES_KEY, self::TTL, function () {
            return Service::active()->ordered()->get();
        });
    }

    /**
     * Obtener proyectos activos con caché
     */
    public static function projects()
    {
        return Cache::remember(self::PROJECTS_KEY, self::TTL, function () {
            return Project::with('category')
                ->active()
                ->featured()
                ->ordered()
                ->take(6)
                ->get();
        });
    }

    /**
     * Obtener productos activos con caché
     */
    public static function products()
    {
        return Cache::remember('active_products', self::TTL, function () {
            return \App\Models\Product::where('is_active', true)
                ->orderBy('order')
                ->take(12)
                ->get();
        });
    }

    /**
     * Obtener testimonios destacados con caché
     */
    public static function testimonials()
    {
        return Cache::remember(self::TESTIMONIALS_KEY, self::TTL, function () {
            return Testimonial::active()
                ->featured()
                ->ordered()
                ->take(6)
                ->get();
        });
    }

    /**
     * Obtener imágenes de galería con caché
     */
    public static function gallery()
    {
        return Cache::remember(self::GALLERY_KEY, self::TTL, function () {
            return GalleryImage::active()->ordered()->take(12)->get();
        });
    }

    /**
     * Obtener stats activos con caché
     */
    public static function stats()
    {
        return Cache::remember(self::STATS_KEY, self::TTL, function () {
            return Stat::active()->ordered()->get();
        });
    }

    // ─── Métodos clear ────────────────────────────────────────

    public static function clearSettings(): void
    {
        Cache::forget(self::SETTINGS_KEY);
    }

    public static function clearServices(): void
    {
        Cache::forget(self::SERVICES_KEY);
    }

    public static function clearProjects(): void
    {
        Cache::forget(self::PROJECTS_KEY);
    }

    public static function clearTestimonials(): void
    {
        Cache::forget(self::TESTIMONIALS_KEY);
    }

    public static function clearGallery(): void
    {
        Cache::forget(self::GALLERY_KEY);
    }

    public static function clearProducts(): void
    {
        Cache::forget('active_products');
    }

    public static function clearStats(): void
    {
        Cache::forget(self::STATS_KEY);
    }

    /**
     * Limpiar todo el caché del sitio
     */
    public static function clearAll(): void
    {
        Cache::forget(self::SETTINGS_KEY);
        Cache::forget(self::SERVICES_KEY);
        Cache::forget(self::PROJECTS_KEY);
        Cache::forget(self::TESTIMONIALS_KEY);
        Cache::forget(self::GALLERY_KEY);
        Cache::forget('active_products');
        Cache::forget(self::STATS_KEY); // ← NUEVO

        \Log::info('All site cache cleared');
    }

    public static function getTTL(): int
    {
        return self::TTL;
    }
}
