{{-- Services Section --}}
<section id="servicios" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 animate-from-top">
                Nuestros Servicios
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto animate-from-bottom">
                Ofrecemos soluciones completas para tu negocio
            </p>
        </div>

        @php
            $services = \App\Services\CacheService::services();
            $serviceCount = $services->count();

            // Determinar clases del grid según cantidad
            $gridClasses = match(true) {
                $serviceCount == 1 => 'flex justify-center',
                $serviceCount == 2 => 'grid md:grid-cols-2 gap-8 max-w-4xl mx-auto',
                $serviceCount == 3 => 'grid md:grid-cols-3 gap-8',
                $serviceCount == 4 => 'grid md:grid-cols-2 lg:grid-cols-4 gap-8',
                $serviceCount == 5 => 'grid md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center',
                default => 'grid md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center'
            };

            // Animaciones alternadas
            $animations = ['animate-from-left', 'animate-from-top', 'animate-from-right', 'animate-from-bottom'];
        @endphp

        @if($services->count() > 0)
            <div class="{{ $gridClasses }}">
                @foreach($services as $index => $service)
                    @php
                        // Asignar animación según índice
                        $animation = $animations[$index % count($animations)];

                        // Agregar delay escalonado
                        $delay = floor($index / 3) * 0.2;
                        $animationStyle = "animation-delay: {$delay}s;";

                        // Ancho máximo para mantener consistencia
                        $maxWidth = 'max-w-sm w-full';
                    @endphp

                    <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-xl transition text-center card-hover border-2 border-transparent relative {{ $animation }} {{ $serviceCount == 1 ? 'max-w-md' : $maxWidth }}"
                         style="{{ $animationStyle }} opacity: 0;">

                        @if($loop->first && $serviceCount > 1)
                            <span class="absolute top-4 right-4 bg-accent text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">Popular</span>
                        @endif

                        {{-- Icono o Imagen --}}
                        @if($service->icon)
                            <div class="text-6xl mb-4 transform hover:scale-110 transition duration-300">{{ $service->icon }}</div>
                        @elseif($service->image)
                            <div class="mb-4">
                                <img src="{{ $service->getImageUrl() }}"
                                     alt="{{ $service->title }}"
                                     class="w-24 h-24 mx-auto object-cover rounded-lg shadow-md transform hover:scale-110 transition duration-300">
                            </div>
                        @else
                            <div class="text-6xl mb-4 transform hover:scale-110 transition duration-300">📋</div>
                        @endif

                        {{-- Título --}}
                        <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ $service->title }}</h3>

                        {{-- Descripción --}}
                        <p class="text-gray-600 leading-relaxed">
                            {{ $service->short_description ?? Str::limit($service->description, 100) }}
                        </p>

                        {{-- Botón opcional para más info --}}
                        @if(strlen($service->description) > 100 && !$service->short_description)
                            <button onclick="showServiceDetail('{{ addslashes($service->title) }}', '{{ addslashes($service->description) }}')"
                                    class="mt-4 text-primary hover:text-secondary transition text-sm font-medium inline-flex items-center gap-1">
                                Ver más
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            {{-- Mensaje cuando no hay servicios --}}
            <div class="text-center py-12 animate-from-bottom">
                <div class="text-6xl mb-4">🔧</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">
                    No hay servicios disponibles
                </h3>
                <p class="text-gray-500">
                    Los servicios se mostrarán aquí una vez que sean agregados desde el panel de administración.
                </p>
            </div>
        @endif
    </div>
</section>

{{-- Modal para detalles del servicio --}}
<div id="serviceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeServiceModal()">
    <div class="bg-white rounded-lg max-w-2xl w-full p-6 animate-from-top" onclick="event.stopPropagation()">
        <div class="flex justify-between items-start mb-4">
            <h3 id="serviceModalTitle" class="text-2xl font-bold text-gray-800"></h3>
            <button onclick="closeServiceModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div id="serviceModalContent" class="text-gray-600 leading-relaxed whitespace-pre-line"></div>
        <div class="mt-6 flex justify-end">
            <button onclick="closeServiceModal()" class="btn-primary px-6 py-2 rounded-lg font-semibold transition">
                Cerrar
            </button>
        </div>
    </div>
</div>

<script>
function showServiceDetail(title, description) {
    document.getElementById('serviceModalTitle').textContent = title;
    document.getElementById('serviceModalContent').textContent = description;
    document.getElementById('serviceModal').classList.remove('hidden');
    document.getElementById('serviceModal').classList.add('flex');
}

function closeServiceModal() {
    document.getElementById('serviceModal').classList.add('hidden');
    document.getElementById('serviceModal').classList.remove('flex');
}

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeServiceModal();
    }
});
</script>

<style>
/* Animaciones para servicios */
.animate-from-left {
  animation: fromLeft 1s ease forwards;
}
.animate-from-right {
  animation: fromRight 1s ease forwards;
}
.animate-from-top {
  animation: fromTop 1s ease forwards;
}
.animate-from-bottom {
  animation: fromBottom 1s ease forwards;
}

@keyframes fromLeft {
    0% { opacity: 0; transform: translateX(-100px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes fromRight {
    0% { opacity: 0; transform: translateX(100px); }
    100% { opacity: 1; transform: translateX(0); }
}
@keyframes fromTop {
    0% { opacity: 0; transform: translateY(-100px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes fromBottom {
    0% { opacity: 0; transform: translateY(100px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Scroll reveal para animaciones cuando sea visible */
@media (prefers-reduced-motion: no-preference) {
    .animate-from-left,
    .animate-from-right,
    .animate-from-top,
    .animate-from-bottom {
        animation-fill-mode: forwards;
    }
}
</style>
