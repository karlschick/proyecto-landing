<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageUploadService;
use App\Services\CacheService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $settings = Setting::getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::getSettings();

        // Validación
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_slogan' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',

            // Colores
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'accent_color' => 'nullable|string|max:7',

            // Redes Sociales
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'whatsapp_number' => 'nullable|string|max:20',
            'whatsapp_button_message' => 'nullable|string|max:255',

            // Contacto
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string',
            'google_maps_url' => 'nullable|string',
            'notification_email' => 'nullable|email',
            'business_hours' => 'nullable|string',

            // Hero
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'hero_button_text' => 'nullable|string|max:50',
            'hero_button_url' => 'nullable|string|max:255',

            // Hero Background
            'hero_background_type' => 'required|in:color,image,video',
            'hero_background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'hero_background_video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
            'hero_overlay_opacity' => 'nullable|numeric|min:0|max:1',

            // About
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Footer
            'footer_text' => 'nullable|string',

            // SEO
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'google_analytics_id' => 'nullable|string|max:50',
            'facebook_pixel_id' => 'nullable|string|max:50',
        ]);

        // Manejar checkboxes (booleanos)
        $checkboxFields = [
            'facebook_enabled', 'instagram_enabled', 'twitter_enabled', 'linkedin_enabled',
            'whatsapp_enabled', 'show_email', 'show_phone', 'show_address', 'show_map',
            'hero_enabled', 'about_enabled', 'services_enabled', 'products_enabled',
            'testimonials_enabled', 'gallery_enabled', 'contact_enabled',
            'show_social_footer', 'show_whatsapp_button'
        ];

        foreach ($checkboxFields as $field) {
            $validated[$field] = $request->has($field);
        }

        try {
            // Manejar subida de Logo
            if ($request->hasFile('logo')) {
                if ($settings->logo) {
                    $this->imageService->delete($settings->logo);
                }
                $validated['logo'] = $this->imageService->upload($request->file('logo'), 'settings');
            }

            // Manejar subida de Favicon
            if ($request->hasFile('favicon')) {
                if ($settings->favicon) {
                    $this->imageService->delete($settings->favicon);
                }
                $validated['favicon'] = $this->imageService->upload($request->file('favicon'), 'settings');
            }

            // Manejar subida de Imagen About
            if ($request->hasFile('about_image')) {
                if ($settings->about_image) {
                    $this->imageService->delete($settings->about_image);
                }
                $validated['about_image'] = $this->imageService->upload($request->file('about_image'), 'settings');
            }

            // Manejar subida de imagen de fondo Hero
            if ($request->hasFile('hero_background_image')) {
                if ($settings->hero_background_image) {
                    $this->imageService->delete('hero/' . $settings->hero_background_image);
                }
                $validated['hero_background_image'] = $this->imageService->upload($request->file('hero_background_image'), 'hero');
            }

            // Manejar subida de video de fondo Hero
            if ($request->hasFile('hero_background_video')) {
                if ($settings->hero_background_video) {
                    $this->imageService->delete('hero/' . $settings->hero_background_video, 'videos');
                }
                $validated['hero_background_video'] = $this->imageService->uploadVideo($request->file('hero_background_video'), 'hero');
            }

            // Actualizar configuración
            $settings->update($validated);

            // Limpiar caché
            CacheService::clearSettings();

            \Log::info('Settings actualizados correctamente', $validated);

            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Configuración actualizada correctamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar settings: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Error al guardar la configuración: ' . $e->getMessage())
                ->withInput();
        }
    }
}
