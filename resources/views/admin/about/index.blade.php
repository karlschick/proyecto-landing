@extends('admin.layout')

@section('title', 'Sección Nosotros')
@section('page-title', 'Editor - Sección Nosotros')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow p-6 space-y-6">

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
                <textarea name="about_description" rows="6"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('about_description', $settings->about_description) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Cada salto de línea se muestra como párrafo separado.</p>
            </div>

            {{-- Imagen actual --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Imagen de la sección</label>

                {{-- Preview imagen actual --}}
                <div id="preview-container" class="mb-4 {{ $settings->about_image ? '' : 'hidden' }}">
                    <p class="text-xs text-gray-500 mb-2">Imagen actual:</p>
                    <img id="preview-img"
                         src="{{ $settings->about_image ? $settings->getAboutImageUrl() : '' }}"
                         alt="Imagen actual"
                         class="h-48 object-cover rounded-lg shadow border border-gray-200">
                </div>

                {{-- Input oculto para imagen seleccionada de galería --}}
                <input type="hidden" name="about_image_selected" id="about_image_selected"
                       value="{{ $settings->about_image }}">

                {{-- Subir nueva imagen --}}
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subir nueva imagen</label>
                    <input type="file" name="about_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           id="file-upload"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Formatos: JPG, PNG, WEBP. Máx: 5MB.</p>
                </div>

                {{-- Galería de imágenes existentes en /images/about/ --}}
                @if(count($galleryImages) > 0)
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">
                        O elegir de las imágenes existentes en <code class="bg-gray-100 px-1 rounded">images/about/</code>
                    </label>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 max-h-72 overflow-y-auto">
                        @foreach($galleryImages as $img)
                        <div class="gallery-item cursor-pointer group relative"
                             data-value="{{ $img['value'] }}"
                             data-url="{{ $img['url'] }}"
                             onclick="selectGalleryImage(this)">
                            <img src="{{ $img['url'] }}"
                                 alt="{{ $img['filename'] }}"
                                 class="w-full h-20 object-cover rounded-lg border-2 border-transparent group-hover:border-blue-400 transition">
                            <div class="absolute inset-0 rounded-lg border-2 border-transparent pointer-events-none selected-border transition"></div>
                            <p class="text-xs text-gray-400 mt-1 truncate text-center">{{ $img['filename'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Haz clic en una imagen para seleccionarla. Si subes una imagen nueva, tiene prioridad.</p>
                </div>
                @else
                <div class="p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300 text-center">
                    <p class="text-sm text-gray-400">No hay imágenes en <code>public_html/images/about/</code></p>
                    <p class="text-xs text-gray-400 mt-1">Sube una imagen usando el campo de arriba.</p>
                </div>
                @endif
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

@push('scripts')
<script>
// Marcar imagen activa al cargar
document.addEventListener('DOMContentLoaded', function () {
    const currentValue = document.getElementById('about_image_selected').value;
    if (currentValue) {
        document.querySelectorAll('.gallery-item').forEach(item => {
            if (item.dataset.value === currentValue) {
                markSelected(item);
            }
        });
    }

    // Preview al seleccionar archivo nuevo
    document.getElementById('file-upload').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-container').classList.remove('hidden');
                // Deseleccionar galería
                document.querySelectorAll('.gallery-item img').forEach(img => {
                    img.classList.remove('border-blue-500');
                    img.classList.add('border-transparent');
                });
                document.getElementById('about_image_selected').value = '';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});

function selectGalleryImage(el) {
    // Limpiar selección anterior
    document.querySelectorAll('.gallery-item img').forEach(img => {
        img.classList.remove('border-blue-500');
        img.classList.add('border-transparent');
    });

    // Marcar la seleccionada
    markSelected(el);

    // Actualizar hidden input y preview
    document.getElementById('about_image_selected').value = el.dataset.value;
    document.getElementById('preview-img').src = el.dataset.url;
    document.getElementById('preview-container').classList.remove('hidden');

    // Limpiar el file input para que no tenga prioridad
    document.getElementById('file-upload').value = '';
}

function markSelected(el) {
    const img = el.querySelector('img');
    img.classList.remove('border-transparent');
    img.classList.add('border-blue-500');
}
</script>
@endpush

@endsection
