<div x-show="activeTab === 'colors'" class="space-y-6" style="display: none;">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Colores del Tema</h3>

    <div class="grid md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Color Primario</label>
            <div class="flex gap-2">
                <input type="color" name="primary_color" value="{{ old('primary_color', $settings->primary_color) }}"
                       class="h-10 w-20 rounded border border-gray-300">
                <input type="text" value="{{ $settings->primary_color }}" readonly
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Color Secundario</label>
            <div class="flex gap-2">
                <input type="color" name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color) }}"
                       class="h-10 w-20 rounded border border-gray-300">
                <input type="text" value="{{ $settings->secondary_color }}" readonly
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Color de Acento</label>
            <div class="flex gap-2">
                <input type="color" name="accent_color" value="{{ old('accent_color', $settings->accent_color) }}"
                       class="h-10 w-20 rounded border border-gray-300">
                <input type="text" value="{{ $settings->accent_color }}" readonly
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <p class="text-sm text-blue-800">
            <strong>Nota:</strong> Estos colores se aplicarán automáticamente en toda la landing page.
        </p>
    </div>
</div>
