<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageUploadService;
use App\Services\CacheService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $settings = Setting::getSettings();
        return view('admin.about.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::getSettings();

        $request->validate([
            'about_title'       => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['about_title', 'about_description']);


        if ($request->hasFile('about_image')) {
            if ($settings->about_image) {
                $this->imageService->delete($settings->about_image);
            }
            $data['about_image'] = $this->imageService->upload($request->file('about_image'), 'settings');
        }

        $settings->update($data);

        CacheService::clearSettings();

        return redirect()->route('admin.about.index')->with('success', 'Sección Nosotros actualizada correctamente.');
    }
}
