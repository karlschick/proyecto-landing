@extends('admin.layout')

@section('title', 'Editar Contenido')
@section('page-title', 'Editar Contenido de la Galería')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" id="galleryForm">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Tipo de Archivo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Archivo *</label>
                    <div class="flex gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="type" value="image" {{ old('type', $gallery->type) == 'image' ? 'checked' : '' }} class="mr-2" onchange="updateFileAccept()">
                            <span class="text-gray-700">Imagen</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="type" value="video" {{ old('type', $gallery->type) == 'video' ? 'checked' : '' }} class="mr-2" onchange="updateFileAccept()">
                            <span class="text-gray-700">Video</span>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenido Actual -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $gallery->isVideo() ? 'Video' : 'Imagen' }} Actual</label>
                    <div class="mb-3">
                        @if($gallery->isVideo())
                            <video class="h-48 object-cover rounded-lg shadow" controls>
                                <source src="{{ $gallery->getImageUrl() }}" type="video/mp4">
                                Tu navegador no soporta videos.
                            </video>
                        @else
                            <img src="{{ $gallery->getImageUrl() }}" alt="{{ $gallery->title }}" class="h-48 object-cover rounded-lg shadow">
                        @endif
                    </div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">Reemplazar Archivo (Opcional)</label>
                    <input type="file" name="image" id="fileInput"
                           accept="{{ $gallery->isVideo() ? 'video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/mpeg' : 'image/jpeg,image/png,image/jpg,image/webp' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1" id="fileHint">
                        <span class="imageHint {{ $gallery->isVideo() ? 'hidden' : '' }}">Formatos: JPG, PNG, WEBP. Máx: 5MB.</span>
                        <span class="videoHint {{ $gallery->isVideo() ? '' : 'hidden' }}">Formatos: MP4, MOV, AVI, WMV. Máx: 100MB.</span>
                        Deja en blanco para mantener el archivo actual.
                    </p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Preview -->
                    <div id="filePreview" class="mt-4 hidden">
                        <img id="imagePreview" class="max-h-64 rounded-lg shadow hidden" />
                        <video id="videoPreview" class="max-h-64 rounded-lg shadow hidden" controls></video>
                    </div>
                </div>

                <!-- Título -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título (Opcional)</label>
                    <input type="text" name="title" value="{{ old('title', $gallery->title) }}"
                           placeholder="Título descriptivo"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción (Opcional)</label>
                    <textarea name="description" rows="3"
                              placeholder="Descripción del contenido..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría (Opcional)</label>
                    @if($categories->count() > 0)
                        <div class="flex gap-2">
                            <select name="category" id="category-select"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Sin categoría</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $gallery->category) == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                                <option value="__nueva__">+ Nueva categoría</option>
                            </select>
                        </div>
                        <input type="text" id="new-category" name="new_category" placeholder="Nombre de la nueva categoría"
                               class="hidden mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @else
                        <input type="text" name="category" value="{{ old('category', $gallery->category) }}"
                               placeholder="Ejemplo: Proyectos, Eventos, Testimonios..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @endif
                    <p class="text-xs text-gray-500 mt-1">Ayuda a organizar el contenido por categorías</p>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Orden y Estado -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                        <input type="number" name="order" value="{{ old('order', $gallery->order) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Orden de visualización</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex items-center h-[42px]">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-gray-700">Activo</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between pt-6 border-t mt-8">
                <a href="{{ route('admin.gallery.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                    ← Volver a la galería
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Actualizar Contenido
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar con el tipo correcto
    updateFileAccept();
});

function updateFileAccept() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const fileInput = document.getElementById('fileInput');
    const imageHint = document.querySelector('.imageHint');
    const videoHint = document.querySelector('.videoHint');

    if (type === 'video') {
        fileInput.accept = 'video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/mpeg';
        imageHint.classList.add('hidden');
        videoHint.classList.remove('hidden');
    } else {
        fileInput.accept = 'image/jpeg,image/png,image/jpg,image/webp';
        imageHint.classList.remove('hidden');
        videoHint.classList.add('hidden');
    }

    // Limpiar preview
    document.getElementById('filePreview').classList.add('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('videoPreview').classList.add('hidden');
    fileInput.value = '';
}

// Preview del archivo
document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const preview = document.getElementById('filePreview');
    const imagePreview = document.getElementById('imagePreview');
    const videoPreview = document.getElementById('videoPreview');
    const type = document.querySelector('input[name="type"]:checked').value;

    preview.classList.remove('hidden');

    if (type === 'image') {
        imagePreview.classList.remove('hidden');
        videoPreview.classList.add('hidden');
        imagePreview.src = URL.createObjectURL(file);
    } else {
        imagePreview.classList.add('hidden');
        videoPreview.classList.remove('hidden');
        videoPreview.src = URL.createObjectURL(file);
    }
});

// Categorías
const categorySelect = document.getElementById('category-select');
const newCategoryInput = document.getElementById('new-category');

if (categorySelect && newCategoryInput) {
    categorySelect.addEventListener('change', function() {
        if (this.value === '__nueva__') {
            newCategoryInput.classList.remove('hidden');
            newCategoryInput.focus();
            this.name = '';
            newCategoryInput.name = 'category';
        } else {
            newCategoryInput.classList.add('hidden');
            this.name = 'category';
            newCategoryInput.name = 'new_category';
        }
    });
}
</script>
@endpush
@endsection
