<div x-show="activeTab === 'social'" class="space-y-6" style="display: none;">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Redes Sociales</h3>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800">
            <strong>Info:</strong> Configura tus redes sociales. Solo las redes habilitadas con URL aparecerán en el footer y otras secciones del sitio.
        </p>
    </div>

    <!-- Facebook -->
    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border-2 border-transparent hover:border-blue-200 transition">
        <div class="flex items-center h-10">
            <input type="checkbox" name="facebook_enabled" id="facebook_enabled" value="1"
                   {{ $settings->facebook_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex-1">
            <label for="facebook_enabled" class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-5 h-5 inline mr-1 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </label>
            <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}"
                   placeholder="https://facebook.com/tupagina"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('facebook_url')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Instagram -->
    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border-2 border-transparent hover:border-pink-200 transition">
        <div class="flex items-center h-10">
            <input type="checkbox" name="instagram_enabled" id="instagram_enabled" value="1"
                   {{ $settings->instagram_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-pink-600 rounded focus:ring-2 focus:ring-pink-500">
        </div>
        <div class="flex-1">
            <label for="instagram_enabled" class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-5 h-5 inline mr-1 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                Instagram
            </label>
            <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}"
                   placeholder="https://instagram.com/tupagina"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
            @error('instagram_url')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Twitter -->
    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border-2 border-transparent hover:border-sky-200 transition">
        <div class="flex items-center h-10">
            <input type="checkbox" name="twitter_enabled" id="twitter_enabled" value="1"
                   {{ $settings->twitter_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-sky-600 rounded focus:ring-2 focus:ring-sky-500">
        </div>
        <div class="flex-1">
            <label for="twitter_enabled" class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-5 h-5 inline mr-1 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                Twitter / X
            </label>
            <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}"
                   placeholder="https://twitter.com/tupagina"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
            @error('twitter_url')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- LinkedIn -->
    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border-2 border-transparent hover:border-blue-300 transition">
        <div class="flex items-center h-10">
            <input type="checkbox" name="linkedin_enabled" id="linkedin_enabled" value="1"
                   {{ $settings->linkedin_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-700 rounded focus:ring-2 focus:ring-blue-600">
        </div>
        <div class="flex-1">
            <label for="linkedin_enabled" class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-5 h-5 inline mr-1 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                LinkedIn
            </label>
            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}"
                   placeholder="https://linkedin.com/company/tuempresa"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            @error('linkedin_url')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- WhatsApp -->
    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border-2 border-transparent hover:border-green-200 transition">
        <div class="flex items-center h-10">
            <input type="checkbox" name="whatsapp_enabled" id="whatsapp_enabled" value="1"
                   {{ $settings->whatsapp_enabled ? 'checked' : '' }}
                   class="w-5 h-5 text-green-600 rounded focus:ring-2 focus:ring-green-500">
        </div>
        <div class="flex-1">
            <label for="whatsapp_enabled" class="block text-sm font-medium text-gray-700 mb-2">
                <svg class="w-5 h-5 inline mr-1 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                WhatsApp
            </label>
            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}"
                   placeholder="+573001234567"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Formato: +57 seguido del número (sin espacios ni guiones)</p>
            @error('whatsapp_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- WhatsApp Button -->
    <div class="border-t pt-6 mt-6">
        <h4 class="text-base font-semibold text-gray-800 mb-4">Botón Flotante de WhatsApp</h4>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
            <div class="flex items-center gap-2 mb-3">
                <input type="checkbox" name="show_whatsapp_button" id="show_whatsapp_button" value="1"
                       {{ $settings->show_whatsapp_button ? 'checked' : '' }}
                       class="w-5 h-5 text-green-600 rounded focus:ring-2 focus:ring-green-500">
                <label for="show_whatsapp_button" class="text-sm font-medium text-gray-700">
                    Mostrar botón flotante de WhatsApp en la landing page
                </label>
            </div>
            <p class="text-xs text-gray-600 pl-7">
                Este botón aparecerá en la esquina inferior derecha del sitio web
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje predeterminado</label>
            <input type="text" name="whatsapp_button_message" value="{{ old('whatsapp_button_message', $settings->whatsapp_button_message) }}"
                   placeholder="Hola, quiero más información"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Este mensaje se enviará automáticamente al hacer clic en el botón</p>
        </div>
    </div>

    <!-- Vista Previa -->
    <div class="border-t pt-6 mt-6">
        <h4 class="text-base font-semibold text-gray-800 mb-4">Vista Previa de Redes Sociales</h4>

        <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-6">
            <p class="text-xs text-gray-500 mb-4 uppercase font-semibold">Cómo se verá en el footer:</p>

            <div class="bg-gray-900 text-white p-6 rounded-lg">
                @php
                    $previewNetworks = [];
                    if($settings->facebook_enabled && $settings->facebook_url) $previewNetworks['facebook'] = true;
                    if($settings->instagram_enabled && $settings->instagram_url) $previewNetworks['instagram'] = true;
                    if($settings->twitter_enabled && $settings->twitter_url) $previewNetworks['twitter'] = true;
                    if($settings->linkedin_enabled && $settings->linkedin_url) $previewNetworks['linkedin'] = true;
                @endphp

                @if(count($previewNetworks) > 0)
                <div class="flex justify-center space-x-4">
                    @if(isset($previewNetworks['facebook']))
                    <div class="text-gray-400 hover:text-blue-400 transition cursor-pointer" title="Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    @endif
                    @if(isset($previewNetworks['instagram']))
                    <div class="text-gray-400 hover:text-pink-400 transition cursor-pointer" title="Instagram">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    @endif
                    @if(isset($previewNetworks['twitter']))
                    <div class="text-gray-400 hover:text-sky-400 transition cursor-pointer" title="Twitter">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </div>
                    @endif
                    @if(isset($previewNetworks['linkedin']))
                    <div class="text-gray-400 hover:text-blue-500 transition cursor-pointer" title="LinkedIn">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </div>
                    @endif
                </div>
                @else
                <p class="text-center text-gray-500 text-sm italic">
                    No hay redes sociales habilitadas. Activa y agrega URLs para verlas aquí.
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
