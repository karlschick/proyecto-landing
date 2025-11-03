<section id="contacto" class="py-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Título de la sección -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Contáctanos
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                Estamos aquí para ayudarte. No dudes en comunicarte con nosotros.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">

            <!-- Formulario de Contacto -->
            <div class="bg-white rounded-xl shadow-2xl p-8 text-gray-900">
                <h3 class="text-2xl font-bold mb-6 text-gray-800">Envíanos un Mensaje</h3>

                @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('leads.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre Completo *
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                               placeholder="Tu nombre completo">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                               placeholder="tu@email.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="tel"
                               id="phone"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                               placeholder="+57 300 123 4567">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Asunto -->
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                            Asunto
                        </label>
                        <input type="text"
                               id="subject"
                               name="subject"
                               value="{{ old('subject') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('subject') border-red-500 @enderror"
                               placeholder="¿En qué podemos ayudarte?">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mensaje -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mensaje *
                        </label>
                        <textarea id="message"
                                  name="message"
                                  rows="5"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('message') border-red-500 @enderror"
                                  placeholder="Escribe tu mensaje aquí...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Mínimo 10 caracteres, máximo 2000</p>
                    </div>

                    <!-- Botón Enviar -->
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Enviar Mensaje
                            </button>
                            <p class="text-xs text-gray-500 text-center">
                    Al enviar este formulario, aceptas que procesemos tus datos para contactarte.
                </p>
            </form>
        </div>

        <!-- Información de Contacto -->
        <div class="space-y-6">

            <!-- Tarjetas de Información -->
            <div class="space-y-4">
                @if($settings->show_email && $settings->contact_email)
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 hover:bg-white/20 transition">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Email</h4>
                            <a href="mailto:{{ $settings->contact_email }}" class="text-gray-300 hover:text-white transition">
                                {{ $settings->contact_email }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($settings->show_phone && $settings->contact_phone)
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 hover:bg-white/20 transition">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Teléfono</h4>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->contact_phone) }}" class="text-gray-300 hover:text-white transition">
                                {{ $settings->contact_phone }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($settings->show_address && $settings->contact_address)
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 hover:bg-white/20 transition">
                    <div class="flex items-start gap-4">
                        <div class="bg-red-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Dirección</h4>
                            <p class="text-gray-300">{{ $settings->contact_address }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($settings->business_hours)
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 hover:bg-white/20 transition">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Horario</h4>
                            <p class="text-gray-300 whitespace-pre-line text-sm">{{ $settings->business_hours }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Mapa (si está habilitado) -->
    @if($settings->show_map && $settings->google_maps_url)
    <div class="mt-12">
        <div class="relative w-full h-96 rounded-xl overflow-hidden shadow-2xl">
            @php
                $mapUrl = $settings->google_maps_url;
                if(str_contains($mapUrl, '<iframe')) {
                    $mapUrl = str_replace('<iframe', '<iframe class="absolute inset-0 w-full h-full"', $mapUrl);
                    echo $mapUrl;
                } elseif(str_contains($mapUrl, '/embed')) {
                    echo '<iframe src="' . $mapUrl . '" class="absolute inset-0 w-full h-full" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                }
            @endphp
        </div>
    </div>
    @endif
</div>
