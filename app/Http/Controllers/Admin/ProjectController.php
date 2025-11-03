<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Http\Requests\ProjectRequest;
use App\Services\ImageUploadService;
use App\Services\CacheService;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $projects = Project::with('category')->ordered()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = ProjectCategory::active()->ordered()->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();

        // Generar slug único
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        // Manejar imagen
        if ($request->hasFile('featured_image')) {
            try {
                $validated['featured_image'] = $this->imageService->upload(
                    $request->file('featured_image'),
                    'projects'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al subir la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        Project::create($validated);

        // Limpiar caché
        CacheService::clearProjects();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    public function edit(Project $project)
    {
        $categories = ProjectCategory::active()->ordered()->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        // Actualizar slug solo si cambió el título
        if ($request->title !== $project->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $project->id);
        }

        // Manejar imagen
        if ($request->hasFile('featured_image')) {
            try {
                // Eliminar imagen anterior
                if ($project->featured_image) {
                    $this->imageService->delete('projects/' . $project->featured_image);
                }

                // Subir nueva imagen
                $validated['featured_image'] = $this->imageService->upload(
                    $request->file('featured_image'),
                    'projects'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al actualizar la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $project->update($validated);

        // Limpiar caché
        CacheService::clearProjects();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy(Project $project)
    {
        // Eliminar imagen
        if ($project->featured_image) {
            $this->imageService->delete('projects/' . $project->featured_image);
        }

        $project->delete();

        // Limpiar caché
        CacheService::clearProjects();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
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
        $query = Project::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
