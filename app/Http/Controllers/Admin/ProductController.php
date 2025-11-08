<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Requests\ProductRequest;
use App\Services\ImageUploadService;
use App\Services\CacheService; // 🔹 añadido
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filtros
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->has('stock') && $request->stock != '') {
            if ($request->stock === 'in_stock') {
                $query->inStock();
            } elseif ($request->stock === 'low_stock') {
                $query->where('track_quantity', true)
                      ->where('quantity', '>', 0)
                      ->where('quantity', '<=', 10);
            } elseif ($request->stock === 'out_of_stock') {
                $query->where('track_quantity', true)
                      ->where('quantity', '<=', 0);
            }
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->ordered()->paginate(20);
        $categories = ProductCategory::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::active()->ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        // Manejar imagen destacada
        if ($request->hasFile('featured_image')) {
            try {
                $validated['featured_image'] = $this->imageService->upload(
                    $request->file('featured_image'),
                    'products'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al subir la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // Manejar galería de imágenes
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                try {
                    $galleryImages[] = $this->imageService->upload($image, 'products');
                } catch (\Exception $e) {
                    \Log::warning('Error al subir imagen de galería: ' . $e->getMessage());
                }
            }
            $validated['gallery_images'] = $galleryImages;
        }

        Product::create($validated);

        CacheService::clearProducts(); // 🔹 Limpia caché del shop en landing

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::active()->ordered()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        // Manejar imagen destacada
        if ($request->hasFile('featured_image')) {
            try {
                if ($product->featured_image) {
                    $this->imageService->delete('products/' . $product->featured_image);
                }

                $validated['featured_image'] = $this->imageService->upload(
                    $request->file('featured_image'),
                    'products'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al actualizar la imagen: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // Manejar galería de imágenes
        if ($request->hasFile('gallery_images')) {
            if ($product->gallery_images) {
                foreach ($product->gallery_images as $oldImage) {
                    $this->imageService->delete('products/' . $oldImage);
                }
            }

            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                try {
                    $galleryImages[] = $this->imageService->upload($image, 'products');
                } catch (\Exception $e) {
                    \Log::warning('Error al subir imagen de galería: ' . $e->getMessage());
                }
            }
            $validated['gallery_images'] = $galleryImages;
        }

        $product->update($validated);

        CacheService::clearProducts(); // 🔹 limpia caché al actualizar

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product)
    {
        // Verificar si tiene órdenes
        if ($product->orderItems()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar un producto con órdenes asociadas.');
        }

        // Eliminar imágenes
        if ($product->featured_image) {
            $this->imageService->delete('products/' . $product->featured_image);
        }

        if ($product->gallery_images) {
            foreach ($product->gallery_images as $image) {
                $this->imageService->delete('products/' . $image);
            }
        }

        $product->delete();

        CacheService::clearProducts(); // 🔹 limpia caché al eliminar

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update(['quantity' => $request->quantity]);

        CacheService::clearProducts(); // 🔹 también actualiza el shop

        return response()->json([
            'success' => true,
            'message' => 'Stock actualizado',
            'quantity' => $product->quantity,
        ]);
    }
}
