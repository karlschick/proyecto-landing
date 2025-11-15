<section id="galeria" class="py-16 bg-gradient-to-b from-[rgb(245,245,0)] to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 animate-from-top">
                CAMBIOS REALES
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto animate-from-bottom">

            </p>
        </div>

        @php
            $galleryImages = \App\Services\CacheService::gallery();
            $galleryCategories = \App\Models\GalleryImage::getCategories();
        @endphp

        @if($galleryImages->count() > 0)
            {{-- Filtros por categoría --}}
            @if($galleryCategories->count() > 1)
            <div class="flex flex-wrap justify-center gap-3 mb-10" x-data="{ activeGalleryCategory: 'all' }">
                <button @click="activeGalleryCategory = 'all'; filterGallery('all')"
                        :class="activeGalleryCategory === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-2 rounded-full font-medium transition">
                    Todas
                </button>
                @foreach($galleryCategories as $category)
                <button @click="activeGalleryCategory = '{{ $category }}'; filterGallery('{{ $category }}')"
                        :class="activeGalleryCategory === '{{ $category }}' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="px-6 py-2 rounded-full font-medium transition">
                    {{ $category }}
                </button>
                @endforeach
            </div>
            @endif

            {{-- Carrusel de contenido --}}
            <div class="relative">
                <div class="swiper gallerySwiper">
                    <div class="swiper-wrapper">
                        @foreach($galleryImages as $item)
                        <div class="swiper-slide" data-category="{{ $item->category ?? 'sin-categoria' }}">
                            <div class="relative aspect-square overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer group"
                                 onclick="openLightbox('{{ $item->getImageUrl() }}', '{{ addslashes($item->title ?? '') }}', '{{ addslashes($item->description ?? '') }}', '{{ $item->type }}')">

                                @if($item->isVideo())
                                    {{-- Thumbnail del video con icono de play --}}
                                    <video class="w-full h-full object-cover" muted>
                                        <source src="{{ $item->getImageUrl() }}" type="video/mp4">
                                    </video>

                                    {{-- Icono de Play --}}
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/50 transition-all">
                                        <div class="bg-white rounded-full p-6 transform group-hover:scale-110 transition-transform shadow-2xl">
                                            <svg class="w-12 h-12 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    {{-- Imagen normal --}}
                                    <img src="{{ $item->getImageUrl() }}"
                                         alt="{{ $item->title ?? 'Imagen de galería' }}"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @endif

                                {{-- Overlay con información --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                                    @if($item->title)
                                    <h3 class="text-white font-bold text-lg mb-1">{{ $item->title }}</h3>
                                    @endif
                                    @if($item->description)
                                    <p class="text-white/90 text-sm">{{ Str::limit($item->description, 80) }}</p>
                                    @endif
                                </div>

                                {{-- Icono de zoom --}}
                                <div class="absolute top-4 right-4 bg-white/90 rounded-full p-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg">
                                    @if($item->isVideo())
                                        <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                        </svg>
                                    @endif
                                </div>

                                {{-- Badge de categoría --}}
                                @if($item->category)
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full shadow-lg">
                                        {{ $item->category }}
                                    </span>
                                </div>
                                @endif

                                {{-- Badge de tipo --}}
                                @if($item->isVideo())
                                <div class="absolute bottom-4 right-4">
                                    <span class="px-3 py-1 bg-purple-600 text-white text-xs font-semibold rounded-full shadow-lg flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Video
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Botones de navegación --}}
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                    {{-- Paginación --}}
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">🖼️</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">
                    No hay contenido en la galería
                </h3>
                <p class="text-gray-500">
                    Las imágenes y videos se mostrarán aquí una vez que sean agregados.
                </p>
            </div>
        @endif
    </div>
</section>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-95 hidden items-center justify-center z-50 p-4" onclick="closeLightbox()">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition z-10">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <div class="max-w-6xl w-full" onclick="event.stopPropagation()">
        {{-- Imagen --}}
        <img id="lightboxImage" src="" alt="" class="w-full h-auto max-h-[85vh] object-contain rounded-lg shadow-2xl hidden">

        {{-- Video --}}
        <video id="lightboxVideo" controls class="w-full h-auto max-h-[85vh] object-contain rounded-lg shadow-2xl hidden">
            <source src="" type="video/mp4">
            Tu navegador no soporta la reproducción de videos.
        </video>

        <div class="mt-6 text-center">
            <h3 id="lightboxTitle" class="text-white text-2xl font-bold mb-2"></h3>
            <p id="lightboxDescription" class="text-gray-300 text-lg"></p>
        </div>
    </div>
</div>

{{-- Swiper CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

{{-- Custom CSS --}}
<style>
.gallerySwiper {
    padding: 20px 50px 60px;
}

.swiper-slide {
    height: auto;
}

.swiper-button-next,
.swiper-button-prev {
    background: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: #2563eb;
    transform: scale(1.1);
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 20px;
    font-weight: bold;
    color: #1f2937;
}

.swiper-button-next:hover::after,
.swiper-button-prev:hover::after {
    color: white;
}

.swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: #d1d5db;
    opacity: 1;
    transition: all 0.3s ease;
}

.swiper-pagination-bullet-active {
    background: #2563eb;
    width: 30px;
    border-radius: 6px;
}

@media (max-width: 640px) {
    .gallerySwiper {
        padding: 10px 30px 50px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        width: 40px;
        height: 40px;
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 16px;
    }
}
</style>

{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

{{-- Scripts --}}
<script>
let gallerySwiper;

document.addEventListener('DOMContentLoaded', function() {
    initSwiper();
});

function initSwiper() {
    gallerySwiper = new Swiper('.gallerySwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 25,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });
}

function filterGallery(category) {
    const slides = document.querySelectorAll('.swiper-slide');

    if (category === 'all') {
        slides.forEach(slide => slide.style.display = 'block');
    } else {
        slides.forEach(slide => {
            if (slide.dataset.category === category) {
                slide.style.display = 'block';
            } else {
                slide.style.display = 'none';
            }
        });
    }

    if (gallerySwiper) {
        gallerySwiper.update();
    }
}

function openLightbox(src, title, description, type) {
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxVideo = document.getElementById('lightboxVideo');

    if (type === 'video') {
        lightboxImage.classList.add('hidden');
        lightboxVideo.classList.remove('hidden');
        lightboxVideo.querySelector('source').src = src;
        lightboxVideo.load();
    } else {
        lightboxVideo.classList.add('hidden');
        lightboxImage.classList.remove('hidden');
        lightboxImage.src = src;
    }

    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxDescription').textContent = description;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightboxVideo = document.getElementById('lightboxVideo');

    // Pausar video si está reproduciéndose
    if (!lightboxVideo.classList.contains('hidden')) {
        lightboxVideo.pause();
    }

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
