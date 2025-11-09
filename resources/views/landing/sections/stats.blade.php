
<section class="py-5 bg-gray-600 text-white" style="height: 13vh;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            {{-- Stat 1 --}}
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
                     x-data="{ count: 0 }"
                     x-init="$el.classList.contains('in-view') || window.addEventListener('scroll', () => {
                         if ($el.getBoundingClientRect().top < window.innerHeight && count === 0) {
                             let interval = setInterval(() => {
                                 if (count < 150) { count += 5; $el.textContent = count + '+'; }
                                 else { clearInterval(interval); $el.textContent = '150+'; }
                             }, 20);
                         }
                     })">
                    0+
                </div>
                <p class="text-gray-400 text-sm md:text-base">Proyectos Completados</p>
            </div>

            {{-- Stat 2 --}}
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
                     x-data="{ count: 0 }"
                     x-init="window.addEventListener('scroll', () => {
                         if ($el.getBoundingClientRect().top < window.innerHeight && count === 0) {
                             let interval = setInterval(() => {
                                 if (count < 95) { count += 5; $el.textContent = count + '%'; }
                                 else { clearInterval(interval); $el.textContent = '95%'; }
                             }, 30);
                         }
                     })">
                    0%
                </div>
                <p class="text-gray-400 text-sm md:text-base">Satisfacción del Cliente</p>
            </div>

            {{-- Stat 3 --}}
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
                     x-data="{ count: 0 }"
                     x-init="window.addEventListener('scroll', () => {
                         if ($el.getBoundingClientRect().top < window.innerHeight && count === 0) {
                             let interval = setInterval(() => {
                                 if (count < 10) { count++; $el.textContent = count + '+'; }
                                 else { clearInterval(interval); $el.textContent = '10+'; }
                             }, 100);
                         }
                     })">
                    0+
                </div>
                <p class="text-gray-400 text-sm md:text-base">Años de Experiencia</p>
            </div>

            {{-- Stat 4 --}}
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
                     x-data="{ count: 0 }"
                     x-init="window.addEventListener('scroll', () => {
                         if ($el.getBoundingClientRect().top < window.innerHeight && count === 0) {
                             let interval = setInterval(() => {
                                 if (count < 50) { count += 2; $el.textContent = count + '+'; }
                                 else { clearInterval(interval); $el.textContent = '50+'; }
                             }, 40);
                         }
                     })">
                    0+
                </div>
                <p class="text-gray-400 text-sm md:text-base">Clientes Satisfechos</p>
            </div>
        </div>
    </div>
</section>

