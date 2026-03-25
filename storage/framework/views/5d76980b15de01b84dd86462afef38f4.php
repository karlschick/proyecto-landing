
<section class="relative text-white overflow-hidden flex items-end"
         style="height: 80vh;">

    <!-- Background dinámico -->
    <?php if($settings->hero_background_type === 'video' && $settings->hero_background_video): ?>
        <!-- Video de fondo -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="<?php echo e($settings->getHeroBackgroundVideoUrl()); ?>?v=<?php echo e($settings->updated_at?->timestamp ?? time()); ?>" type="video/mp4">
        </video>
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black"
             style="opacity: <?php echo e($settings->hero_overlay_opacity ?? 0.5); ?>"></div>

    <?php elseif($settings->hero_background_type === 'image' && $settings->hero_background_image): ?>
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('<?php echo e($settings->getHeroBackgroundImageUrl()); ?>?v=<?php echo e(time()); ?>')">
        </div>
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black"
             style="opacity: <?php echo e($settings->hero_overlay_opacity ?? 0.5); ?>"></div>

    <?php else: ?>
        <!-- Video por defecto -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="<?php echo e(asset('videos/hero/plantilla1.mp4')); ?>" type="video/mp4">
        </video>
        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black" style="opacity: 0.5"></div>
    <?php endif; ?>

    <?php
        use Illuminate\Support\Str;

        $buttonUrl = $settings->hero_button_url ?? '#productos';

        // Detectar tipo de URL y construir correctamente
        if (Str::startsWith($buttonUrl, '#')) {
            $finalUrl = url('/') . '/' . ltrim($buttonUrl, '/');
        } elseif (Str::startsWith($buttonUrl, ['http://', 'https://'])) {
            $finalUrl = $buttonUrl;
        } else {
            $finalUrl = url($buttonUrl);
        }
    ?>

    <!-- Contenido en el 25% inferior (imagen visible 75%) -->
<div class="relative z-10 w-full"
     style="padding-bottom: 5vh; padding-top: 2vh; height: 35%; display: flex; flex-direction: column; justify-content: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            
            <?php if($settings->hero_show_logo_instead && $settings->getLogoUrl()): ?>
                <img src="<?php echo e($settings->getLogoUrl()); ?>?v=<?php echo e(time()); ?>"
                     alt="<?php echo e($settings->site_name); ?>"
                     class="mx-auto mb-4 h-20 md:h-28 object-contain animate-fade-in">
            <?php else: ?>
                <h1 class="font-bold mb-4 animate-fade-in"
                    style="color: <?php echo e($settings->hero_title_color ?? '#ffffff'); ?>;
                           font-family:
                            <?php switch($settings->hero_title_font):
                                case ('montserrat'): ?> 'Montserrat', sans-serif; <?php break; ?>
                                <?php case ('poppins'): ?> 'Poppins', sans-serif; <?php break; ?>
                                <?php case ('roboto'): ?> 'Roboto', sans-serif; <?php break; ?>
                                <?php case ('playfair'): ?> 'Playfair Display', serif; <?php break; ?>
                                <?php case ('oswald'): ?> 'Oswald', sans-serif; <?php break; ?>
                                <?php case ('raleway'): ?> 'Raleway', sans-serif; <?php break; ?>
                                <?php default: ?> inherit;
                            <?php endswitch; ?>;
                           font-size: clamp(2rem, 6vw, 4rem);">
                    <?php echo e($settings->hero_title ?? 'Bienvenido a ' . ($settings->site_name ?? 'Tu landingPage')); ?>

                </h1>
            <?php endif; ?>

            
            <?php if($settings->site_slogan): ?>
                <p class="text-lg md:text-xl text-white/80 mb-2 font-medium">
                    <?php echo e($settings->site_slogan); ?>

                </p>
            <?php endif; ?>

            
            <p class="text-xl md:text-2xl text-white/90 mb-3 max-w-3xl mx-auto">
                <?php echo e($settings->hero_subtitle ?? ''); ?>

            </p>

            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e($finalUrl); ?>"
                   class="hero-button inline-block bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold relative overflow-hidden transition-all duration-300">
                    <span class="relative z-10"><?php echo e($settings->hero_button_text ?? 'Ver Productos'); ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Pequeña animación para que aparezca suave */
@keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 5.5s ease forwards;
}

/* Efecto de reflejo amarillo en el botón */
.hero-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(245, 245, 0, 0.6), transparent);
    transition: left 0.5s ease;
}

.hero-button:hover::before {
    left: 100%;
}

.hero-button:hover {
    background-color: rgba(245, 245, 0, 0.15);
    border-color: rgb(245, 245, 0);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 245, 0, 0.4);
}
</style>
<?php /**PATH D:\htdocs\skubox\landing\resources\views/landing/sections/hero.blade.php ENDPATH**/ ?>