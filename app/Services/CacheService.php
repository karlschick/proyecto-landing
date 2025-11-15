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
     * ✅ OPTIMIZADO: Obtener settings con caché (solo campos necesarios)
     */
    public static function settings()
    {
        return Cache::remember(self::SETTINGS_KEY, self::TTL, function() {
            // Solo cargar campos necesarios, NO todo el modelo
            return Setting::select([
                'id', 'site_name', 'site_slogan', 'logo', 'favicon',
                'primary_color', 'secondary_color', 'accent_color',
                'navbar_bg_color', 'navbar_text_color', 'navbar_show_logo',
                'navbar_show_title', 'navbar_show_slogan', 'navbar_show_shop',
                'navbar_menu_labels',
                'hero_enabled', 'hero_title', 'hero_subtitle', 'hero_button_text',
                'hero_button_url', 'hero_background_type', 'hero_background_image',
                'hero_background_video', 'hero_overlay_opacity',
                'hero_title_color', 'hero_title_font', 'hero_show_logo_instead',
                'cta_enabled', 'about_enabled', 'about_title', 'about_description',
                'features_enabled', 'stats_enabled', 'services_enabled',
                'products_enabled', 'shop_enabled', 'testimonials_enabled',
                'gallery_enabled', 'contact_enabled',
                'facebook_enabled', 'facebook_url', 'instagram_enabled',
                'instagram_url', 'twitter_enabled', 'twitter_url',
                'linkedin_enabled', 'linkedin_url', 'whatsapp_enabled',
                'whatsapp_number', 'whatsapp_button_message',
                'show_email', 'contact_email', 'show_phone', 'contact_phone',
                'show_address', 'contact_address', 'show_map', 'google_maps_url',
                'business_hours', 'show_social_footer', 'footer_text',
                'show_whatsapp_button', 'meta_description', 'meta_keywords'
            ])->firstOrCreate(['id' => 1]);
        });
    }

    /**
     * ✅ OPTIMIZADO: Obtener servicios activos con caché
     */
    public static function services()
    {
        return Cache::remember(self::SERVICES_KEY, self::TTL, function() {
            return Service::where('is_active', true)
                ->orderBy('order')
                ->select('id', 'title', 'description', 'icon', 'order', 'is_active')
                ->get();
        });
    }

    /**
     * ✅ OPTIMIZADO: Obtener proyectos activos con caché
     */
    public static function projects()
    {
        return Cache::remember(self::PROJECTS_KEY, self::TTL, function() {
            return Project::where('is_featured', true)
                ->with(['category' => function($query) {
                    $query->select('id', 'name');
                }])
                ->orderBy('order')
                ->select('id', 'title', 'description', 'image', 'slug', 'category_id', 'order', 'is_featured')
                ->take(6)
                ->get();
        });
    }

    /**
     * ✅ OPTIMIZADO: Obtener productos activos con caché
     */
    public static function products()
    {
        return Cache::remember('active_products', self::TTL, function() {
            return \App\Models\Product::where('is_active', true)
                ->where('quantity', '>', 0)
                ->with(['category' => function($query) {
                    $query->select('id', 'name');
                }])
                ->orderBy('order')
                ->select('id', 'name', 'slug', 'description', 'short_description', 'price', 'compare_price', 'featured_image', 'quantity', 'category_id', 'is_active', 'is_featured', 'order')
                ->take(12)
                ->get();
        });
    }

    /**
     * ✅ OPTIMIZADO: Obtener testimonios destacados con caché
     */
    public static function testimonials()
    {
        return Cache::remember(self::TESTIMONIALS_KEY, self::TTL, function() {
            return Testimonial::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('order')
                ->select('id', 'client_name', 'client_position', 'client_company', 'testimonial', 'client_photo', 'rating', 'order', 'is_active', 'is_featured')
                ->take(6)
                ->get();
        });
    }

    /**
     * ✅ OPTIMIZADO: Obtener imágenes de galería con caché
     */
    public static function gallery()
    {
        return Cache::remember(self::GALLERY_KEY, self::TTL, function() {
            return GalleryImage::where('is_active', true)
                ->orderBy('order')
                ->select('id', 'title', 'description', 'image', 'category', 'order', 'is_active')
                ->take(12)
                ->get();
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
     * Limpiar caché de productos
     */
    public static function clearProducts(): void
    {
        Cache::forget('active_products');
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

        \Log::info('All site cache cleared - optimized version');
    }

    /**
     * Obtener tiempo de vida del caché
     */
    public static function getTTL(): int
    {
        return self::TTL;
    }
}
