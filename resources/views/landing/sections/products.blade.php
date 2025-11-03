{{-- Products Section --}}
<section id="productos" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Productos Destacados
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Descubre nuestra selección de productos premium
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-xl transition card-hover relative">
                @if($i == 1)
                    <span class="absolute top-3 right-3 bg-accent text-white text-xs font-bold px-3 py-1 rounded-full z-10 shadow-lg">¡Oferta!</span>
                @endif
                @if($i == 2)
                    <span class="absolute top-3 right-3 bg-accent text-white text-xs font-bold px-3 py-1 rounded-full z-10 shadow-lg">Nuevo</span>
                @endif

                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400 text-sm">Imagen del Producto</span>
                </div>

                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Producto {{ $i }}</h3>
                    <p class="text-gray-600 text-sm mb-3">Descripción breve del producto</p>

                    <div class="flex items-center justify-between">
                        @if($i == 1)
                            <div>
                                <span class="text-sm text-gray-400 line-through block">$129.99</span>
                                <span class="text-2xl font-bold text-accent">$99.99</span>
                            </div>
                        @else
                            <span class="text-2xl font-bold text-primary">$99.99</span>
                        @endif
                        <button class="btn-primary px-4 py-2 rounded-lg transition text-sm font-medium">
                            Añadir
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <div class="text-center mt-10">
            <a href="#" class="inline-block btn-primary px-8 py-3 rounded-lg font-semibold transition">
                Ver Todos los Productos
            </a>
        </div>
    </div>
</section>
