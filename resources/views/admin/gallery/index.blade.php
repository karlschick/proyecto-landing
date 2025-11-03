@extends('admin.layout')

@section('title', 'Galería')
@section('page-title', 'Gestión de Galería')

@section('content')
<div class="mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Galería de Imágenes</h3>
            <p class="text-gray-600 mt-1">Administra las imágenes de tu galería</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.gallery.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Imagen
            </a>
        </div>
    </div>

    <!-- Filtros -->
    @if($categories->count() > 0)
    <div class="mt-4">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <label class="text-sm font-medium text-gray-700">Filtrar por categoría:</label>
            <select name="category" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todas las categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
            @if(request('category'))
                <a href="{{ route('admin.gallery.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Limpiar filtro
                </a>
            @endif
        </form>
    </div>
    @endif
</div>

@if($images->count() > 0)
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($images as $image)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
        <!-- Imagen -->
        <div class="relative aspect-square bg-gray-100">
            <img src="{{ $image->getImageUrl() }}" alt="{{ $image->title }}" class="w-full h-full object-cover">

            <!-- Overlay con acciones -->
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                <div class="flex gap-2">
                    <a href="{{ route('admin.gallery.edit', $image) }}"
                       class="bg-white text-blue-600 p-2 rounded-lg hover:bg-blue-50 transition"
                       title="Editar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta imagen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-white text-red-600 p-2 rounded-lg hover:bg-red-50 transition"
                                title="Eliminar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Badge de estado -->
            @if(!$image->is_active)
            <div class="absolute top-2 right-2">
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500 text-white">
                    Inactivo
                </span>
            </div>
            @endif
        </div>

        <!-- Info -->
        <div class="p-3">
            @if($image->title)
                <h4 class="font-medium text-gray-800 text-sm truncate">{{ $image->title }}</h4>
            @else
                <h4 class="font-medium text-gray-400 text-sm italic">Sin título</h4>
            @endif

            @if($image->category)
                <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">
                    {{ $image->category }}
                </span>
            @endif

            <div class="mt-2 text-xs text-gray-500">
                Orden: {{ $image->order }}
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6">
    {{ $images->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow p-12 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay imágenes en la galería</h3>
    <p class="text-gray-500 mb-6">Comienza agregando tu primera imagen</p>
    <a href="{{ route('admin.gallery.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        Agregar Primera Imagen
    </a>
</div>
@endif
@endsection
