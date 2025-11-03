<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Http\Requests\GalleryRequest;
use App\Services\ImageUploadService;
use App\Services\CacheService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = GalleryImage::query();

        // Filtrar por categoría si se proporciona
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $images = $query->ordered()->paginate(12);
        $categories = GalleryImage::getCategories();

        return view('admin.gallery.index', compact('images', 'categories'));
    }

    public function create()
    {
        $categories = GalleryImage::getCategories();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(GalleryRequest $request)
    {
        $validated = $request->validated();

        // Manejar imagen
        if ($request->hasFile('image')) {
            try {
                $validated['image'] = $this->imageService->upload(
                    $request->file('image'),
                    'gallery'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al subir la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        GalleryImage::create($validated);

        // Limpiar caché
        CacheService::clearGallery();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Imagen agregada a la galería exitosamente.');
    }

    public function edit(GalleryImage $gallery)
    {
        $categories = GalleryImage::getCategories();
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(GalleryRequest $request, GalleryImage $gallery)
    {
        $validated = $request->validated();

        // Manejar imagen
        if ($request->hasFile('image')) {
            try {
                // Eliminar imagen anterior
                if ($gallery->image) {
                    $this->imageService->delete('gallery/' . $gallery->image);
                }

                // Subir nueva imagen
                $validated['image'] = $this->imageService->upload(
                    $request->file('image'),
                    'gallery'
                );
                } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al actualizar la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $gallery->update($validated);

        // Limpiar caché
        CacheService::clearGallery();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Imagen actualizada exitosamente.');
    }

    public function destroy(GalleryImage $gallery)
    {
        // Eliminar imagen
        if ($gallery->image) {
            $this->imageService->delete('gallery/' . $gallery->image);
        }

        $gallery->delete();

        // Limpiar caché
        CacheService::clearGallery();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Imagen eliminada exitosamente.');
    }

    /**
     * Upload múltiple de imágenes
     */
    public function uploadMultiple(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'category' => 'nullable|string|max:100',
        ]);

        $uploadedCount = 0;
        $errors = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                try {
                    $filename = $this->imageService->upload($file, 'gallery');

                    GalleryImage::create([
                        'image' => $filename,
                        'category' => $request->category,
                        'is_active' => true,
                        'order' => 0,
                    ]);

                    $uploadedCount++;
                } catch (\Exception $e) {
                    $errors[] = $file->getClientOriginalName() . ': ' . $e->getMessage();
                }
            }
        }

        // Limpiar caché
        CacheService::clearGallery();

        if ($uploadedCount > 0) {
            $message = "{$uploadedCount} imágenes agregadas exitosamente.";

            if (count($errors) > 0) {
                $message .= " Errores: " . implode(', ', $errors);
            }

            return redirect()
                ->route('admin.gallery.index')
                ->with('success', $message);
        }

        return redirect()
            ->back()
            ->with('error', 'No se pudo subir ninguna imagen. Errores: ' . implode(', ', $errors))
            ->withInput();
    }
}
