<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageUploadService;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        // Leer imágenes existentes en public_html/images/about/
        $aboutImagesPath = public_html_path('images/about');
        $galleryImages = [];

        if (File::exists($aboutImagesPath)) {
            $files = File::files($aboutImagesPath);
            foreach ($files as $file) {
                $ext = strtolower($file->getExtension());
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $galleryImages[] = [
                        'filename' => $file->getFilename(),
                        'url'      => asset('images/about/' . $file->getFilename()),
                        'value'    => 'about/' . $file->getFilename(),
                    ];
                }
            }
        }

        return view('admin.about.index', compact('settings', 'galleryImages'));
    }

    public function update(Request $request)
    {
        $settings = Setting::getSettings();

        $request->validate([
            'about_title'            => 'nullable|string|max:255',
            'about_description'      => 'nullable|string',
            'about_image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'about_image_selected'   => 'nullable|string',
        ]);

        $data = $request->only(['about_title', 'about_description']);

        // Si subió una imagen nueva, tiene prioridad
        if ($request->hasFile('about_image')) {
            if ($settings->about_image) {
                $this->imageService->delete($settings->about_image);
            }
            $data['about_image'] = $this->imageService->upload($request->file('about_image'), 'about');
        }
        // Si eligió una imagen existente de la galería
        elseif ($request->filled('about_image_selected')) {
            $data['about_image'] = $request->about_image_selected;
        }

        $settings->update($data);

        CacheService::clearSettings();

        return redirect()->route('admin.about.index')->with('success', 'Sección Nosotros actualizada correctamente.');
    }
}
