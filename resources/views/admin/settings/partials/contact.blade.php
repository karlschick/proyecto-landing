<div x-show="activeTab === 'contact'" class="space-y-6" style="display: none;">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de Contacto</h3>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800">
            <strong>Info:</strong> Configura la información de contacto que aparecerá en tu landing page.
            Solo los campos habilitados serán visibles para los usuarios.
        </p>
    </div>

    <!-- Email -->
    <div class="border rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition">
        <div class="flex items-start gap-4">
            <div class="flex items-center h-10">
                <input type="checkbox"
                       name="show_email"
                       id="show_email"
                       value="1"
                       {{ $settings->show_email ? 'checked' : '' }}
                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label for="show_email" class="block text-sm font-semibold text-gray-800 mb-1">
                    <svg class="w-5 h-5 inline mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email de Contacto
                </label>
                <p class="text-xs text-gray-500 mb-2">Email principal para que los clientes te contacten</p>
                <input type="email"
                       name="contact_email"
                       value="{{ old('contact_email', $settings->contact_email) }}"
                       placeholder="contacto@tuempresa.com"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Phone -->
    <div class="border rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition">
        <div class="flex items-start gap-4">
            <div class="flex items-center h-10">
                <input type="checkbox"
                       name="show_phone"
                       id="show_phone"
                       value="1"
                       {{ $settings->show_phone ? 'checked' : '' }}
                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label for="show_phone" class="block text-sm font-semibold text-gray-800 mb-1">
                    <svg class="w-5 h-5 inline mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Teléfono de Contacto
                </label>
                <p class="text-xs text-gray-500 mb-2">Número telefónico para llamadas</p>
                <input type="text"
                       name="contact_phone"
                       value="{{ old('contact_phone', $settings->contact_phone) }}"
                       placeholder="+57 300 123 4567"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Formato recomendado: +57 seguido del número</p>
            </div>
        </div>
    </div>

    <!-- Address -->
    <div class="border rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition">
        <div class="flex items-start gap-4">
            <div class="flex items-center h-10">
                <input type="checkbox"
                       name="show_address"
                       id="show_address"
                       value="1"
                       {{ $settings->show_address ? 'checked' : '' }}
                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label for="show_address" class="block text-sm font-semibold text-gray-800 mb-1">
                    <svg class="w-5 h-5 inline mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Dirección Física
                </label>
                <p class="text-xs text-gray-500 mb-2">Ubicación de tu negocio u oficina</p>
                <textarea name="contact_address"
                          rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Calle 123 #45-67, Bogotá, Colombia">{{ old('contact_address', $settings->contact_address) }}</textarea>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    <div class="border rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition">
        <div class="flex items-start gap-4">
            <div class="flex items-center h-10">
                <input type="checkbox"
                       name="show_map"
                       id="show_map"
                       value="1"
                       {{ $settings->show_map ? 'checked' : '' }}
                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label for="show_map" class="block text-sm font-semibold text-gray-800 mb-1">
                    <svg class="w-5 h-5 inline mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Mapa de Google Maps
                </label>
                <p class="text-xs text-gray-500 mb-2">Muestra tu ubicación en un mapa interactivo</p>
                <textarea name="google_maps_url"
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-xs"
                          placeholder="Pega aquí el código iframe completo o la URL de embed de Google Maps">{{ old('google_maps_url', $settings->google_maps_url) }}</textarea>

                <div class="mt-3 text-xs text-gray-600 bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="font-semibold mb-2 text-blue-800">📍 Cómo obtener el código correcto:</p>
                    <ol class="list-decimal list-inside space-y-1 text-blue-700">
                        <li>Ve a <a href="https://www.google.com/maps" target="_blank" class="text-blue-600 hover:underline font-semibold">Google Maps</a></li>
                        <li>Busca tu ubicación o negocio</li>
                        <li>Haz clic en <strong>"Compartir"</strong></li>
                        <li>Selecciona la pestaña <strong>"Insertar un mapa"</strong></li>
                        <li>Copia <strong>todo el código</strong> que aparece y pégalo arriba</li>
                    </ol>
                    <p class="mt-2 text-blue-600">
                        <strong>Ejemplo:</strong> <code class="bg-white px-1 py-0.5 rounded">&lt;iframe src="https://www.google.com/maps/embed?pb=..."&gt;</code>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Email -->
    <div class="border rounded-lg p-4 bg-white shadow-sm">
        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-800 mb-1">
                <svg class="w-5 h-5 inline mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Email para Notificaciones (Leads)
            </label>
            <p class="text-xs text-gray-500 mb-2">A este email llegarán los mensajes del formulario de contacto</p>
        </div>
        <input type="email"
               name="notification_email"
               value="{{ old('notification_email', $settings->notification_email) }}"
               placeholder="admin@tuempresa.com"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <p class="text-xs text-gray-500 mt-2">
            💡 Puede ser diferente al email de contacto público
        </p>
    </div>

    <!-- Business Hours -->
    <div class="border rounded-lg p-4 bg-white shadow-sm">
        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-800 mb-1">
                <svg class="w-5 h-5 inline mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Horarios de Atención
            </label>
            <p class="text-xs text-gray-500 mb-2">Especifica cuándo está disponible tu negocio</p>
        </div>
        <textarea name="business_hours"
                  rows="3"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Ejemplo:&#10;Lunes a Viernes: 9:00 AM - 6:00 PM&#10;Sábados: 10:00 AM - 2:00 PM&#10;Domingos: Cerrado">{{ old('business_hours', $settings->business_hours) }}</textarea>
        <p class="text-xs text-gray-500 mt-2">
            💡 Usa saltos de línea para separar los días
        </p>
    </div>

</div>
