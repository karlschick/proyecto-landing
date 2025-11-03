<section id="testimonios" class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 animate-from-top">
                Lo Que Dicen Nuestros Clientes
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto animate-from-bottom">
                La satisfacción de nuestros clientes es nuestra mejor carta de presentación
            </p>
        </div>

        @php
            $testimonials = \App\Services\CacheService::testimonials();
        @endphp

        @if($testimonials->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $index => $testimonial)
                @php
                    $animations = ['animate-from-left', 'animate-from-bottom', 'animate-from-right'];
                    $animation = $animations[$index % count($animations)];
                    $delay = floor($index / 3) * 0.2;
                @endphp

                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 relative {{ $animation }}"
                     style="animation-delay: {{ $delay }}s; opacity: 0;">

                    {{-- Comillas decorativas --}}
                    <div class="absolute top-6 right-6 text-6xl text-primary opacity-10 font-serif">"</div>

                    {{-- Header con foto y rating --}}
                    <div class="flex items-start gap-4 mb-6 relative z-10">
                        @if($testimonial->client_photo)
                            <img src="{{ $testimonial->getPhotoUrl() }}"
                                 alt="{{ $testimonial->client_name }}"
                                 class="w-16 h-16 rounded-full object-cover shadow-md ring-4 ring-white">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xl shadow-md ring-4 ring-white">
                                {{ $testimonial->getInitials() }}
                            </div>
                        @endif

                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-lg">{{ $testimonial->client_name }}</h4>
                            @if($testimonial->client_position || $testimonial->client_company)
                            <p class="text-sm text-gray-600">
                                @if($testimonial->client_position)
                                    {{ $testimonial->client_position }}
                                @endif
                                @if($testimonial->client_position && $testimonial->client_company)
                                    -
                                @endif
                                @if($testimonial->client_company)
                                    {{ $testimonial->client_company }}
                                @endif
                            </p>
                            @endif

                            {{-- Rating stars --}}
                            <div class="flex items-center gap-1 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- Testimonio --}}
                    <p class="text-gray-600 leading-relaxed italic relative z-10">
                        "{{ $testimonial->testimonial }}"
                    </p>
                </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">💬</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">
                No hay testimonios disponibles
            </h3>
            <p class="text-gray-500">
                Los testimonios de nuestros clientes se mostrarán aquí.
            </p>
        </div>
        @endif
    </div>
</section>
