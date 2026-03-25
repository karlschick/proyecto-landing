@extends('admin.layout')

@section('title', 'Sección Nosotros')
@section('page-title', 'Editor - Sección Nosotros')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow p-6 space-y-5">

            {{-- Título --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                <input type="text" name="about_title"
                       value="{{ old('about_title', $settings->about_title) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="about_description" rows="5"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('about_description', $settings->about_description) }}</textarea>
            </div>

            {{-- Imagen --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Imagen</label>
                @if($settings->about_image)
                    <div class="mb-3">
                        <img src="{{ $settings->getAboutImageUrl() }}" alt="Imagen About"
                             class="h-40 object-cover rounded-lg shadow">
                        <p class="text-xs text-gray-500 mt-1">Imagen actual</p>
                    </div>
                @endif
                <input type="file" name="about_image" accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. Máx: 5MB.</p>
            </div>

            {{-- Botón --}}
            <div class="pt-2">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                    Guardar cambios
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
