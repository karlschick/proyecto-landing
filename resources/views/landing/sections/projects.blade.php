<section id="proyectos" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 animate-from-top">
                Nuestros Proyectos
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto animate-from-bottom">
                Conoce algunos de los proyectos que hemos desarrollado
            </p>
        </div>

        @php
            $projects = \App\Services\CacheService::projects();
            $categories = \App\Models\ProjectCategory::active()->ordered()->get();
        @endphp

        {{-- Filtros por categoría --}}
        @if($categories->count() > 1)
        <div class="flex flex-wrap justify-center gap-3 mb-10" x-data="{ activeCategory: 'all' }">
            <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                    class="px-6 py-2 rounded-full font-medium transition">
                Todos
            </button>
            @foreach($categories as $category)
            <button @click="activeCategory = '{{ $category->slug }}'"
                    :class="activeCategory === '{{ $category->slug }}' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                    class="px-6 py-2 rounded-full font-medium transition">
                {{ $category->name }}
            </button>
            @endforeach
        </div>
        @endif

        @if($projects->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $index => $project)
                @php
                    $animations = ['animate-from-left', 'animate-from-top', 'animate-from-right'];
                    $animation = $animations[$index % count($animations)];
                    $delay = floor($index / 3) * 0.2;
                @endphp

                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 {{ $animation }}"
                     style="animation-delay: {{ $delay }}s; opacity: 0;"
                     x-data="{ category: '{{ $project->category->slug ?? 'sin-categoria' }}' }"
                     x-show="activeCategory === 'all' || activeCategory === category">

                    {{-- Imagen del proyecto --}}
                    <div class="relative h-56 bg-gray-200 overflow-hidden group">
                        @if($project->featured_image)
                            <img src="{{ $project->getImageUrl() }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Overlay con botón --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                            <button onclick="showProjectDetail({{ json_encode([
                                'title' => $project->title,
                                'description' => $project->description,
                                'client' => $project->client,
                                'date' => $project->project_date?->format('Y'),
                                'url' => $project->url,
                                'image' => $project->getImageUrl()
                            ]) }})"
                                    class="bg-white text-primary px-6 py-2 rounded-full font-semibold hover:bg-primary hover:text-white transition">
                                Ver Detalles
                            </button>
                        </div>

                        {{-- Badge de categoría --}}
                        @if($project->category)
                        <span class="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            {{ $project->category->name }}
                        </span>
                        @endif
                    </div>

                    {{-- Contenido --}}
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 hover:text-primary transition">
                            {{ $project->title }}
                        </h3>

                        @if($project->client)
                        <p class="text-sm text-gray-500 mb-3">
                            Cliente: <span class="font-semibold text-gray-700">{{ $project->client }}</span>
                        </p>
                        @endif

                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            {{ $project->short_description ?? Str::limit($project->description, 120) }}
                        </p>

                        @if($project->url)
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ $project->url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-primary hover:text-secondary transition text-sm font-medium inline-flex items-center gap-1">
                                Ver proyecto
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📁</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">
                No hay proyectos disponibles
            </h3>
            <p class="text-gray-500">
                Los proyectos se mostrarán aquí una vez que sean agregados.
            </p>
        </div>
        @endif
    </div>
</section>

{{-- Modal para detalles del proyecto --}}
<div id="projectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeProjectModal()">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto animate-from-top" onclick="event.stopPropagation()">
        <div class="sticky top-0 bg-white border-b p-6 flex justify-between items-start z-10">
            <h3 id="projectModalTitle" class="text-2xl font-bold text-gray-800 pr-8"></h3>
            <button onclick="closeProjectModal()" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <img id="projectModalImage" src="" alt="" class="w-full h-64 object-cover rounded-lg shadow-lg mb-6">

            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div id="projectModalClient" class="hidden">
                    <span class="text-sm text-gray-500">Cliente:</span>
                    <p class="font-semibold text-gray-800"></p>
                </div>
                <div id="projectModalDate" class="hidden">
                    <span class="text-sm text-gray-500">Año:</span>
                    <p class="font-semibold text-gray-800"></p>
                </div>
            </div>

            <div class="prose max-w-none">
                <p id="projectModalContent" class="text-gray-600 leading-relaxed whitespace-pre-line"></p>
            </div>

            <div id="projectModalUrl" class="mt-6 pt-6 border-t hidden">
                <a href="" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Visitar Proyecto
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showProjectDetail(project) {
    document.getElementById('projectModalTitle').textContent = project.title;
    document.getElementById('projectModalImage').src = project.image;
    document.getElementById('projectModalImage').alt = project.title;
    document.getElementById('projectModalContent').textContent = project.description;

    // Cliente
    const clientDiv = document.getElementById('projectModalClient');
    if (project.client) {
        clientDiv.querySelector('p').textContent = project.client;
        clientDiv.classList.remove('hidden');
    } else {
        clientDiv.classList.add('hidden');
    }

    // Fecha
    const dateDiv = document.getElementById('projectModalDate');
    if (project.date) {
        dateDiv.querySelector('p').textContent = project.date;
        dateDiv.classList.remove('hidden');
    } else {
        dateDiv.classList.add('hidden');
    }

    // URL
    const urlDiv = document.getElementById('projectModalUrl');
    if (project.url) {
        urlDiv.querySelector('a').href = project.url;
        urlDiv.classList.remove('hidden');
    } else {
        urlDiv.classList.add('hidden');
    }

    document.getElementById('projectModal').classList.remove('hidden');
    document.getElementById('projectModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeProjectModal() {
    document.getElementById('projectModal').classList.add('hidden');
    document.getElementById('projectModal').classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeProjectModal();
    }
});
</script>
