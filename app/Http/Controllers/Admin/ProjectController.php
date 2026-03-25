<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['title']);
        $count = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['title']) . '-' . $count;
            $count++;
        }

        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_featured'] = 0;
        $validated['order'] = $validated['order'] ?? 0;

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_html_path('images/projects');
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

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

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

        // Si seleccionó una imagen existente y no subió una nueva
        if (!$request->hasFile('featured_image') && $request->filled('image_selected')) {
            $validated['featured_image'] = $request->image_selected;
        }

        if ($request->hasFile('featured_image')) {
            if ($project->featured_image) {
                $oldImagePath = public_html_path('images/' . $project->featured_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_html_path('images/projects');
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

    public function destroy(Project $project)
    {
        try {
            if ($project->featured_image) {
                $imagePath = public_html_path('images/' . $project->featured_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $project->delete();

            return redirect()->route('admin.projects.index')
                ->with('success', 'Proyecto eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Error al eliminar el proyecto: ' . $e->getMessage());
        }
    }
}
