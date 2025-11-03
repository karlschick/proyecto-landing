<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\GalleryImage;

class CacheService
{
    protected const TTL = 3600; // 1 hora
    protected const SETTINGS_KEY = 'site_settings';
    protected const SERVICES_KEY = 'active_services';
    protected const PROJECTS_KEY = 'active_projects';
    protected const TESTIMONIALS_KEY = 'featured_testimonials';
    protected const GALLERY_KEY = 'active_gallery_images';

    /**
     * Obtener settings con caché
     */
    public static function settings()
    {
        return Cache::remember(self::SETTINGS_KEY, self::TTL, function() {
            return Setting::getSettings();
        });
    }

    /**
     * Obtener servicios activos con caché
     */
    public static function services()
    {
        return Cache::remember(self::SERVICES_KEY, self::TTL, function() {
            return Service::active()->ordered()->get();
        });
    }

    /**
     * Obtener proyectos activos con caché
     */
    public static function projects()
    {
        return Cache::remember(self::PROJECTS_KEY, self::TTL, function() {
            return Project::with('category')
                ->active()
                ->featured()
                ->ordered()
                ->take(6)
                ->get();
        });
    }

    /**
     * Obtener testimonios destacados con caché
     */
    public static function testimonials()
    {
        return Cache::remember(self::TESTIMONIALS_KEY, self::TTL, function() {
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
        return Cache::remember(self::GALLERY_KEY, self::TTL, function() {
            return GalleryImage::active()->ordered()->take(12)->get();
        });
    }

    /**
     * Limpiar caché de settings
     */
    public static function clearSettings(): void
    {
        Cache::forget(self::SETTINGS_KEY);
    }

    /**
     * Limpiar caché de servicios
     */
    public static function clearServices(): void
    {
        Cache::forget(self::SERVICES_KEY);
    }

    /**
     * Limpiar caché de proyectos
     */
    public static function clearProjects(): void
    {
        Cache::forget(self::PROJECTS_KEY);
    }

    /**
     * Limpiar caché de testimonios
     */
    public static function clearTestimonials(): void
    {
        Cache::forget(self::TESTIMONIALS_KEY);
    }

    /**
     * Limpiar caché de galería
     */
    public static function clearGallery(): void
    {
        Cache::forget(self::GALLERY_KEY);
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

        \Log::info('All site cache cleared');
    }

    /**
     * Obtener tiempo de vida del caché
     */
    public static function getTTL(): int
    {
        return self::TTL;
    }
}
