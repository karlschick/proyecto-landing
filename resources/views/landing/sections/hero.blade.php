{{-- Hero Section --}}
<section class="relative text-white py-20 md:py-32 overflow-hidden">
    <!-- Background dinámico -->
    @if($settings->hero_background_type === 'video' && $settings->hero_background_video)
        <!-- Video de fondo -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ $settings->getHeroBackgroundVideoUrl() }}" type="video/mp4">
        </video>
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black" style="opacity: {{ $settings->hero_overlay_opacity ?? 0.5 }}"></div>

    @elseif($settings->hero_background_type === 'image' && $settings->hero_background_image)
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ $settings->getHeroBackgroundImageUrl() }}')"></div>
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black" style="opacity: {{ $settings->hero_overlay_opacity ?? 0.5 }}"></div>

    @else
        <!-- Gradiente de colores (por defecto) -->
        <div class="absolute inset-0 hero-gradient"></div>
    @endif

    <!-- Contenido -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                {{ $settings->hero_title ?? 'Bienvenido a ' . ($settings->site_name ?? 'Nuestro Sitio') }}
            </h1>

            @if($settings->site_slogan)
            <p class="text-lg md:text-xl text-white/80 mb-4 font-medium">
                {{ $settings->site_slogan }}
            </p>
            @endif

            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                {{ $settings->hero_subtitle ?? '' }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ $settings->hero_button_url ?? '#productos' }}"
                   class="inline-block btn-primary px-8 py-3 rounded-lg font-semibold transition shadow-lg">
                    {{ $settings->hero_button_text ?? 'Ver Productos' }}
                </a>
                <a href="#contacto"
                   class="inline-block bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition">
                    Contactar
                </a>
            </div>
        </div>
    </div>
</section>
