<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use App\Services\CacheService;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
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

        // Manejar imagen (MISMA LÓGICA QUE PROJECTS)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Guardar en public/images/services/
            $destinationPath = public_path('images/services');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);

            $validated['image'] = 'services/' . $filename;
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

        // Manejar imagen (MISMA LÓGICA QUE PROJECTS)
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($service->image) {
                $oldImagePath = public_path('images/' . $service->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Guardar en public/images/services/
            $destinationPath = public_path('images/services');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);

            $validated['image'] = 'services/' . $filename;
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
        try {
            // Eliminar la imagen si existe (MISMA LÓGICA QUE PROJECTS)
            if ($service->image) {
                $imagePath = public_path('images/' . $service->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $service->delete();

            // Limpiar caché
            CacheService::clearServices();

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Servicio eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.services.index')
                ->with('error', 'Error al eliminar el servicio: ' . $e->getMessage());
        }
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
