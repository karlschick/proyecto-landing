<div x-show="activeTab === 'sections'" class="space-y-6" style="display: none;">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Control de Secciones</h3>

    <!-- Hero Section -->
    @include('admin.settings.partials.hero-section')

    <hr class="my-6 border-gray-300">

    <h4 class="text-lg font-semibold text-gray-800 mb-3">Personalización del Hero</h4>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Color del título -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Color del título</label>
            <input type="color"
                   name="hero_title_color"
                   value="{{ old('hero_title_color', $settings->hero_title_color ?? '#ffffff') }}"
                   class="form-control form-control-color w-16 h-10 rounded cursor-pointer border-gray-300">
            <p class="text-xs text-gray-500 mt-1">Selecciona el color del texto principal del Hero.</p>
        </div>

        <!-- Fuente del título -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fuente del título</label>
            <select name="hero_title_font" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @php
                    $fonts = [
                        'default' => 'Predeterminada',
                        'montserrat' => 'Montserrat',
                        'poppins' => 'Poppins',
                        'roboto' => 'Roboto',
                        'playfair' => 'Playfair Display',
                        'oswald' => 'Oswald',
                        'raleway' => 'Raleway',
                    ];
                @endphp
                @foreach($fonts as $key => $label)
                    <option value="{{ $key }}" {{ ($settings->hero_title_font ?? 'default') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Selecciona la fuente del título del Hero.</p>
        </div>

        <!-- Mostrar logo o texto -->
        <div>
            <input type="hidden" name="hero_show_logo_instead" value="0">
            <input type="checkbox" id="hero_show_logo_instead" name="hero_show_logo_instead" value="1"
                   class="form-check-input h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                   {{ ($settings->hero_show_logo_instead ?? false) ? 'checked' : '' }}>
            <label for="hero_show_logo_instead" class="ml-2 text-sm font-medium text-gray-700">
                Mostrar logo en lugar del texto
            </label>
        </div>
    </div>

    <hr class="my-6 border-gray-300">

    <!-- About Section -->
    @include('admin.settings.partials.about-section')

    <hr class="my-6 border-gray-300">

    <h4 class="text-lg font-semibold text-gray-800 mb-3">Visibilidad de Secciones</h4>

    <!-- Other Sections -->
    <div class="grid md:grid-cols-2 gap-4">

        <!-- Hero Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="hero_enabled" value="0">
            <input type="checkbox" name="hero_enabled" id="hero_enabled" value="1"
                   {{ ($settings->hero_enabled ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="hero_enabled" class="text-sm font-medium text-gray-800">Mostrar Hero</label>
        </div>

        <!-- About Section Toggle -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="about_enabled" value="0">
            <input type="checkbox" name="about_enabled" id="about_enabled" value="1"
                   {{ ($settings->about_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="about_enabled" class="text-sm font-medium text-gray-800">Mostrar Sección Acerca de</label>
        </div>

        <!-- Stats Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="stats_enabled" value="0">
            <input type="checkbox" name="stats_enabled" id="stats_enabled" value="1"
                   {{ ($settings->stats_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="stats_enabled" class="text-sm font-medium text-gray-800">Mostrar Estadísticas</label>
        </div>

        <!-- Features Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="features_enabled" value="0">
            <input type="checkbox" name="features_enabled" id="features_enabled" value="1"
                   {{ ($settings->features_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="features_enabled" class="text-sm font-medium text-gray-800">Mostrar Características</label>
        </div>

        <!-- Services Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="services_enabled" value="0">
            <input type="checkbox" name="services_enabled" id="services_enabled" value="1"
                   {{ ($settings->services_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="services_enabled" class="text-sm font-medium text-gray-800">Mostrar Servicios</label>
        </div>

        <!-- Shop Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="shop_enabled" value="0">
            <input type="checkbox" name="shop_enabled" id="shop_enabled" value="1"
                   {{ ($settings->shop_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="shop_enabled" class="text-sm font-medium text-gray-800">Mostrar Tienda</label>
        </div>

        <!-- Products Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="products_enabled" value="0">
            <input type="checkbox" name="products_enabled" id="products_enabled" value="1"
                   {{ ($settings->products_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="products_enabled" class="text-sm font-medium text-gray-800">Mostrar Productos</label>
        </div>

        <!-- Testimonials Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="testimonials_enabled" value="0">
            <input type="checkbox" name="testimonials_enabled" id="testimonials_enabled" value="1"
                   {{ ($settings->testimonials_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="testimonials_enabled" class="text-sm font-medium text-gray-800">Mostrar Testimonios</label>
        </div>

        <!-- Gallery Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="gallery_enabled" value="0">
            <input type="checkbox" name="gallery_enabled" id="gallery_enabled" value="1"
                   {{ ($settings->gallery_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="gallery_enabled" class="text-sm font-medium text-gray-800">Mostrar Galería</label>
        </div>

        <!-- CTA Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="cta_enabled" value="0">
            <input type="checkbox" name="cta_enabled" id="cta_enabled" value="1"
                   {{ ($settings->cta_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="cta_enabled" class="text-sm font-medium text-gray-800">Mostrar CTA (Llamada a la Acción)</label>
        </div>

        <!-- Contact Section -->
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="hidden" name="contact_enabled" value="0">
            <input type="checkbox" name="contact_enabled" id="contact_enabled" value="1"
                   {{ ($settings->contact_enabled ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="contact_enabled" class="text-sm font-medium text-gray-800">Mostrar Formulario Contacto</label>
        </div>
    </div>
</div>
