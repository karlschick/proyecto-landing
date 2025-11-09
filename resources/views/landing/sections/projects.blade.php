<section id="proyectos" class="py-16 bg-gray-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 animate-from-top">
                Nuestros Proyectos
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto animate-from-bottom">
                Conoce algunos de los proyectos que hemos desarrollado
            </p>
        </div>

        {{-- Grid de proyectos estáticos --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            @php
                $defaultImage = asset('images/settings/default-projet.jpg'); // imagen por defecto
                $projects = [
                    [
                        'title' => 'Portal Corporativo ABC',
                        'category' => 'Web',
                        'client' => 'ABC Corporation',
                        'description' => 'Desarrollo de portal web corporativo con panel de administración y optimización SEO.',
                        'image' => 'images/settings/default-project-1.png',
                    ],
                    [
                        'title' => 'App de Delivery FoodNow',
                        'category' => 'App',
                        'client' => 'FoodNow Inc.',
                        'description' => 'Aplicación móvil completa para pedidos de comida a domicilio, iOS y Android.',
                        'image' => 'images/settings/default-project-2.png',
                    ],
                    [
                        'title' => 'Tienda Online Fashion Store',
                        'category' => 'E-commerce',
                        'client' => 'Fashion Store',
                        'description' => 'Desarrollo de tienda online con carrito, pasarela de pago y gestión de productos.',
                        'image' => 'images/settings/default-project-3.png',
                    ],
                    [
                        'title' => 'Rediseño UX Banking App',
                        'category' => 'UX/UI',
                        'client' => 'Banco Digital',
                        'description' => 'Rediseño completo de la interfaz de aplicación bancaria para mejorar la experiencia de usuario.',
                        'image' => 'images/settings/default-project-4.png',
                    ],
                ];
            @endphp

            @foreach($projects as $project)
                @php
                    // siempre usar la imagen por defecto
                    $imageUrl = $project['image'] ? asset($project['image']) : $defaultImage;
                @endphp

                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-from-top">
                    <div class="relative h-56 bg-gray-200 overflow-hidden group">
                        <img src="{{ $imageUrl }}" alt="{{ $project['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <span class="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            {{ $project['category'] }}
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 hover:text-primary transition">
                            {{ $project['title'] }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-3">
                            Cliente: <span class="font-semibold text-gray-700">{{ $project['client'] }}</span>
                        </p>
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            {{ $project['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
