<section id="nosotros" class="py-16 relative overflow-hidden min-h-[40vh]">
    
    <video
        autoplay
        muted
        loop
        playsinline
        class="absolute inset-0 w-full h-full object-cover z-0"
        style="pointer-events: none;"
    >
        <source src="<?php echo e(asset('videos/features-background.mp4')); ?>" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/60 to-black/80 z-1"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl text-gray-200 font-bold mb-3 sm:mb-4">
                ¿Por Qué Elegirnos?
            </h2>
            <p class="text-sm sm:text-base text-gray-200 max-w-2xl mx-auto px-4">
                Tecnología de calidad — soluciones diseñadas según las necesidades de tu empresa o negocio.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            
            <div class="text-center feature-card bg-black/30 backdrop-blur-sm p-4 sm:p-5 rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-400 feature-title">Resultados garantizados</h3>
                <p class="text-sm sm:text-base text-gray-200">
                    Implementamos soluciones tecnológicas que realmente funcionan y se adaptan a tu negocio.
                </p>
            </div>

            
            <div class="text-center feature-card bg-black/30 backdrop-blur-sm p-4 sm:p-5 rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-400 feature-title">Experiencia IT</h3>
                <p class="text-sm sm:text-base text-gray-200">
                    Más de 10 años en el sector tecnológico respaldan cada servicio y solución que ofrecemos.
                </p>
            </div>

            
            <div class="text-center feature-card bg-black/30 backdrop-blur-sm p-4 sm:p-5 rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-400 feature-title">Precio Justo</h3>
                <p class="text-sm sm:text-base text-gray-200">
                    Servicios profesionales a precios competitivos, sin costos ocultos ni sorpresas.
                </p>
            </div>

            
            <div class="text-center feature-card bg-black/30 backdrop-blur-sm p-4 sm:p-5 rounded-lg">
                <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-400 feature-title">Soporte 24/7</h3>
                <p class="text-sm sm:text-base text-gray-200">
                    Estamos disponibles cuando nos necesitas, brindando asistencia técnica en todo momento.
                </p>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes text-shine {
    0% { background-position: -200% center; }
    100% { background-position: 200% center; }
}

.feature-card {
    transition: transform 0.3s ease;
}

@media (min-width: 768px) {
    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-card:hover .feature-title {
        animation: text-shine 1.5s linear infinite;
    }
}

.feature-title {
    background: linear-gradient(
        90deg,
        #9ca3af,
        #ffffff,
        #f5f500,
        #ffffff,
        #9ca3af
    );
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: all 0.3s ease;
}

@media (max-width: 767px) {
    .feature-card {
        border: 1px solid rgba(245, 245, 0, 0.2);
    }
}
</style>
<?php /**PATH D:\htdocs\skubox\landing\resources\views/landing/sections/features.blade.php ENDPATH**/ ?>