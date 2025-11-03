<section id="galeria" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 animate-from-top">
                Galería
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto animate-from-bottom">
                Mira algunos momentos destacados de nuestro trabajo
            </p>
        </div>

        @php
            $galleryImages = \App\Services\CacheService::gallery();
            $galleryCategories = \App\Models\GalleryImage::getCategories();
        @endphp

        {{-- Filtros por categoría --}}
        @if($galleryCategories->count() > 1)
        <div class="flex flex-wrap justify-center gap-3 mb-10" x-data="{ activeGalleryCategory: 'all' }">
            <button @click="activeGalleryCategory = 'all'"
                    :class="activeGalleryCategory === 'all' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                    class="px-6 py-2 rounded-full font-medium transition">
                Todas
            </button>
            @foreach($galleryCategories as $category)
            <button @click="activeGalleryCategory = '{{ $category }}'"
                    :class="activeGalleryCategory === '{{ $category }}' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                    class="px-6 py-2 rounded-full font-medium transition">
                {{ $category }}
            </button>
            @endforeach
        </div>
        @endif

        @if($galleryImages->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galleryImages as $image)
            <div class="relative aspect-square overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 cursor-pointer group"
                 x-data="{ galleryCategory: '{{ $image->category ?? 'sin-categoria' }}' }"
                 x-show="activeGalleryCategory === 'all' || activeGalleryCategory === galleryCategory"
                 onclick="openLightbox('{{ $image->getImageUrl() }}', '{{ addslashes($image->title ?? '') }}', '{{ addslashes($image->description ?? '') }}')">

                <img src="{{ $image->getImageUrl() }}"
                     alt="{{ $image->title ?? 'Imagen de galería' }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                    @if($image->title)
                    <p class="text-white font-semibold text-sm">{{ $image->title }}</p>
                    @endif
                </div>

                {{-- Icono de zoom --}}
                <div class="absolute top-3 right-3 bg-white/90 rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                    </svg>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🖼️</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">
                No hay imágenes en la galería
            </h3>
            <p class="text-gray-500">
                Las imágenes se mostrarán aquí una vez que sean agregadas.
            </p>
        </div>
        @endif
    </div>
</section>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-95 hidden items-center justify-center z-50 p-4" onclick="closeLightbox()">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition z-10">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <div class="max-w-6xl w-full" onclick="event.stopPropagation()">
        <img id="lightboxImage" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
        <div class="mt-4 text-center">
            <h3 id="lightboxTitle" class="text-white text-xl font-bold mb-2"></h3>
            <p id="lightboxDescription" class="text-gray-300"></p>
        </div>
    </div>
</div>

<script>
function openLightbox(src, title, description) {
    document.getElementById('lightboxImage').src = src;
    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxDescription').textContent = description;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeLightbox();
    }
});
</script>
