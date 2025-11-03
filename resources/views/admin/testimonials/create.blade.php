@extends('admin.layout')

@section('title', 'Nuevo Testimonio')
@section('page-title', 'Crear Nuevo Testimonio')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Nombre del Cliente -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Cliente *</label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('client_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cargo y Empresa -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cargo/Posición</label>
                        <input type="text" name="client_position" value="{{ old('client_position') }}"
                               placeholder="CEO, Director, etc."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('client_position')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                        <input type="text" name="client_company" value="{{ old('client_company') }}"
                               placeholder="Nombre de la empresa"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('client_company')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Testimonio -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Testimonio *</label>
                    <textarea name="testimonial" rows="6" required
                              placeholder="Escribe aquí el testimonio del cliente..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('testimonial') }}</textarea>
                    @error('testimonial')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto del Cliente -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto del Cliente</label>
                    <input type="file" name="client_photo" accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. Máx: 2MB. Opcional: se mostrarán iniciales si no se sube foto.</p>
                    @error('client_photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Calificación *</label>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}"
                                       {{ old('rating', 5) == $i ? 'checked' : '' }}
                                       class="sr-only peer">
                                <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-300 transition fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Selecciona de 1 a 5 estrellas</p>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Orden, Destacado y Estado -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Orden de visualización (menor número = aparece primero)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opciones</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <label for="is_featured" class="ml-2 text-gray-700">Testimonio Destacado</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 text-gray-700">Testimonio Activo</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between pt-6 border-t mt-8">
                <a href="{{ route('admin.testimonials.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    ← Volver a la lista
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Crear Testimonio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
