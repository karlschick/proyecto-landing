<nav class="bg-gray-900 text-white sticky top-0 z-50 shadow-lg" x-data="{ mobileMenuOpen: false, cartCount: 3 }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ $settings->getLogoUrl() }}" alt="{{ $settings->site_name }}" class="h-10">
                    <div>
                        <div class="font-bold text-lg">{{ $settings->site_name }}</div>
                        @if($settings->site_slogan)
                        <div class="text-xs text-gray-400">{{ $settings->site_slogan }}</div>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="hover:text-blue-400 transition {{ request()->routeIs('home') ? 'text-blue-400 font-semibold' : '' }}">
                    Inicio
                </a>
                <a href="#productos" class="hover:text-blue-400 transition">
                    Tienda
                </a>
                <a href="#nosotros" class="hover:text-blue-400 transition">
                    Nosotros
                </a>
                <a href="#servicios" class="hover:text-blue-400 transition">
                    Servicios
                </a>
                <a href="#contacto" class="hover:text-blue-400 transition">
                    Contacto
                </a>
            </div>

            <!-- Right Side: Cart & Auth -->
            <div class="hidden md:flex items-center space-x-4">

                <!-- Cart Icon -->
                <a href="#" class="relative hover:text-blue-400 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <!-- Badge -->
                    <span x-show="cartCount > 0"
                          class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
                          x-text="cartCount">
                    </span>
                </a>

                <!-- Auth Links -->
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 hover:text-blue-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mi Cuenta</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition font-medium">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center space-x-4">
                <!-- Cart Icon Mobile -->
                <a href="#" class="relative hover:text-blue-400 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="cartCount > 0"
                          class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
                          x-text="cartCount">
                    </span>
                </a>

                <!-- Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white hover:text-blue-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden bg-gray-800"
         style="display: none;">

        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="{{ route('home') }}" class="block py-2 px-4 rounded hover:bg-gray-700 transition {{ request()->routeIs('home') ? 'bg-gray-700 text-blue-400' : '' }}">
                Inicio
            </a>
            <a href="#productos" class="block py-2 px-4 rounded hover:bg-gray-700 transition">
                Tienda
            </a>
            <a href="#nosotros" class="block py-2 px-4 rounded hover:bg-gray-700 transition">
                Nosotros
            </a>
            <a href="#servicios" class="block py-2 px-4 rounded hover:bg-gray-700 transition">
                Servicios
            </a>
            <a href="#contacto" class="block py-2 px-4 rounded hover:bg-gray-700 transition">
                Contacto
            </a>

            <div class="pt-4 border-t border-gray-700">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mi Cuenta</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block bg-blue-600 hover:bg-blue-700 text-center py-2 px-4 rounded-lg transition font-medium">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
