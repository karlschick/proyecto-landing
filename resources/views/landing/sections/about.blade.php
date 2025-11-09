{{-- About Section --}}
<section id="nosotros" class="py-16 bg-gray-200" style="height: 50vh;" >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                    {{ $settings->about_title ?? 'Sobre Nosotros' }}
                </h2>

                @if($settings->about_description)
                    <div class="text-gray-600 mb-6 leading-relaxed space-y-4">
                        {!! nl2br(e($settings->about_description)) !!}
                    </div>
                @else
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        Somos una empresa dedicada a ofrecer las mejores soluciones para tu negocio.
                        Con años de experiencia en el mercado, nos especializamos en crear experiencias
                        únicas para nuestros clientes.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Nuestro compromiso es la calidad, innovación y satisfacción del cliente en cada proyecto.
                    </p>
                @endif

                <a href="#contacto" class="inline-block btn-primary px-6 py-3 rounded-lg font-semibold transition">
                    Conocer Más
                </a>
            </div>

            <div>
                @if($settings->about_image)
                    <img src="{{ $settings->getAboutImageUrl() }}"
                         alt="{{ $settings->about_title ?? 'Sobre Nosotros' }}"
                         class="rounded-lg shadow-lg w-full h-auto object-cover">
                @else
                    <img src="{{ asset('images/settings/about-image.jpg') }}"
                         alt="Sobre Nosotros"
                         class="rounded-lg shadow-lg w-full h-auto object-cover">
                @endif
            </div>
        </div>
    </div>
</section>
