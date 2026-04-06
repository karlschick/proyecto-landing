<section id="nosotros" class="py-12 md:py-16 bg-[rgb(245,245,0)] min-h-[60vh] md:min-h-[55vh] flex items-center relative overflow-hidden">
  {{-- Efecto de reflejo negro en el fondo --}}
  <div class="about-shine absolute inset-0 pointer-events-none"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

      <!-- Texto -->
      <div>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-6">
          {{ $settings->about_title ?? 'Soluciones tecnológicas para tu negocio' }}
        </h2>

        @if($settings->about_description)
          <div class="text-gray-900 mb-6 leading-relaxed space-y-4">
            {!! nl2br(e($settings->about_description)) !!}
          </div>
        @else
          <p class="text-gray-900 mb-4 leading-relaxed">
            Somos una empresa especializada en tecnología y servicios IT, comprometida
            con ofrecer soluciones innovadoras para empresas y personas que buscan
            optimizar sus procesos digitales.
          </p>
          <p class="text-gray-900 mb-6 leading-relaxed">
            Brindamos servicios de mantenimiento, instalación de redes, configuración
            de servidores, diseño web y consultoría tecnológica, adaptándonos a las
            necesidades específicas de cada cliente.
          </p>
        @endif

      </div>

      <!-- Imagen con marco neón naranja giratorio -->
      <div class="flex justify-center">
        <div class="image-neon-frame relative">
          @if($settings->about_image)
            <img src="{{ $settings->getAboutImageUrl() }}"
                 alt="{{ $settings->about_title ?? 'Sobre Nosotros' }}"
                 class="rounded-lg shadow-lg w-full max-w-[400px] h-auto object-contain relative z-10">
          @else
            <img src="{{ asset('images/about/about-image.jpg') }}"
                 alt="Sobre Nosotros"
                 class="rounded-lg shadow-lg w-full max-w-[400px] h-auto object-contain relative z-10">
          @endif
        </div>
      </div>

    </div>
  </div>
</section>

<style>
@keyframes shine-sweep-black {
  0% { transform: translateX(-100%) skewX(-15deg); }
  100% { transform: translateX(200%) skewX(-15deg); }
}

.about-shine::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 50%; height: 100%;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(0, 0, 0, 0.08),
    rgba(0, 0, 0, 0.15),
    rgba(0, 0, 0, 0.08),
    transparent
  );
  animation: shine-sweep-black 4s ease-in-out infinite;
}

@keyframes neon-travel {
  0% { background-position: 0% 0%; }
  100% { background-position: 200% 200%; }
}

.image-neon-frame {
  position: relative;
  padding: 4px;
  background: linear-gradient(
    90deg,
    transparent, transparent,
    #ff6b00, #ff8c00, #ffa500,
    transparent, transparent
  );
  background-size: 200% 200%;
  border-radius: 12px;
  animation: neon-travel 2s linear infinite;
  box-shadow: 0 0 20px rgba(255, 107, 0, 0.5), inset 0 0 20px rgba(255, 107, 0, 0.3);
}

.image-neon-frame::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 12px;
  padding: 3px;
  background: linear-gradient(
    0deg,
    transparent, transparent,
    #ff6b00, #ff8c00, #ffa500,
    transparent, transparent
  );
  background-size: 200% 200%;
  -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
  animation: neon-travel 2s linear infinite reverse;
}

.image-neon-frame img {
  display: block;
  border-radius: 8px;
}
</style>
