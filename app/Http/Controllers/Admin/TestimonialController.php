<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Http\Requests\TestimonialRequest;
use App\Services\CacheService;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::ordered()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(TestimonialRequest $request)
    {
        $validated = $request->validated();

        // Manejar foto (MISMA LÓGICA QUE PROJECTS)
        if ($request->hasFile('client_photo')) {
            $image = $request->file('client_photo');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Guardar en public/images/testimonials/
            $destinationPath = public_path('images/testimonials');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);

            $validated['client_photo'] = 'testimonials/' . $filename;
        }

        Testimonial::create($validated);

        // Limpiar caché
        CacheService::clearTestimonials();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonio creado exitosamente.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $validated = $request->validated();

        // Manejar foto (MISMA LÓGICA QUE PROJECTS)
        if ($request->hasFile('client_photo')) {
            // Eliminar foto anterior si existe
            if ($testimonial->client_photo) {
                $oldImagePath = public_path('images/' . $testimonial->client_photo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('client_photo');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Guardar en public/images/testimonials/
            $destinationPath = public_path('images/testimonials');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $filename);

            $validated['client_photo'] = 'testimonials/' . $filename;
        }

        $testimonial->update($validated);

        // Limpiar caché
        CacheService::clearTestimonials();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonio actualizado exitosamente.');
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            // Eliminar la foto si existe
            if ($testimonial->client_photo) {
                $imagePath = public_path('images/' . $testimonial->client_photo);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $testimonial->delete();

            // Limpiar caché
            CacheService::clearTestimonials();

            return redirect()
                ->route('admin.testimonials.index')
                ->with('success', 'Testimonio eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.testimonials.index')
                ->with('error', 'Error al eliminar el testimonio: ' . $e->getMessage());
        }
    }
}
