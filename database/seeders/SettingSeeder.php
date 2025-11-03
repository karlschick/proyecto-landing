<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'site_name' => 'Mi Landing Page',
            'site_slogan' => 'Tu solución perfecta',
            'primary_color' => '#3B82F6',
            'secondary_color' => '#8B5CF6',
            'accent_color' => '#10B981',
            'contact_email' => 'contacto@ejemplo.com',
            'hero_enabled' => true,
            'hero_title' => 'Bienvenido a Nuestro Sitio',
            'hero_subtitle' => 'Ofrecemos las mejores soluciones para tu negocio',
            'hero_button_text' => 'Comenzar',
            'hero_button_url' => '#contacto',
            'hero_background_type' => 'color',
            'hero_overlay_opacity' => 0.5,
            'about_enabled' => true,
            'services_enabled' => true,
            'products_enabled' => true,
            'testimonials_enabled' => true,
            'gallery_enabled' => true,
            'contact_enabled' => true,
            'show_social_footer' => true,
            'show_whatsapp_button' => true,
            'whatsapp_button_message' => 'Hola, quiero más información',
        ]);
    }
}
