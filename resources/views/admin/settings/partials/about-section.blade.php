<div class="border rounded-lg p-4">
    <div class="flex items-center gap-2 mb-4">
        <input type="checkbox" name="about_enabled" id="about_enabled" value="1"
               {{ $settings->about_enabled ? 'checked' : '' }}
               class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
        <label for="about_enabled" class="text-base font-semibold text-gray-800">Sección Nosotros</label>
    </div>

    <div class="space-y-3 pl-7">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
            <input type="text" name="about_title" value="{{ old('about_title', $settings->about_title) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
            <textarea name="about_description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('about_description', $settings->about_description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen</label>
            @if($settings->about_image)
                <div class="mb-2">
                    <img src="{{ $settings->getAboutImageUrl() }}" alt="Imagen About" class="h-32 object-cover rounded">
                </div>
            @endif
            <input type="file" name="about_image" accept="image/jpeg,image/png,image/jpg"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>
</div>
