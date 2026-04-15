@extends('admin.layout')

@section('title', 'Nuevo Servicio')
@section('page-title', 'Crear Nuevo Servicio')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Título -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icono (Emoji) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icono (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" placeholder="📋 💻 🎨 📱"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Puedes usar un emoji como icono. Ejemplo: 💻</p>
                    @error('icon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción Corta -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Corta</label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}"
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
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagen -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, WEBP. Máx: 2MB</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Orden y Estado -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Orden de visualización (menor número = aparece primero)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex items-center h-[42px]">
                            <input type="hidden" name="is_active" value="0">  {{-- ← AGREGAR ESTA LÍNEA --}}
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}  {{-- ← CAMBIAR el "checked" hardcodeado por esto --}}
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
                    Crear Servicio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
