<div x-show="activeTab === 'navbar'" x-cloak>
    <h2 class="text-lg font-semibold mb-4">Configuración de la Barra de Navegación</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Color de fondo -->
        <div>
            <label class="block font-medium text-gray-700 mb-1">Color de fondo</label>
            <input type="color" name="navbar_bg_color" value="{{ $settings->navbar_bg_color ?? '#111827' }}" class="w-full border rounded p-1 h-10 cursor-pointer">
        </div>

        <!-- Color del texto -->
        <div>
            <label class="block font-medium text-gray-700 mb-1">Color del texto</label>
            <input type="color" name="navbar_text_color" value="{{ $settings->navbar_text_color ?? '#ffffff' }}" class="w-full border rounded p-1 h-10 cursor-pointer">
        </div>
    </div>

    <div class="mt-6 space-y-3">
        <!-- Mostrar logo -->
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_logo" class="rounded" {{ $settings->navbar_show_logo ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar logo</span>
        </label>

        <!-- Mostrar título -->
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_title" class="rounded" {{ $settings->navbar_show_title ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar título del sitio</span>
        </label>

        <!-- Mostrar eslogan -->
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_slogan" class="rounded" {{ $settings->navbar_show_slogan ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar eslogan</span>
        </label>

            <!-- NUEVO: Mostrar enlace Tienda -->
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="navbar_show_shop" class="rounded" {{ $settings->navbar_show_shop ?? true ? 'checked' : '' }}>
            <span class="text-gray-700">Mostrar enlace "Tienda" en el menú</span>
        </label>
    </div>

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


    @php
    // Decodificar etiquetas personalizadas del menú
    $labels = json_decode($settings->navbar_menu_labels ?? '{}', true);
    @endphp
    <!-- Pequeña vista previa -->
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
