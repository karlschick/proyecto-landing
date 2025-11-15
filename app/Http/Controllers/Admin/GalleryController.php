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

        // Filtrar por categoría
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filtrar por tipo
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
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

        // Manejar archivo (imagen o video)
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $extension = strtolower($file->getClientOriginalExtension());

                // Determinar si es video basado en la extensión
                $videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'mpeg', 'mpg'];
                $isVideo = in_array($extension, $videoExtensions);

                // Definir carpeta según el tipo
                $folder = $isVideo ? 'videos' : 'gallery';

                // Subir archivo
                $validated['image'] = $this->imageService->upload($file, $folder);
                $validated['type'] = $isVideo ? 'video' : 'image';

                \Log::info('Archivo subido', [
                    'filename' => $validated['image'],
                    'type' => $validated['type'],
                    'folder' => $folder,
                    'extension' => $extension
                ]);

            } catch (\Exception $e) {
                \Log::error('Error al subir archivo: ' . $e->getMessage());
                return redirect()
                    ->back()
                    ->with('error', 'Error al subir el archivo: ' . $e->getMessage())
                    ->withInput();
            }
        }

        GalleryImage::create($validated);
        CacheService::clearGallery();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Archivo agregado a la galería exitosamente.');
    }

    public function edit(GalleryImage $gallery)
    {
        $categories = GalleryImage::getCategories();
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(GalleryRequest $request, GalleryImage $gallery)
    {
        $validated = $request->validated();

        // Manejar archivo nuevo
        if ($request->hasFile('image')) {
            try {
                // Eliminar archivo anterior
                if ($gallery->image) {
                    $oldFolder = $gallery->isVideo() ? 'videos' : 'gallery';
                    $this->imageService->delete($oldFolder . '/' . $gallery->image);
                }

                // Subir nuevo archivo
                $file = $request->file('image');
                $extension = strtolower($file->getClientOriginalExtension());

                $videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'mpeg', 'mpg'];
                $isVideo = in_array($extension, $videoExtensions);

                $folder = $isVideo ? 'videos' : 'gallery';
                $validated['image'] = $this->imageService->upload($file, $folder);
                $validated['type'] = $isVideo ? 'video' : 'image';

            } catch (\Exception $e) {
                \Log::error('Error al actualizar archivo: ' . $e->getMessage());
                return redirect()
                    ->back()
                    ->with('error', 'Error al actualizar el archivo: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $gallery->update($validated);
        CacheService::clearGallery();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Archivo actualizado exitosamente.');
    }

    public function destroy(GalleryImage $gallery)
    {
        // Eliminar archivo
        if ($gallery->image) {
            $folder = $gallery->isVideo() ? 'videos' : 'gallery';
            $this->imageService->delete($folder . '/' . $gallery->image);
        }

        $gallery->delete();
        CacheService::clearGallery();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Archivo eliminado exitosamente.');
    }
}
