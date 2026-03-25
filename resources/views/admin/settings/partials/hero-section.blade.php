<div class="border rounded-lg p-4" x-data="{
    heroBackgroundType: '{{ old('hero_background_type', $settings->hero_background_type ?? 'color') }}',
    overlayOpacity: {{ old('hero_overlay_opacity', $settings->hero_overlay_opacity ?? 0.5) }},
    selectedImage: '{{ old('hero_background_image_selected', $settings->hero_background_image ?? '') }}'
}">
    <div class="flex items-center gap-2 mb-4">
        <input type="checkbox" name="hero_enabled" id="hero_enabled" value="1"
               {{ $settings->hero_enabled ? 'checked' : '' }}
               class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
        <label for="hero_enabled" class="text-base font-semibold text-gray-800">Hero Section</label>
    </div>

    <div class="space-y-4 pl-7">
        <!-- Tipo de fondo -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <label class="block text-sm font-semibold text-gray-800 mb-3">Tipo de Fondo del Hero</label>
            <div class="grid grid-cols-3 gap-3">
                <label class="flex items-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition"
                       :class="heroBackgroundType === 'color' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300'">
                    <input type="radio" name="hero_background_type" value="color"
                           x-model="heroBackgroundType"
                           class="w-4 h-4 text-blue-600">
                    <div>
                        <div class="font-medium text-sm">Color Sólido</div>
                        <div class="text-xs text-gray-500">Gradiente</div>
                    </div>
                </label>

                <label class="flex items-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition"
                       :class="heroBackgroundType === 'image' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300'">
                    <input type="radio" name="hero_background_type" value="image"
                           x-model="heroBackgroundType"
                           class="w-4 h-4 text-blue-600">
                    <div>
                        <div class="font-medium text-sm">Imagen</div>
                        <div class="text-xs text-gray-500">Foto de fondo</div>
                    </div>
                </label>

                <label class="flex items-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition"
                       :class="heroBackgroundType === 'video' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300'">
                    <input type="radio" name="hero_background_type" value="video"
                           x-model="heroBackgroundType"
                           class="w-4 h-4 text-blue-600">
                    <div>
                        <div class="font-medium text-sm">Video</div>
                        <div class="text-xs text-gray-500">Video de fondo</div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Configuración de Imagen -->
        <div x-show="heroBackgroundType === 'image'" class="bg-gray-50 p-4 rounded-lg border border-gray-200" x-transition>
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen de Fondo</label>

            @if($settings->hero_background_image)
                <div class="mb-3">
                    <img src="{{ $settings->getHeroBackgroundImageUrl() }}" alt="Hero Background" class="h-32 object-cover rounded-lg shadow">
                    <p class="text-xs text-gray-600 mt-1">Imagen actual: {{ $settings->hero_background_image }}</p>
                </div>
            @endif

            <!-- Galería de imágenes existentes -->
            @php
                $heroImagesPath = public_html_path('images/hero');
                $heroImages = [];
                if (is_dir($heroImagesPath)) {
                    $files = glob($heroImagesPath . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
                    foreach ($files as $file) {
                        $heroImages[] = 'hero/' . basename($file);
                    }
                }
            @endphp

            @if(count($heroImages) > 0)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        📁 Imágenes guardadas ({{ count($heroImages) }}) — haz clic para seleccionar
                    </label>
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-2 max-h-64 overflow-y-auto p-2 border border-gray-200 rounded-lg bg-white">
                        @foreach($heroImages as $img)
                            <div class="relative cursor-pointer group"
                                 @click="selectedImage = '{{ $img }}'">
                                <img src="{{ asset('images/' . $img) }}"
                                     alt="{{ basename($img) }}"
                                     class="w-full h-20 object-cover rounded-lg border-2 transition"
                                     :class="selectedImage === '{{ $img }}' ? 'border-blue-500 ring-2 ring-blue-300' : 'border-gray-200 group-hover:border-blue-300'">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition"></div>
                                @if($settings->hero_background_image === $img)
                                    <span class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-1 rounded">Actual</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <!-- Input hidden para enviar la imagen seleccionada -->
                    <input type="hidden" name="hero_background_image_selected" :value="selectedImage">
                    <p class="text-xs text-gray-500 mt-1" x-show="selectedImage">
                        ✅ Seleccionada: <span x-text="selectedImage" class="font-medium text-blue-600"></span>
                    </p>
                </div>
            @endif

            <label class="block text-sm font-medium text-gray-700 mb-1">O subir nueva imagen</label>
            <input type="file" name="hero_background_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, WEBP. Máx: 5MB. Recomendado: 1920x1080px</p>
        </div>

        <!-- Configuración de Video -->
        <div x-show="heroBackgroundType === 'video'" class="bg-gray-50 p-4 rounded-lg border border-gray-200" x-transition>
            <label class="block text-sm font-medium text-gray-700 mb-2">Video de Fondo</label>
            @if($settings->hero_background_video)
                <div class="mb-3">
                    <video class="h-32 object-cover rounded-lg shadow" controls>
                        <source src="{{ $settings->getHeroBackgroundVideoUrl() }}" type="video/mp4">
                    </video>
                    <p class="text-xs text-gray-600 mt-1">Video actual: {{ $settings->hero_background_video }}</p>
                </div>
            @endif
            <input type="file" name="hero_background_video" accept="video/mp4,video/webm,video/ogg"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Formatos: MP4, WEBM, OGG. Máx: 50MB.</p>
        </div>

        <!-- Opacidad del Overlay -->
        <div x-show="heroBackgroundType === 'image' || heroBackgroundType === 'video'" class="bg-gray-50 p-4 rounded-lg border border-gray-200" x-transition>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Opacidad del Overlay Oscuro:
                <span x-text="Math.round(overlayOpacity * 100) + '%'" class="font-bold text-blue-600"></span>
            </label>
            <input type="range" name="hero_overlay_opacity" x-model="overlayOpacity"
                   min="0" max="1" step="0.05"
                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span>Transparente (0%)</span>
                <span>Oscuro (100%)</span>
            </div>
        </div>

        <!-- Campos de texto del Hero -->
        <div class="border-t pt-4 mt-4">
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Título Principal</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                <textarea name="hero_subtitle" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
            </div>
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Texto del Botón</label>
                    <input type="text" name="hero_button_text" value="{{ old('hero_button_text', $settings->hero_button_text) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL del Botón</label>
                    <input type="text" name="hero_button_url" value="{{ old('hero_button_url', $settings->hero_button_url) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>
    </div>
</div>
