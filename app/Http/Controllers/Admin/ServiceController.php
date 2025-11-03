<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use App\Services\ImageUploadService;
use App\Services\CacheService;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $services = Service::ordered()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();

        // Generar slug único
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        // Manejar imagen
        if ($request->hasFile('image')) {
            try {
                $validated['image'] = $this->imageService->upload(
                    $request->file('image'),
                    'services'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al subir la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        Service::create($validated);

        // Limpiar caché
        CacheService::clearServices();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio creado exitosamente.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        // Actualizar slug solo si cambió el título
        if ($request->title !== $service->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $service->id);
        }

        // Manejar imagen
        if ($request->hasFile('image')) {
            try {
                // Eliminar imagen anterior
                if ($service->image) {
                    $this->imageService->delete('services/' . $service->image);
                }

                // Subir nueva imagen
                $validated['image'] = $this->imageService->upload(
                    $request->file('image'),
                    'services'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al actualizar la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $service->update($validated);

        // Limpiar caché
        CacheService::clearServices();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroy(Service $service)
    {
        // Eliminar imagen
        if ($service->image) {
            $this->imageService->delete('services/' . $service->image);
        }

        $service->delete();

        // Limpiar caché
        CacheService::clearServices();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio eliminado exitosamente.');
    }

    /**
     * Generar slug único
     */
    protected function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Verificar si el slug existe
     */
    protected function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = Service::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
