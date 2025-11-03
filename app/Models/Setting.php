<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        // Identidad
        'site_name',
        'site_slogan',
        'logo',
        'favicon',

        // Colores
        'primary_color',
        'secondary_color',
        'accent_color',

        // Hero Background
        'hero_background_type',
        'hero_background_image',
        'hero_background_video',
        'hero_overlay_opacity',

        // Redes sociales
        'facebook_enabled',
        'facebook_url',
        'instagram_enabled',
        'instagram_url',
        'twitter_enabled',
        'twitter_url',
        'linkedin_enabled',
        'linkedin_url',
        'whatsapp_enabled',
        'whatsapp_number',

        // Contacto
        'show_email',
        'contact_email',
        'show_phone',
        'contact_phone',
        'show_address',
        'contact_address',
        'show_map',
        'google_maps_url',

        // Secciones
        'hero_enabled',
        'hero_title',
        'hero_subtitle',
        'hero_button_text',
        'hero_button_url',
        'about_enabled',
        'about_title',
        'about_description',
        'about_image',
        'services_enabled',
        'products_enabled',
        'testimonials_enabled',
        'gallery_enabled',
        'contact_enabled',

        // Footer
        'show_social_footer',
        'footer_text',

        // Otros
        'show_whatsapp_button',
        'whatsapp_button_message',

        // SEO
        'meta_description',
        'meta_keywords',
        'google_analytics_id',
        'facebook_pixel_id',

        // Email
        'notification_email',

        // Horarios
        'business_hours',
    ];

    protected $casts = [
        // Booleanos
        'facebook_enabled' => 'boolean',
        'instagram_enabled' => 'boolean',
        'twitter_enabled' => 'boolean',
        'linkedin_enabled' => 'boolean',
        'whatsapp_enabled' => 'boolean',
        'show_email' => 'boolean',
        'show_phone' => 'boolean',
        'show_address' => 'boolean',
        'show_map' => 'boolean',
        'hero_enabled' => 'boolean',
        'hero_overlay_opacity' => 'float',
        'about_enabled' => 'boolean',
        'services_enabled' => 'boolean',
        'products_enabled' => 'boolean',
        'testimonials_enabled' => 'boolean',
        'gallery_enabled' => 'boolean',
        'contact_enabled' => 'boolean',
        'show_social_footer' => 'boolean',
        'show_whatsapp_button' => 'boolean',
    ];

    /**
     * Obtener la instancia única de configuración
     * Siempre debe haber solo UN registro en esta tabla
     */
    public static function getSettings()
    {
        return self::firstOrCreate([
            'id' => 1
        ], [
            'site_name' => config('app.name'),
            'contact_email' => 'contacto@ejemplo.com',
        ]);
    }


/**
 * Obtener URL de la imagen de fondo del Hero
 */
public function getHeroBackgroundImageUrl()
{
    if ($this->hero_background_image) {
        $imagePath = public_path('images/hero/' . $this->hero_background_image);
        if (file_exists($imagePath)) {
            return asset('images/hero/' . $this->hero_background_image);
        }

        $publicPath = public_path($this->hero_background_image);
        if (file_exists($publicPath)) {
            return asset($this->hero_background_image);
        }

        \Log::warning('Hero background image no encontrada: ' . $this->hero_background_image);
    }

    return null;
}

/**
 * Obtener URL del video de fondo del Hero
 */
public function getHeroBackgroundVideoUrl()
{
    if ($this->hero_background_video) {
        $videoPath = public_path('videos/hero/' . $this->hero_background_video);
        if (file_exists($videoPath)) {
            return asset('videos/hero/' . $this->hero_background_video);
        }

        $publicPath = public_path($this->hero_background_video);
        if (file_exists($publicPath)) {
            return asset($this->hero_background_video);
        }

        \Log::warning('Hero background video no encontrado: ' . $this->hero_background_video);
    }

    return null;
}

    /**
     * Métodos helper para obtener valores específicos
     */
public function getFaviconUrl()
{
    if ($this->favicon) {
        // Verificar en public/images/
        $imagePath = public_path('images/' . $this->favicon);
        if (file_exists($imagePath)) {
            return asset('images/' . $this->favicon);
        }

        // Verificar en public/ directamente
        $publicPath = public_path($this->favicon);
        if (file_exists($publicPath)) {
            return asset($this->favicon);
        }

        // Log si no encuentra el archivo
        \Log::warning('Favicon no encontrado: ' . $this->favicon);
    }

    // Fallback al favicon por defecto
    return asset('favicon.ico');
}

public function getLogoUrl()
{
    if ($this->logo) {
        $imagePath = public_path('images/' . $this->logo);
        if (file_exists($imagePath)) {
            return asset('images/' . $this->logo);
        }

        $publicPath = public_path($this->logo);
        if (file_exists($publicPath)) {
            return asset($this->logo);
        }

        \Log::warning('Logo no encontrado: ' . $this->logo);
    }

    return asset('images/logo.png');
}

public function getAboutImageUrl()
{
    if ($this->about_image) {
        $imagePath = public_path('images/' . $this->about_image);
        if (file_exists($imagePath)) {
            return asset('images/' . $this->about_image);
        }

        $publicPath = public_path($this->about_image);
        if (file_exists($publicPath)) {
            return asset($this->about_image);
        }

        \Log::warning('Imagen About no encontrada: ' . $this->about_image);
    }

    return asset('images/about-image.jpg');
}

    /**
     * Obtener redes sociales habilitadas
     */
    public function getEnabledSocialNetworks()
    {
        $networks = [];

        if ($this->facebook_enabled && $this->facebook_url) {
            $networks['facebook'] = $this->facebook_url;
        }

        if ($this->instagram_enabled && $this->instagram_url) {
            $networks['instagram'] = $this->instagram_url;
        }

        if ($this->twitter_enabled && $this->twitter_url) {
            $networks['twitter'] = $this->twitter_url;
        }

        if ($this->linkedin_enabled && $this->linkedin_url) {
            $networks['linkedin'] = $this->linkedin_url;
        }

        return $networks;
    }

    /**
     * Verificar si WhatsApp está habilitado
     */
    public function hasWhatsApp()
    {
        return $this->whatsapp_enabled && !empty($this->whatsapp_number);
    }

    /**
     * Obtener link de WhatsApp formateado
     */
    public function getWhatsAppLink()
    {
        if (!$this->hasWhatsApp()) {
            return null;
        }

        $number = preg_replace('/[^0-9]/', '', $this->whatsapp_number);
        $message = urlencode($this->whatsapp_button_message ?? 'Hola, quiero más información');

        return "https://wa.me/{$number}?text={$message}";
    }
}
