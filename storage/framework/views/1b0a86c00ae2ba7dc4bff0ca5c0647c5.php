<?php
    // Obtener carrito por sesión
    $cart = \App\Models\Cart::where('session_id', session()->getId())
        ->where('expires_at', '>', now())
        ->with('items')
        ->first();

    $cartCount = $cart ? $cart->items->sum('quantity') : 0;

    // Labels y colores del navbar desde settings
    $labels = json_decode($settings->navbar_menu_labels ?? '{}', true);

    // Valores por defecto si no están definidos
    $navbarBg = $settings->navbar_bg_color ?? null; // si es null, dejamos las clases por defecto
    $navbarText = $settings->navbar_text_color ?? null;

    $showLogo = $settings->navbar_show_logo ?? true;
    $showTitle = $settings->navbar_show_title ?? true;
    $showSlogan = $settings->navbar_show_slogan ?? true;
?>

<nav
    class="sticky top-0 z-50 shadow-lg <?php echo e($navbarBg ? '' : 'bg-gray-900'); ?>"
    x-data="{ mobileMenuOpen: false, showLoginDropdown: false }"
    <?php if($navbarBg): ?> style="background-color: <?php echo e($navbarBg); ?>;" <?php endif; ?>
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3">
                    <?php if($showLogo && $settings->getLogoUrl()): ?>
                        <img src="<?php echo e($settings->getLogoUrl()); ?>" alt="<?php echo e($settings->site_name); ?>" class="h-10">
                    <?php endif; ?>

                    <div>
                        <?php if($showTitle): ?>
                            <div class="font-bold text-lg" <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>><?php echo e($settings->site_name); ?></div>
                        <?php endif; ?>

                        <?php if($showSlogan && $settings->site_slogan): ?>
                            <div class="text-xs text-gray-400" <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>; opacity: .85;" <?php endif; ?>><?php echo e($settings->site_slogan); ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?php echo e(route('home')); ?>"
                   class="hover:text-blue-400 transition <?php echo e(request()->routeIs('home') ? 'text-blue-400 font-semibold' : ''); ?>"
                   <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <?php echo e($labels['inicio'] ?? 'Inicio'); ?>

                </a>

                <a href="<?php echo e(route('home')); ?>#nosotros"
                   class="hover:text-blue-400 transition"
                   <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <?php echo e($labels['nosotros'] ?? 'Nosotros'); ?>

                </a>

                <a href="<?php echo e(route('home')); ?>#servicios"
                   class="hover:text-blue-400 transition"
                   <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <?php echo e($labels['servicios'] ?? 'Servicios'); ?>

                </a>


                
                <?php if($settings->products_enabled && ($settings->navbar_show_shop ?? true)): ?>
                    <a href="<?php echo e(route('shop.index')); ?>"
                    class="hover:text-blue-400 transition"
                    <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                        <?php echo e($labels['tienda'] ?? 'Tienda'); ?>

                    </a>
                <?php endif; ?>

                <a href="<?php echo e(route('home')); ?>#contacto"
                   class="hover:text-blue-400 transition"
                   <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <?php echo e($labels['contacto'] ?? 'Contacto'); ?>

                </a>
            </div>

            <!-- Right Side: Cart & Auth -->
            <div class="hidden md:flex items-center space-x-4 relative">

                <!-- Cart Icon -->
                <a href="<?php echo e(route('cart.index')); ?>" class="relative hover:text-blue-400 transition" <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>

                    <?php if($cartCount > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            <?php echo e($cartCount); ?>

                        </span>
                    <?php endif; ?>
                </a>

                <!-- Auth Links -->
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-blue-400 transition" title="Mi cuenta" <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                <?php else: ?>
                    <!-- Botón de login (abre dropdown) -->
                    <div class="relative" @click.away="showLoginDropdown = false">
                        <button @click="showLoginDropdown = !showLoginDropdown" class="hover:text-blue-400 transition" title="Iniciar sesión" <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h12m-12 0l4-4m-4 4l4 4m-8 8a9 9 0 100-18 9 9 0 000 18z" />
                            </svg>
                        </button>

                        <!-- Dropdown de login -->
                        <div
                            x-show="showLoginDropdown"
                            x-cloak
                            x-transition.origin.top.right
                            class="absolute right-0 mt-3 w-64 bg-gray-900 text-white rounded-xl shadow-xl border border-gray-700 p-4 z-50"
                            style="display: none;"
                        >
                            <h3 class="text-sm font-semibold mb-2 text-gray-200 text-center">Iniciar sesión</h3>

                            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-3">
                                <?php echo csrf_field(); ?>
                                <input type="email" name="email" placeholder="Correo electrónico" required
                                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                <input type="password" name="password" placeholder="Contraseña" required
                                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium transition">
                                    Entrar
                                </button>
                            </form>

                            <div class="text-center mt-2">
                                <a href="<?php echo e(route('password.request')); ?>" class="text-xs text-blue-400 hover:underline">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center space-x-4">

                <!-- Cart Icon Mobile -->
                <a href="<?php echo e(route('cart.index')); ?>" class="relative hover:text-blue-400 transition" <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>

                    <?php if($cartCount > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            <?php echo e($cartCount); ?>

                        </span>
                    <?php endif; ?>
                </a>

                <!-- Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white hover:text-blue-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

<!-- Mobile Menu -->
<div x-show="mobileMenuOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2"
     class="md:hidden <?php echo e($navbarBg ? '' : 'bg-gray-800'); ?>"
     style="display: none;">

    <div class="px-4 pt-2 pb-4 space-y-2">
        <a href="<?php echo e(route('home')); ?>"
           @click="mobileMenuOpen = false"
           class="block py-2 px-4 rounded hover:bg-gray-700 transition <?php echo e(request()->routeIs('home') ? 'bg-gray-700 text-blue-400' : ''); ?>"
           <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
            <?php echo e($labels['inicio'] ?? 'Inicio'); ?>

        </a>

        <a href="<?php echo e(route('home')); ?>#nosotros"
           @click="mobileMenuOpen = false"
           class="block py-2 px-4 rounded hover:bg-gray-700 transition"
           <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
            <?php echo e($labels['nosotros'] ?? 'Nosotros'); ?>

        </a>

        <a href="<?php echo e(route('home')); ?>#servicios"
           @click="mobileMenuOpen = false"
           class="block py-2 px-4 rounded hover:bg-gray-700 transition"
           <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
            <?php echo e($labels['servicios'] ?? 'Servicios'); ?>

        </a>

            <?php if($settings->products_enabled && ($settings->navbar_show_shop ?? true)): ?>
                <a href="<?php echo e(route('shop.index')); ?>"
                @click="mobileMenuOpen = false"
                class="block py-2 px-4 rounded hover:bg-gray-700 transition"
                <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <?php echo e($labels['tienda'] ?? 'Tienda'); ?>

                </a>
            <?php endif; ?>

        <a href="<?php echo e(route('home')); ?>#contacto"
           @click="mobileMenuOpen = false"
           class="block py-2 px-4 rounded hover:bg-gray-700 transition"
           <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
            <?php echo e($labels['contacto'] ?? 'Contacto'); ?>

        </a>

        <a href="<?php echo e(route('cart.index')); ?>"
           @click="mobileMenuOpen = false"
           class="block py-2 px-4 rounded hover:bg-gray-700 transition flex items-center space-x-2"
           <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
            🛒 <span>Carrito</span>
            <?php if($cartCount > 0): ?>
                <span class="bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                    <?php echo e($cartCount); ?>

                </span>
            <?php endif; ?>
        </a>

        <div class="pt-4 border-t border-gray-700">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                   @click="mobileMenuOpen = false"
                   class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700 transition"
                   <?php if($navbarText): ?> style="color: <?php echo e($navbarText); ?>;" <?php endif; ?>>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Mi Cuenta</span>
                </a>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>"
            class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition font-medium w-full">
                Iniciar Sesión
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
</nav>
<?php /**PATH D:\htdocs\Fitness\resources\views/landing/navbar.blade.php ENDPATH**/ ?>