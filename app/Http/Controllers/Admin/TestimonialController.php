<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Http\Requests\TestimonialRequest;
use App\Services\ImageUploadService;
use App\Services\CacheService;

class TestimonialController extends Controller
{
    protected ImageUploadService $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

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

        // Manejar foto
        if ($request->hasFile('client_photo')) {
            try {
                $validated['client_photo'] = $this->imageService->upload(
                    $request->file('client_photo'),
                    'testimonials'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al subir la foto: ' . $e->getMessage())
                    ->withInput();
            }
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

        // Manejar foto
        if ($request->hasFile('client_photo')) {
            try {
                // Eliminar foto anterior
                if ($testimonial->client_photo) {
                    $this->imageService->delete('testimonials/' . $testimonial->client_photo);
                }

                // Subir nueva foto
                $validated['client_photo'] = $this->imageService->upload(
                    $request->file('client_photo'),
                    'testimonials'
                );
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al actualizar la foto: ' . $e->getMessage())
                    ->withInput();
            }
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
        // Eliminar foto
        if ($testimonial->client_photo) {
            $this->imageService->delete('testimonials/' . $testimonial->client_photo);
        }

        $testimonial->delete();

        // Limpiar caché
        CacheService::clearTestimonials();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonio eliminado exitosamente.');
    }
}
