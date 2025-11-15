<section id="proyectos" class="py-16 bg-[rgb(245,245,0)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 animate-from-top">
                NUESTRA SEDE
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto animate-from-bottom">
                Conoce nuestra sede, donde poderte enfocarte
            </p>
        </div>

        @php
            use App\Models\Project;
            $projects = Project::active()->ordered()->get();
        @endphp

        @if($projects->count() > 0)
        {{-- contenedor centrado con flex para cuando hay pocas cards --}}
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($projects as $project)
                <div class="relative bg-black rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-from-top w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.125rem)] max-w-xs group-card">
                    {{-- Borde animado naranja --}}
                    <div class="absolute inset-0 rounded-xl opacity-0 group-card-hover:opacity-100 transition-opacity duration-300 pointer-events-none" style="padding: 3px; background: linear-gradient(45deg, #ff6b00, #ff8c00, #ffa500, #ff8c00, #ff6b00); background-size: 400% 400%; animation: gradientShift 3s ease infinite;">
                        <div class="w-full h-full bg-black rounded-xl"></div>
                    </div>

                    <div class="relative z-10">
                        <div class="relative h-56 bg-white overflow-hidden group cursor-pointer" onclick="openImageModal('{{ $project->getImageUrl() }}', '{{ $project->title }}')">
                            <img src="{{ $project->getImageUrl() }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            {{-- Ícono de expandir --}}
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-200 mb-2 hover:text-primary transition">
                                {{ $project->title }}
                            </h3>
                            @if($project->description)
                            <p class="text-gray-200 text-sm leading-relaxed line-clamp-3">
                                {{ $project->description }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Modal para ver imagen en grande --}}
        <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4" onclick="closeImageModal()">
            <div class="relative max-w-7xl max-h-full">
                {{-- Botón cerrar --}}
                <button class="absolute -top-12 right-0 text-white hover:text-gray-300 transition" onclick="closeImageModal()">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                {{-- Imagen --}}
                <img id="modalImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" onclick="event.stopPropagation()">
                {{-- Título --}}
                <p id="modalTitle" class="text-white text-center mt-4 text-xl font-semibold"></p>
            </div>
        </div>

        <style>
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .group-card:hover .group-card-hover\:opacity-100 {
                opacity: 1;
            }
        </style>

        <script>
            function openImageModal(imageUrl, title) {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                const modalTitle = document.getElementById('modalTitle');

                modalImage.src = imageUrl;
                modalImage.alt = title;
                modalTitle.textContent = title;

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevenir scroll
            }

            function closeImageModal() {
                const modal = document.getElementById('imageModal');
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Restaurar scroll
            }

            // Cerrar con tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });
        </script>
        @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No hay proyectos activos</h3>
            <p class="text-gray-500">Agrega algunos proyectos desde el panel de administración.</p>
        </div>
        @endif
    </div>
</section>
