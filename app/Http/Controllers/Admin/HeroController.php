<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\CacheService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $settings = Setting::getSettings();
        return view('admin.hero.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::getSettings();

        $data = $request->only([
            'hero_background_type',
            'hero_overlay_opacity',
            'hero_title',
            'hero_subtitle',
            'hero_button_text',
            'hero_button_url',
        ]);

        // Booleanos
        $data['hero_enabled'] = filter_var($request->input('hero_enabled'), FILTER_VALIDATE_BOOLEAN);
        $data['hero_show_logo_instead'] = filter_var($request->input('hero_show_logo_instead'), FILTER_VALIDATE_BOOLEAN);

        // Imagen seleccionada de la galería
        if (!$request->hasFile('hero_background_image') && $request->filled('hero_background_image_selected')) {
            $data['hero_background_image'] = $request->hero_background_image_selected;
        }

        // Nueva imagen subida
        if ($request->hasFile('hero_background_image')) {
            $data['hero_background_image'] = $this->imageService->upload(
                $request->file('hero_background_image'), 'hero'
            );
        }

        // Video seleccionado de la galería
        if (!$request->hasFile('hero_background_video') && $request->filled('hero_background_video_selected')) {
            $data['hero_background_video'] = $request->hero_background_video_selected;
        }

        // Nuevo video subido
        if ($request->hasFile('hero_background_video')) {
            $data['hero_background_video'] = $this->imageService->uploadVideo(
                $request->file('hero_background_video'), 'hero'
            );
        }

        $settings->update($data);

        CacheService::clearSettings();

        return redirect()->route('admin.hero.index')->with('success', 'Hero actualizado correctamente.');
    }
}
