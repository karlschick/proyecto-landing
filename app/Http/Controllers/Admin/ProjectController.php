<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Mostrar listado de proyectos
     */
    public function index()
    {
        $projects = Project::orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Guardar nuevo proyecto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Generar slug único
        $slug = Str::slug($validated['title']);
        $count = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['title']) . '-' . $count;
            $count++;
        }

        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_featured'] = 0; // Valor por defecto
        $validated['order'] = $validated['order'] ?? 0;

        // Manejar la imagen
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Guardar en public/images/projects/
            $destinationPath = public_path('images/projects');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);

            $validated['featured_image'] = 'projects/' . $filename;
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Actualizar proyecto
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Actualizar slug si cambió el título
        if ($validated['title'] !== $project->title) {
            $slug = Str::slug($validated['title']);
            $count = 1;
            while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = Str::slug($validated['title']) . '-' . $count;
                $count++;
            }
            $validated['slug'] = $slug;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['order'] = $validated['order'] ?? 0;

        // Manejar la imagen
        if ($request->hasFile('featured_image')) {
            // Eliminar imagen anterior si existe
            if ($project->featured_image) {
                $oldImagePath = public_path('images/' . $project->featured_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Guardar en public/images/projects/
            $destinationPath = public_path('images/projects');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);

            $validated['featured_image'] = 'projects/' . $filename;
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Eliminar proyecto
     */
    public function destroy(Project $project)
    {
        try {
            // Eliminar la imagen si existe
            if ($project->featured_image) {
                // Intentar eliminar de storage/app/public
                if (\Storage::disk('public')->exists($project->featured_image)) {
                    \Storage::disk('public')->delete($project->featured_image);
                }

                // Intentar eliminar de public/images
                $imagePath = public_path('images/' . $project->featured_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Eliminar el proyecto
            $project->delete();

            return redirect()->route('admin.projects.index')
                ->with('success', 'Proyecto eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Error al eliminar el proyecto: ' . $e->getMessage());
        }
    }
}
