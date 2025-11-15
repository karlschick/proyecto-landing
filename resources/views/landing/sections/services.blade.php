{{-- Services Section --}}
<section id="servicios" class="py-16 bg-[rgb(245,245,0)] px-6 text-center scroll-mt-20 relative">
    <h2 class="text-3xl md:text-4xl font-bold mb-12 text-gray-900">NUESTROS SERVICIOS</h2>
    <p class="text-gray-900 max-w-2xl mx-auto mb-12">    </p>

    @php
        $services = \App\Services\CacheService::services();
        $serviceCount = $services->count();

        $gridClasses = match(true) {
            $serviceCount == 1 => 'flex justify-center',
            $serviceCount == 2 => 'grid md:grid-cols-2 gap-10 max-w-4xl mx-auto',
            $serviceCount == 3 => 'grid md:grid-cols-3 gap-10',
            $serviceCount == 4 => 'grid md:grid-cols-2 lg:grid-cols-4 gap-10',
            $serviceCount == 5 => 'grid md:grid-cols-2 lg:grid-cols-3 gap-10 justify-items-center',
            default => 'grid md:grid-cols-2 lg:grid-cols-3 gap-10 justify-items-center'
        };
    @endphp

    @if($serviceCount > 0)
        <div class="{{ $gridClasses }}">
            @foreach($services as $service)
                <div class="perspective">
                    <div class="service-card w-full h-80">
                        <div class="card-inner">

                            {{-- FRONT - Imagen completa con título --}}
                            <div class="card-front bg-black relative overflow-hidden">
                                @php
                                    $defaultImages = [
                                        1 => asset('images/settings/default-service-1.png'),
                                        2 => asset('images/settings/default-service-2.png'),
                                        3 => asset('images/settings/default-service-3.png'),
                                        4 => asset('images/settings/default-service-4.png'),
                                    ];
                                    $fallbackImage = $defaultImages[$loop->iteration] ?? asset('images/settings/default-service-1.png');
                                    $imageUrl = $service->image ? $service->getImageUrl() : $fallbackImage;
                                @endphp

                                {{-- Imagen de fondo --}}
                                <div class="absolute inset-0 z-0">
                                    <img src="{{ $imageUrl }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='{{ $fallbackImage }}'">
                                </div>

                                {{-- Overlay oscuro --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent z-10"></div>

                                {{-- Título centrado --}}
                                <div class="absolute inset-0 flex items-end justify-center p-6 z-20">
                                    <h3 class="text-2xl font-bold text-white text-center">
                                        {{ $service->title }}
                                    </h3>
                                </div>
                            </div>

                            {{-- BACK - Descripción corta --}}
                            <div class="card-back">
                                <div class="flex flex-col justify-center items-center h-full px-6">
                                    <h3 class="text-xl font-bold text-white mb-4 text-center">{{ $service->title }}</h3>
                                    <p class="text-gray-200 text-sm leading-relaxed text-center">
                                        {{ $service->short_description ?? Str::limit($service->description, 180) }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <img src="{{ asset('images/settings/default-service-1.png') }}" alt="Sin servicios"
                 class="w-24 h-24 object-cover rounded-md mb-4 mx-auto shadow-lg">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay servicios disponibles</h3>
            <p class="text-gray-500">Los servicios se mostrarán aquí cuando agregues algunos.</p>
        </div>
    @endif
</section>

<style>
.perspective {
    perspective: 1500px;
}

.service-card {
    width: 100%;
    height: 320px;
    position: relative;
    cursor: pointer;
}

.card-inner {
    width: 100%;
    height: 100%;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.8s cubic-bezier(0.2, 0.9, 0.3, 1);
}

.service-card:hover .card-inner {
    transform: rotateY(180deg);
}

/* Caras */
.card-front,
.card-back {
    position: absolute;
    inset: 0;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    border-radius: 1rem;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

.card-front {
    background: #000;
}

.card-back {
    transform: rotateY(180deg);
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
}
</style>
