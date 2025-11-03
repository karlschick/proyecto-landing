<div x-show="activeTab === 'seo'" class="space-y-6" style="display: none;">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">SEO y Analytics</h3>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800">
            <strong>Info:</strong> Optimiza tu sitio para motores de búsqueda y configura herramientas de análisis para medir el tráfico.
        </p>
    </div>

    <!-- Meta Description -->
    <div class="border rounded-lg p-4 bg-white shadow-sm">
        <label class="block text-sm font-semibold text-gray-800 mb-2">
            <svg class="w-5 h-5 inline mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Meta Description
        </label>
        <textarea name="meta_description"
                  rows="3"
                  maxlength="160"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Descripción breve y atractiva de tu sitio web que aparecerá en los resultados de búsqueda"
                  x-data="{ count: {{ strlen($settings->meta_description ?? '') }} }"
                  x-on:input="count = $event.target.value.length">{{ old('meta_description', $settings->meta_description) }}</textarea>
        <div class="flex justify-between mt-1">
            <p class="text-xs text-gray-500">
                📝 Aparece en Google debajo del título de tu página
            </p>
            <p class="text-xs font-medium"
               :class="count > 160 ? 'text-red-600' : 'text-gray-600'"
               x-text="count + '/160 caracteres'"></p>
        </div>

        <!-- Vista previa de Google -->
        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xs text-gray-500 mb-2 font-semibold">Vista previa en Google:</p>
            <div class="space-y-1">
                <h3 class="text-lg text-blue-600 hover:underline cursor-pointer font-medium">
                    {{ $settings->site_name ?? 'Tu Sitio Web' }} - Inicio
                </h3>
                <p class="text-xs text-green-700">{{ url('/') }}</p>
                <p class="text-sm text-gray-700">
                    {{ $settings->meta_description ?? 'Tu descripción SEO aparecerá aquí...' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Meta Keywords -->
    <div class="border rounded-lg p-4 bg-white shadow-sm">
        <label class="block text-sm font-semibold text-gray-800 mb-2">
            <svg class="w-5 h-5 inline mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Meta Keywords (Palabras Clave)
        </label>
        <input type="text"
               name="meta_keywords"
               value="{{ old('meta_keywords', $settings->meta_keywords) }}"
               placeholder="desarrollo web, diseño, ecommerce, marketing digital"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <p class="text-xs text-gray-500 mt-2">
            💡 Separa las palabras clave con comas. Ejemplo: <code class="bg-gray-100 px-2 py-0.5 rounded">servicio1, servicio2, industria</code>
        </p>
        <p class="text-xs text-yellow-600 mt-1">
            ⚠️ Nota: Muchos motores de búsqueda modernos ya no usan keywords, pero no hace daño incluirlas
        </p>
    </div>

    <!-- Analytics IDs -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Google Analytics -->
        <div class="border rounded-lg p-4 bg-white shadow-sm">
            <label class="block text-sm font-semibold text-gray-800 mb-2">
                <svg class="w-5 h-5 inline mr-1 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Google Analytics ID
            </label>
            <input type="text"
                   name="google_analytics_id"
                   value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                   placeholder="G-XXXXXXXXXX"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <div class="mt-3 text-xs text-gray-600 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <p class="font-semibold mb-2 text-yellow-800">📊 ¿Cómo obtener tu ID?</p>
                <ol class="list-decimal list-inside space-y-1 text-yellow-700">
                    <li>Ve a <a href="https://analytics.google.com/" target="_blank" class="text-blue-600 hover:underline font-semibold">Google Analytics</a></li>
                    <li>Crea una cuenta o inicia sesión</li>
                    <li>Crea una propiedad para tu sitio</li>
                    <li>Copia el ID que empieza con <strong>G-</strong></li>
                </ol>
                <p class="mt-2">
                    <strong>Formato:</strong> <code class="bg-white px-2 py-0.5 rounded">G-XXXXXXXXXX</code>
                </p>
            </div>

            @if($settings->google_analytics_id)
            <div class="mt-2 flex items-center text-green-600 text-sm">
                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                ✓ Analytics configurado y activo
            </div>
            @endif
        </div>

        <!-- Facebook Pixel -->
        <div class="border rounded-lg p-4 bg-white shadow-sm">
            <label class="block text-sm font-semibold text-gray-800 mb-2">
                <svg class="w-5 h-5 inline mr-1 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook Pixel ID
            </label>
            <input type="text"
                   name="facebook_pixel_id"
                   value="{{ old('facebook_pixel_id', $settings->facebook_pixel_id) }}"
                   placeholder="1234567890123456"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <div class="mt-3 text-xs text-gray-600 bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="font-semibold mb-2 text-blue-800">📱 ¿Cómo obtener tu Pixel ID?</p>
                <ol class="list-decimal list-inside space-y-1 text-blue-700">
                    <li>Ve a <a href="https://business.facebook.com/events_manager2" target="_blank" class="text-blue-600 hover:underline font-semibold">Facebook Events Manager</a></li>
                    <li>Selecciona tu cuenta publicitaria</li>
                    <li>Haz clic en "Agregar eventos" → "Desde un nuevo sitio web"</li>
                    <li>Copia el ID de Pixel (solo números)</li>
                </ol>
                <p class="mt-2">
                    <strong>Formato:</strong> <code class="bg-white px-2 py-0.5 rounded">Solo números (15-16 dígitos)</code>
                </p>
            </div>

            @if($settings->facebook_pixel_id)
            <div class="mt-2 flex items-center text-green-600 text-sm">
                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                ✓ Facebook Pixel configurado y activo
            </div>
            @endif
        </div>
    </div>

    <!-- Advertencia de caché -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-yellow-800 mb-1">Importante sobre Analytics</p>
                <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                    <li>Los cambios en Analytics y Pixel pueden tardar hasta 24 horas en reflejarse</li>
                    <li>Limpia la caché del navegador después de guardar para ver los cambios</li>
                    <li>Usa extensiones como "Tag Assistant" para verificar que Google Analytics esté funcionando</li>
                    <li>Verifica el Pixel con "Facebook Pixel Helper" (extensión de Chrome)</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Herramientas de verificación -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-gray-800 mb-3">🔧 Herramientas útiles</h4>
        <div class="grid md:grid-cols-2 gap-3">
            <a href="https://search.google.com/search-console" target="_blank"
               class="flex items-center p-3 bg-white rounded border hover:border-blue-400 transition">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-800">Google Search Console</p>
                    <p class="text-xs text-gray-500">Monitorea tu sitio en Google</p>
                </div>
            </a>

            <a href="https://analytics.google.com/" target="_blank"
               class="flex items-center p-3 bg-white rounded border hover:border-yellow-400 transition">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-800">Google Analytics</p>
                    <p class="text-xs text-gray-500">Ver estadísticas de tráfico</p>
                </div>
            </a>
        </div>
    </div>
</div>
