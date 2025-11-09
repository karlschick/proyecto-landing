<!-- Testimonios -->
<section style="padding:40px 20px; background:#eff4fa;">
    <div style="max-width:900px;margin:0 auto;text-align:center;">
        <h2 style="font-size:24px;margin-bottom:18px;">Lo que dicen nuestros clientes</h2>

        @php
            $testimonials = \App\Services\CacheService::testimonials();
            $defaultImages = [
                1 => asset('images/settings/default-testimonial-1.jpg'),
                2 => asset('images/settings/default-testimonial-2.jpg'),
                3 => asset('images/settings/default-testimonial-3.jpg'),
                4 => asset('images/settings/default-testimonial-4.jpg'),
                5 => asset('images/settings/default-testimonial-5.jpg'),
            ];
        @endphp

        @if($testimonials->count() > 0)
        <!-- Slider -->
        <div class="swiper mySwiper" style="padding:20px;">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    @php
                        $fallbackImage = $defaultImages[$loop->iteration] ?? asset('images/settings/default-testimonial-1.jpg');

                        // Solo usa getPhotoUrl() si client_photo NO contiene "default-testimonial"
                        if (!empty($testimonial->client_photo) && !str_contains($testimonial->client_photo, 'default-testimonial')) {
                            $photoUrl = $testimonial->getPhotoUrl();
                        } else {
                            $photoUrl = $fallbackImage;
                        }
                    @endphp

                    <!-- Testimonio {{ $loop->iteration }} -->
                    <div class="swiper-slide" style="display:flex;justify-content:center;">
                        <div style="background:white;padding:18px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06);width:320px;text-align:center;">
                            <img src="{{ $photoUrl }}" alt="{{ $testimonial->client_name }}" style="width:70px;height:70px;border-radius:50%;margin-bottom:12px;object-fit:cover;">
                            <p style="font-style:italic;color:#374151;">"{{ $testimonial->testimonial }}"</p>
                            <div style="margin-top:14px;font-weight:700;">
                                {{ $testimonial->client_name }}
                                @if($testimonial->client_position || $testimonial->client_company)
                                    <br>
                                    <span style="font-weight:400; color:#6b7280; font-size:0.9rem;">
                                        {{ $testimonial->client_position ?? '' }}
                                        @if($testimonial->client_position && $testimonial->client_company) - @endif
                                        {{ $testimonial->client_company ?? '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Botones navegación -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Paginación -->
            <div class="swiper-pagination"></div>
        </div>
        @else
        <p>No hay testimonios disponibles.</p>
        @endif
    </div>
</section>

<!-- SwiperJS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                768: { slidesPerView: 2 }
            }
        });
    });
</script>
