@extends('admin.layout')

@section('title', 'Editar Servicio')
@section('page-title', 'Editar Servicio')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Título -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icono (Emoji) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icono (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="📋 💻 🎨 📱"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Puedes usar un emoji como icono. Ejemplo: 💻</p>
                    @error('icon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción Corta -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Corta</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $service->short_description) }}"
                           maxlength="500" placeholder="Una breve descripción de una línea"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres. Se mostrará en las tarjetas.</p>
                    @error('short_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción Completa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Completa *</label>
                    <textarea name="description" rows="6" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $service->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagen -->
                <div x-data="{ selectedImage: '{{ $service->image ?? '' }}' }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen</label>

                    @if($service->image)
                        <div class="mb-3">
                            <img src="{{ $service->getImageUrl() }}" alt="{{ $service->title }}" class="h-32 object-cover rounded-lg shadow">
                            <p class="text-xs text-gray-600 mt-1">Imagen actual: {{ $service->image }}</p>
                        </div>
                    @endif

                    <!-- Galería de imágenes existentes -->
                    @php
                        $servicesImagesPath = public_html_path('images/services');
                        $servicesImages = [];
                        if (is_dir($servicesImagesPath)) {
                            $files = glob($servicesImagesPath . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
                            foreach ($files as $file) {
                                $servicesImages[] = 'services/' . basename($file);
                            }
                        }
                    @endphp

                    @if(count($servicesImages) > 0)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📁 Imágenes guardadas ({{ count($servicesImages) }}) — haz clic para seleccionar
                            </label>
                            <div class="grid grid-cols-3 md:grid-cols-4 gap-2 max-h-64 overflow-y-auto p-2 border border-gray-200 rounded-lg bg-white">
                                @foreach($servicesImages as $img)
                                    <div class="relative cursor-pointer group"
                                         @click="selectedImage = '{{ $img }}'">
                                        <img src="{{ asset('images/' . $img) }}"
                                             alt="{{ basename($img) }}"
                                             class="w-full h-20 object-cover rounded-lg border-2 transition"
                                             :class="selectedImage === '{{ $img }}' ? 'border-blue-500 ring-2 ring-blue-300' : 'border-gray-200 group-hover:border-blue-300'">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition"></div>
                                        @if($service->image === $img)
                                            <span class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-1 rounded">Actual</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="image_selected" :value="selectedImage">
                            <p class="text-xs text-gray-500 mt-1" x-show="selectedImage">
                                ✅ Seleccionada: <span x-text="selectedImage" class="font-medium text-blue-600"></span>
                            </p>
                        </div>
                    @endif

                    <label class="block text-sm font-medium text-gray-700 mb-1">O subir nueva imagen</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, WEBP. Máx: 2MB. Deja en blanco para mantener la imagen actual.</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Orden y Estado -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                        <input type="number" name="order" value="{{ old('order', $service->order) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Orden de visualización (menor número = aparece primero)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex items-center h-[42px]">
                            <input type="hidden" name="is_active" value="0">  {{-- ← AGREGAR ESTA LÍNEA --}}
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-gray-700">Servicio Activo</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between pt-6 border-t mt-8">
                <a href="{{ route('admin.services.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    ← Volver a la lista
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Actualizar Servicio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
