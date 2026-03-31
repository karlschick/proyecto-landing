<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'site_name'                => 'Mi Landing Page',
            'site_slogan'              => 'Tu solución perfecta',
            'primary_color'            => '#3B82F6',
            'secondary_color'          => '#8B5CF6',
            'accent_color'             => '#10B981',
            'contact_email'            => 'contacto@ejemplo.com',
            'favicon'                  => 'favicon.ico',

            // Hero
            'hero_enabled'             => true,
            'hero_title'               => 'Bienvenido a Tu LandingPage',
            'hero_subtitle'            => 'Ofrecemos las mejores soluciones para tu negocio',
            'hero_button_text'         => 'Comenzar',
            'hero_button_url'          => '#contacto',
            'hero_background_type'     => 'color',
            'hero_overlay_opacity'     => 0.5,
            'hero_show_logo_instead'   => true,
            'hero_logo_x'              => 50,
            'hero_logo_y'              => 50,
            'hero_logo_size'           => 112,

            // About ← AGREGADO
            'about_enabled'            => true,
            'about_title'              => 'Soluciones tecnológicas para tu negocio',
            'about_description'        => "Somos una empresa especializada en tecnología y servicios IT, comprometida con ofrecer soluciones innovadoras para empresas y personas que buscan optimizar sus procesos digitales.\n\nBrindamos servicios de mantenimiento, instalación de redes, configuración de servidores, diseño web y consultoría tecnológica, adaptándonos a las necesidades específicas de cada cliente.",

            // Secciones
            'services_enabled'         => true,
            'products_enabled'         => true,
            'testimonials_enabled'     => true,
            'gallery_enabled'          => true,
            'contact_enabled'          => true,

            // Footer y otros
            'show_social_footer'       => true,
            'show_whatsapp_button'     => true,
            'whatsapp_button_message'  => 'Hola, quiero más información',

            // Navbar
            'navbar_bg_color'          => '#000000',
            'navbar_text_color'        => '#ffffff',
        ]);
    }
}
