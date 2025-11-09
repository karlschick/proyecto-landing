{{-- Services Section --}}
<section id="servicios" class="py-16 bg-gray-600 px-6 text-center scroll-mt-20 relative">
    <h2 class="text-3xl md:text-4xl font-bold mb-12 text-gray-900">Nuestros Servicios</h2>
    <p class="text-gray-900 max-w-2xl mx-auto mb-12">Ofrecemos soluciones completas para tu negocio</p>

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

                            {{-- FRONT --}}
                            <div class="card-front bg-gray-500">
                                @php
                                    $defaultImages = [
                                        1 => asset('images/settings/default-service-1.png'),
                                        2 => asset('images/settings/default-service-2.png'),
                                        3 => asset('images/settings/default-service-3.png'),
                                        4 => asset('images/settings/default-service-4.png'),
                                    ];
                                    $fallbackImage = $defaultImages[$loop->iteration] ?? asset('images/settings/default-service-1.png');
                                @endphp

                                <img src="{{ $service->image ? $service->getImageUrl() : $fallbackImage }}"
                                     alt="{{ $service->title }}"
                                     class="w-24 h-24 object-cover rounded-md mb-4 mx-auto shadow-lg">

                                <h3 class="text-xl font-bold text-white mb-3">{{ $service->title }}</h3>
                                <p class="text-gray-200 text-sm">
                                    {{ $service->short_description ?? Str::limit($service->description, 80) }}
                                </p>
                            </div>

                            {{-- BACK --}}
                            <div class="card-back bg-gray-900">
                                <h3 class="text-xl font-bold text-white mb-3">{{ $service->title }}</h3>
                                <p class="text-gray-200 text-sm mb-4 leading-relaxed">
                                    {{ Str::limit($service->description, 140) }}
                                </p>

                                @if(strlen($service->description) > 100)
                                    <button onclick="showServiceDetail('{{ addslashes($service->title) }}', '{{ addslashes($service->description) }}')"
                                            class="service-cta">Ver más</button>
                                @endif
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

{{-- Modal --}}
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
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeServiceModal(); });
</script>

<style>
.perspective { perspective: 1500px; }

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
    border-radius: 1rem;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
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
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 1.5rem;
    border-radius: 1rem;
}

.card-back {
    transform: rotateY(180deg);
}

.service-cta {
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    background: linear-gradient(180deg, #0b1220, #1f2937);
    color: #fff;
    font-weight: 600;
    font-size: 0.9rem;
    transition: 0.15s ease;
}
.service-cta:hover {
    transform: translateY(-3px);
}
</style>
