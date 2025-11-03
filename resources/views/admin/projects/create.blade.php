@extends('admin.layout')

@section('title', 'Nuevo Proyecto')
@section('page-title', 'Crear Nuevo Proyecto')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
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

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Sin categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción Corta -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción Corta</label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}"
                           maxlength="500" placeholder="Resumen breve del proyecto"
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

                <!-- Cliente y Fecha -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                        <input type="text" name="client" value="{{ old('client') }}"
                               placeholder="Nombre del cliente"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del Proyecto</label>
                        <input type="date" name="project_date" value="{{ old('project_date') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- URL del Proyecto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL del Proyecto</label>
                    <input type="url" name="url" value="{{ old('url') }}"
                           placeholder="https://ejemplo.com"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">URL donde se puede ver el proyecto en vivo</p>
                </div>

                <!-- Imagen Destacada -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Destacada</label>
                    <input type="file" name="featured_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, WEBP. Máx: 5MB</p>
                    @error('featured_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Orden, Destacado y Estado -->
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Orden de visualización</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opciones</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <label for="is_featured" class="ml-2 text-sm text-gray-700">Proyecto Destacado</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                       class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 text-sm text-gray-700">Proyecto Activo</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between pt-6 border-t mt-8">
                <a href="{{ route('admin.projects.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    ← Volver a la lista
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Crear Proyecto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
