@if(($settings->shop_enabled ?? true) && isset($products) && $products->count())
<section id="shop" class="py-16 bg-black relative overflow-hidden">
    {{-- Fondo interactivo animado --}}
    <div class="absolute inset-0 overflow-hidden">
        {{-- Gradiente base --}}
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 via-black to-blue-900/20"></div>

        {{-- Círculos animados --}}
        <div class="absolute top-20 left-10 w-72 h-72 bg-yellow-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl animate-pulse-delayed"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl animate-pulse-delayed-2"></div>

        {{-- Grid pattern --}}
        <div class="absolute inset-0 grid-pattern"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        {{-- Header centrado con iconos --}}
        <div class="text-center mb-12">
            <div class="flex justify-center gap-4 mb-4">
                <svg class="w-8 h-8 text-yellow-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <svg class="w-8 h-8 text-yellow-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="w-8 h-8 text-yellow-400 animate-bounce-delayed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Nuestros Productos</h2>
            <p class="text-gray-400 max-w-2xl mx-auto"></p>
        </div>

        {{-- Grid centrado con lógica adaptativa --}}
        @php
            $productCount = $products->count();
            $gridClasses = match(true) {
                $productCount == 1 => 'flex justify-center',
                $productCount == 2 => 'flex justify-center gap-8 flex-wrap',
                default => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center'
            };
        @endphp

        <div class="max-w-6xl mx-auto">
            <div class="{{ $gridClasses }}">
                @foreach($products as $product)
                    @php
                        $defaultImage = asset('images/settings/default-product.png');
                        $imageUrl = $product->featured_image
                            ? $product->getFeaturedImageUrl()
                            : $defaultImage;
                    @endphp

                    <div class="w-full max-w-sm product-card" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        {{-- Altura fija para todas las tarjetas --}}
                        <div class="h-[480px] bg-gradient-to-br from-[rgb(245,245,0)] to-yellow-500 rounded-2xl shadow-2xl hover:shadow-yellow-500/50 transition-all duration-500 overflow-hidden transform hover:-translate-y-2 group flex flex-col">
                            {{-- Imagen con altura fija y fondo amarillo --}}
                            <div class="relative h-56 flex-shrink-0 bg-gradient-to-br from-yellow-300 to-yellow-400 flex items-center justify-center overflow-hidden p-4">
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-700"
                                    onerror="this.src='{{ $defaultImage }}'">

                                @if($product->is_featured ?? false)
                                    <div class="absolute top-4 right-4 bg-black from-[rgb(245,245,0)] px-3 py-1 rounded-full text-xs font-bold z-20">
                                        DESTACADO
                                    </div>
                                @endif
                            </div>

                            {{-- Contenido con altura flexible pero controlada --}}
                            <div class="flex-1 p-6 text-center flex flex-col justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-gray-700 text-sm mb-4 h-[48px] line-clamp-2 overflow-hidden">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                </div>

                                <div class="flex flex-col items-center gap-3 mt-auto">
                                    <span class="text-2xl font-bold text-gray-900">
                                        ${{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('shop.show', $product->slug) }}"
                                       class="w-full bg-black text-yellow-400 px-6 py-3 rounded-xl font-bold hover:bg-gray-900 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Ver más
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
/* Grid pattern */
.grid-pattern {
    background-image:
        linear-gradient(rgba(245,245,0,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(245,245,0,0.03) 1px, transparent 1px);
    background-size: 50px 50px;
}

/* Animaciones de pulso con delays */
@keyframes pulse-delayed {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}

.animate-pulse-delayed {
    animation: pulse-delayed 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    animation-delay: 1s;
}

.animate-pulse-delayed-2 {
    animation: pulse-delayed 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    animation-delay: 2s;
}

/* Animación de bounce con delay */
.animate-bounce-delayed {
    animation: bounce 1s infinite;
    animation-delay: 0.2s;
}

/* Fade in up para cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-card {
    animation: fadeInUp 0.6s ease-out both;
}

/* Line clamp para textos */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endif
