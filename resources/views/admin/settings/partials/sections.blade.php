<div x-show="activeTab === 'sections'" class="space-y-6" style="display: none;">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Control de Secciones</h3>

    <!-- Hero Section -->
    @include('admin.settings.partials.hero-section')

    <!-- About Section -->
    @include('admin.settings.partials.about-section')

    <!-- Other Sections -->
    <div class="grid md:grid-cols-2 gap-4">
        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="checkbox" name="services_enabled" id="services_enabled" value="1"
                   {{ $settings->services_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="services_enabled" class="text-sm font-medium text-gray-800">Mostrar Servicios</label>
        </div>

        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="checkbox" name="products_enabled" id="products_enabled" value="1"
                   {{ $settings->products_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="products_enabled" class="text-sm font-medium text-gray-800">Mostrar Productos</label>
        </div>

        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="checkbox" name="testimonials_enabled" id="testimonials_enabled" value="1"
                   {{ $settings->testimonials_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="testimonials_enabled" class="text-sm font-medium text-gray-800">Mostrar Testimonios</label>
        </div>

        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="checkbox" name="gallery_enabled" id="gallery_enabled" value="1"
                   {{ $settings->gallery_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="gallery_enabled" class="text-sm font-medium text-gray-800">Mostrar Galería</label>
        </div>

        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
            <input type="checkbox" name="contact_enabled" id="contact_enabled" value="1"
                   {{ $settings->contact_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            <label for="contact_enabled" class="text-sm font-medium text-gray-800">Mostrar Formulario Contacto</label>
        </div>
    </div>
</div>
