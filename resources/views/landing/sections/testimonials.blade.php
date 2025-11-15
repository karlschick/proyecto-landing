<!-- Testimonios -->
<section class="py-16 bg-gradient-to-b from-black to-[rgb(245,245,0)] relative overflow-hidden">
    {{-- Patrón de fondo --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-yellow-400 mb-4 testimonial-title">
                Lo que dicen nuestros clientes
            </h2>
            <p class="text-yellow-400 max-w-2xl mx-auto testimonial-subtitle">
                Experiencias reales de personas que han transformado su vida
            </p>
        </div>

        @php
            $testimonials = \App\Models\Testimonial::active()->ordered()->get();

            $defaultImages = [
                1 => asset('images/settings/default-testimonial-1.jpg'),
                2 => asset('images/settings/default-testimonial-2.jpg'),
                3 => asset('images/settings/default-testimonial-3.jpg'),
                4 => asset('images/settings/default-testimonial-4.jpg'),
                5 => asset('images/settings/default-testimonial-5.jpg'),
            ];

            $testimonialCount = $testimonials->count();
        @endphp

        @if($testimonialCount > 0)
            {{-- Carrusel con Swiper --}}
            <div class="swiper testimonialsSwiper">
                <div class="swiper-wrapper pb-12">
                    @foreach($testimonials as $testimonial)
                        @php
                            $fallbackImage = $defaultImages[$loop->iteration] ?? asset('images/settings/default-testimonial-1.jpg');

                            if (!empty($testimonial->client_photo) && !str_contains($testimonial->client_photo, 'default-testimonial')) {
                                $photoUrl = $testimonial->getPhotoUrl();
                            } else {
                                $photoUrl = $fallbackImage;
                            }
                        @endphp

                        <div class="swiper-slide">
                            <div class="bg-gradient-to-br from-gray-900 to-black rounded-2xl shadow-2xl p-6 hover:shadow-yellow-500/30 transition-all duration-500 transform hover:-translate-y-2 flex flex-col justify-between max-w-md mx-auto" style="min-height: 360px;">

                                {{-- Contenido superior (Comillas y Testimonio) --}}
                                <div class="flex-grow">
                                    {{-- Comillas decorativas --}}
                                    <div class="text-yellow-400 text-4xl font-serif mb-3 leading-none">"</div>

                                    {{-- Testimonio --}}
                                    <p class="text-gray-200 text-sm leading-relaxed italic line-clamp-6">
                                        {{ $testimonial->testimonial }}
                                    </p>
                                </div>

                                {{-- Sección inferior FIJA (Rating + Autor) --}}
                                <div class="mt-auto pt-4 space-y-3">
                                    {{-- Rating --}}
                                    <div class="flex items-center gap-1 justify-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-600 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>

                                    {{-- Línea divisoria --}}
                                    <div class="border-t border-gray-700"></div>

                                    {{-- Autor --}}
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $photoUrl }}"
                                             alt="{{ $testimonial->client_name }}"
                                             class="w-12 h-12 rounded-full object-cover border-2 border-yellow-400 flex-shrink-0"
                                             onerror="this.src='{{ $fallbackImage }}'">
                                        <div class="text-left">
                                            <h4 class="font-bold text-white text-sm">{{ $testimonial->client_name }}</h4>
                                            @if($testimonial->client_position || $testimonial->client_company)
                                                <p class="text-xs text-gray-400">
                                                    {{ $testimonial->client_position ?? '' }}
                                                    @if($testimonial->client_position && $testimonial->client_company) - @endif
                                                    {{ $testimonial->client_company ?? '' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Badge destacado --}}
                                @if($testimonial->is_featured)
                                    <div class="absolute top-4 right-4 bg-yellow-400 text-black px-2 py-1 rounded-full text-xs font-bold">
                                        ⭐
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Navegación --}}
                <div class="swiper-button-next !text-yellow-400"></div>
                <div class="swiper-button-prev !text-yellow-400"></div>

                {{-- Paginación --}}
                <div class="swiper-pagination !bottom-0"></div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-black/30 backdrop-blur-sm rounded-2xl p-12 max-w-md mx-auto">
                    <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay testimonios activos</h3>
                    <p class="text-gray-700">Asegúrate de que los testimonios estén marcados como "Activos" en el panel de administración</p>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- Swiper CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.testimonialsSwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        speed: 800,
        effect: 'slide',
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
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });
});
</script>

<style>
/* Títulos con sombra naranja */
.testimonial-title {
    text-shadow:
        3px 3px 6px rgba(255, 140, 0, 0.8),
        -1px -1px 3px rgba(255, 140, 0, 0.4);
}

.testimonial-subtitle {
    text-shadow:
        2px 2px 4px rgba(255, 140, 0, 0.6),
        -1px -1px 2px rgba(255, 140, 0, 0.3);
}

/* Line clamp para testimonio */
.line-clamp-6 {
    display: -webkit-box;
    -webkit-line-clamp: 6;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Ajustes de Swiper */
.testimonialsSwiper {
    padding: 20px 50px 50px;
}

.swiper-button-next,
.swiper-button-prev {
    background: rgba(0, 0, 0, 0.5);
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px;
}

.swiper-pagination-bullet {
    background: rgb(245, 245, 0);
    opacity: 0.5;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    background: rgb(245, 245, 0);
}
</style>
