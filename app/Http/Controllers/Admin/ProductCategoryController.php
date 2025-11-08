<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Http\Requests\ProductCategoryRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $categories = ProductCategory::withCount('products')
            ->ordered()
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(ProductCategoryRequest $request)
    {
        $validated = $request->validated();

        // Manejar imagen
        if ($request->hasFile('image')) {
            try {
                $validated['image'] = $this->imageService->upload(
                    $request->file('image'),
                    'categories'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al subir la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        ProductCategory::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(ProductCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        $validated = $request->validated();

        // Manejar imagen
        if ($request->hasFile('image')) {
            try {
                // Eliminar imagen anterior
                if ($category->image) {
                    $this->imageService->delete('categories/' . $category->image);
                }

                $validated['image'] = $this->imageService->upload(
                    $request->file('image'),
                    'categories'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al actualizar la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(ProductCategory $category)
    {
        // Verificar si tiene productos
        if ($category->products()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar una categoría con productos asociados.');
        }

        // Eliminar imagen
        if ($category->image) {
            $this->imageService->delete('categories/' . $category->image);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
