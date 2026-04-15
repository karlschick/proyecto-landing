<div x-show="activeTab === 'navbar'" x-cloak
     x-data="{
         navBg:   '{{ $settings->navbar_bg_color ?? '#111827' }}',
         navText: '{{ $settings->navbar_text_color ?? '#ffffff' }}',
         unsaved: false,
         updatePreview() {
             this.navBg   = document.getElementById('navbar_bg_color').value;
             this.navText = document.getElementById('navbar_text_color').value;
             document.getElementById('navbar_bg_color_text').value   = this.navBg;
             document.getElementById('navbar_text_color_text').value = this.navText;
             this.unsaved = true;
         },
         syncColor(id, value) {
             if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                 document.getElementById(id).value = value;
                 this.updatePreview();
             }
         },
         applyPreset(bg, text) {
             document.getElementById('navbar_bg_color').value        = bg;
             document.getElementById('navbar_text_color').value      = text;
             document.getElementById('navbar_bg_color_text').value   = bg;
             document.getElementById('navbar_text_color_text').value = text;
             this.navBg   = bg;
             this.navText = text;
             this.unsaved = true;
         }
     }">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Configuración de la Barra de Navegación</h2>
        {{-- Badge de cambios sin guardar --}}
        <span x-show="unsaved"
              class="text-xs font-medium bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1 rounded-full">
            ● Cambios sin guardar
        </span>
    </div>

    {{-- ── Colores ── --}}
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Colores</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Color de fondo --}}
            <div>
                <label class="block font-medium text-gray-700 mb-1">Color de fondo</label>
                <div class="flex items-center gap-3">
                    <input type="color"
                           name="navbar_bg_color"
                           id="navbar_bg_color"
                           value="{{ $settings->navbar_bg_color ?? '#111827' }}"
                           class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer p-0.5"
                           @input="updatePreview()" @change="updatePreview()">
                    <input type="text"
                           id="navbar_bg_color_text"
                           value="{{ $settings->navbar_bg_color ?? '#111827' }}"
                           maxlength="7"
                           class="w-24 border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-300"
                           @input="syncColor('navbar_bg_color', $event.target.value)">
                </div>
            </div>

            {{-- Color del texto --}}
            <div>
                <label class="block font-medium text-gray-700 mb-1">Color del texto</label>
                <div class="flex items-center gap-3">
                    <input type="color"
                           name="navbar_text_color"
                           id="navbar_text_color"
                           value="{{ $settings->navbar_text_color ?? '#ffffff' }}"
                           class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer p-0.5"
                           @input="updatePreview()" @change="updatePreview()">
                    <input type="text"
                           id="navbar_text_color_text"
                           value="{{ $settings->navbar_text_color ?? '#ffffff' }}"
                           maxlength="7"
                           class="w-24 border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-300"
                           @input="syncColor('navbar_text_color', $event.target.value)">
                </div>
            </div>

            {{-- Preview en tiempo real --}}
            <div>
                <label class="block font-medium text-gray-700 mb-1">Preview</label>
                <div class="rounded-lg px-4 py-3 flex items-center justify-between transition-colors"
                     :style="`background-color: ${navBg};`">
                    <div class="flex items-center gap-2">
                        @if($settings->navbar_show_logo && $settings->getLogoUrl())
                            <img src="{{ $settings->getLogoUrl() }}" alt="Logo" class="h-7 rounded">
                        @endif
                        @if($settings->navbar_show_title)
                            <span class="font-semibold text-sm" :style="`color: ${navText};`">
                                {{ $settings->site_name }}
                            </span>
                        @endif
                    </div>
                    <div class="flex gap-4 text-xs" :style="`color: ${navText};`">
                        <span>Inicio</span>
                        <span>Servicios</span>
                        <span>Contacto</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Paleta de presets --}}
        <div class="mt-4">
            <p class="text-xs text-gray-500 mb-2">Combinaciones rápidas:</p>
            <div class="flex flex-wrap gap-2">
                @php
                $presets = [
                    ['label' => 'Oscuro / Blanco',    'bg' => '#111827', 'text' => '#ffffff'],
                    ['label' => 'Negro / Blanco',     'bg' => '#000000', 'text' => '#ffffff'],
                    ['label' => 'Blanco / Negro',     'bg' => '#ffffff', 'text' => '#111111'],
                    ['label' => 'Azul / Blanco',      'bg' => '#1e3a5f', 'text' => '#ffffff'],
                    ['label' => 'Azul vivo / Blanco', 'bg' => '#1d4ed8', 'text' => '#ffffff'],
                    ['label' => 'Gris / Blanco',      'bg' => '#1f2937', 'text' => '#f9fafb'],
                    ['label' => 'Verde / Blanco',     'bg' => '#064e3b', 'text' => '#ffffff'],
                    ['label' => 'Morado / Blanco',    'bg' => '#3b0764', 'text' => '#ffffff'],
                    ['label' => 'Rojo / Blanco',      'bg' => '#7f1d1d', 'text' => '#ffffff'],
                    ['label' => 'Blanco / Azul',      'bg' => '#ffffff', 'text' => '#1d4ed8'],
                ];
                @endphp
                @foreach($presets as $p)
                <button type="button"
                        @click="applyPreset('{{ $p['bg'] }}', '{{ $p['text'] }}')"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 hover:border-gray-400 text-xs text-gray-600 transition">
                    <span class="w-3 h-3 rounded-full border border-gray-300 inline-block" style="background: {{ $p['bg'] }};"></span>
                    <span class="w-3 h-3 rounded-full border border-gray-300 inline-block" style="background: {{ $p['text'] }};"></span>
                    {{ $p['label'] }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Visibilidad ── --}}
    <div class="mt-6 space-y-3">
        {{-- Mostrar logo --}}
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_logo" class="rounded" {{ $settings->navbar_show_logo ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar logo</span>
        </label>

        {{-- Mostrar título --}}
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_title" class="rounded" {{ $settings->navbar_show_title ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar título del sitio</span>
        </label>

        {{-- Mostrar eslogan --}}
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_slogan" class="rounded" {{ $settings->navbar_show_slogan ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar eslogan</span>
        </label>

        {{-- NUEVO: Mostrar enlace Tienda --}}
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_shop" class="rounded" {{ $settings->navbar_show_shop ?? true ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar enlace "Tienda" en el menú</span>
        </label>
    </div>

    {{-- ── Labels del menú ── --}}
    @php
        $labels = json_decode($settings->navbar_menu_labels ?? '{}', true);
    @endphp

    <div class="mt-8">
        <h3 class="font-semibold mb-2">Nombres de los enlaces del menú</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 text-sm mb-1">Inicio</label>
                <input type="text" name="navbar_menu_labels[inicio]" class="form-input w-full border rounded px-2 py-1" value="{{ $labels['inicio'] ?? 'Inicio' }}">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Tienda</label>
                <input type="text" name="navbar_menu_labels[tienda]" class="form-input w-full border rounded px-2 py-1" value="{{ $labels['tienda'] ?? 'Tienda' }}">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Nosotros</label>
                <input type="text" name="navbar_menu_labels[nosotros]" class="form-input w-full border rounded px-2 py-1" value="{{ $labels['nosotros'] ?? 'Nosotros' }}">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Servicios</label>
                <input type="text" name="navbar_menu_labels[servicios]" class="form-input w-full border rounded px-2 py-1" value="{{ $labels['servicios'] ?? 'Servicios' }}">
            </div>

            <div>
                <label class="block text-gray-700 text-sm mb-1">Contacto</label>
                <input type="text" name="navbar_menu_labels[contacto]" class="form-input w-full border rounded px-2 py-1" value="{{ $labels['contacto'] ?? 'Contacto' }}">
            </div>
        </div>
    </div>

    {{-- ── Vista previa estática (colores guardados) ── --}}
    {{-- Pequeña vista previa --}}
    <div class="mt-8 border rounded p-4 bg-gray-50">
        <span class="text-sm font-semibold text-gray-600 block mb-2">Vista previa (colores actuales):</span>
        <div class="flex items-center justify-between px-4 py-3 rounded" style="background-color: {{ $settings->navbar_bg_color ?? '#111827' }}; color: {{ $settings->navbar_text_color ?? '#ffffff' }}">
            <div class="flex items-center gap-2">
                @if($settings->navbar_show_logo && $settings->getLogoUrl())
                    <img src="{{ $settings->getLogoUrl() }}" alt="Logo" class="h-8 rounded">
                @endif
                @if($settings->navbar_show_title)
                    <span class="font-semibold">{{ $settings->site_name }}</span>
                @endif
                @if($settings->navbar_show_slogan && $settings->site_slogan)
                    <span class="text-sm opacity-80">{{ $settings->site_slogan }}</span>
                @endif
            </div>
            <div class="flex gap-3 text-sm">
                <span>{{ $labels['inicio'] ?? 'Inicio' }}</span>
                <span>{{ $labels['servicios'] ?? 'Servicios' }}</span>
                <span>{{ $labels['contacto'] ?? 'Contacto' }}</span>
            </div>
        </div>
    </div>

</div>
