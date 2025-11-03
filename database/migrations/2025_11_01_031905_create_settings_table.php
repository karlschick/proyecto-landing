<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Identidad
            $table->string('site_name')->nullable();
            $table->string('site_slogan')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            // Colores
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('accent_color')->nullable();

            // Redes Sociales
            $table->boolean('facebook_enabled')->default(false);
            $table->string('facebook_url')->nullable();
            $table->boolean('instagram_enabled')->default(false);
            $table->string('instagram_url')->nullable();
            $table->boolean('twitter_enabled')->default(false);
            $table->string('twitter_url')->nullable();
            $table->boolean('linkedin_enabled')->default(false);
            $table->string('linkedin_url')->nullable();
            $table->boolean('whatsapp_enabled')->default(false);
            $table->string('whatsapp_number')->nullable();

            // Contacto
            $table->boolean('show_email')->default(true);
            $table->string('contact_email')->nullable();
            $table->boolean('show_phone')->default(true);
            $table->string('contact_phone')->nullable();
            $table->boolean('show_address')->default(true);
            $table->text('contact_address')->nullable();
            $table->boolean('show_map')->default(false);
            $table->text('google_maps_url')->nullable();

            // Hero Section
            $table->boolean('hero_enabled')->default(true);
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_button_text')->nullable();
            $table->string('hero_button_url')->nullable();

            // Hero Background
            $table->enum('hero_background_type', ['color', 'image', 'video'])->default('color');
            $table->string('hero_background_image')->nullable();
            $table->string('hero_background_video')->nullable();
            $table->decimal('hero_overlay_opacity', 3, 2)->default(0.50);

            // About Section
            $table->boolean('about_enabled')->default(true);
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_image')->nullable();

            // Secciones
            $table->boolean('services_enabled')->default(true);
            $table->boolean('products_enabled')->default(true);
            $table->boolean('testimonials_enabled')->default(true);
            $table->boolean('gallery_enabled')->default(true);
            $table->boolean('contact_enabled')->default(true);

            // Footer
            $table->boolean('show_social_footer')->default(true);
            $table->text('footer_text')->nullable();

            // WhatsApp
            $table->boolean('show_whatsapp_button')->default(true);
            $table->string('whatsapp_button_message')->nullable();

            // SEO
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('facebook_pixel_id')->nullable();

            // Otros
            $table->string('notification_email')->nullable();
            $table->text('business_hours')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
