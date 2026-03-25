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
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_html_path('images/services');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);
            $validated['image'] = 'services/' . $filename;
        }

        Service::create($validated);
        CacheService::clearServices();

        return redirect()->route('admin.services.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        if ($request->title !== $service->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $service->id);
        }

        // Si seleccionó una imagen existente y no subió una nueva
        if (!$request->hasFile('image') && $request->filled('image_selected')) {
            $validated['image'] = $request->image_selected;
        }

        if ($request->hasFile('image')) {
            if ($service->image) {
                $oldImagePath = public_html_path('images/' . $service->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_html_path('images/services');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);
            $validated['image'] = 'services/' . $filename;
        }

        $service->update($validated);
        CacheService::clearServices();

        return redirect()->route('admin.services.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroy(Service $service)
    {
        try {
            if ($service->image) {
                $imagePath = public_html_path('images/' . $service->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $service->delete();
            CacheService::clearServices();

            return redirect()->route('admin.services.index')->with('success', 'Servicio eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.services.index')->with('error', 'Error al eliminar el servicio: ' . $e->getMessage());
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
