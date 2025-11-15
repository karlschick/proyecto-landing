<section class="py-5 bg-black text-white flex items-center justify-center relative overflow-hidden" style="height: 13vh;">
  {{-- Efecto de reflejo amarillo en el fondo --}}
  <div class="stats-shine absolute inset-0 pointer-events-none"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
    <div class="flex flex-wrap justify-center items-center gap-8 text-center">

      {{-- Stat 1 --}}
      {{-- <div>
        <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
             x-data="{ count: 0 }"
             x-init="window.addEventListener('scroll', () => {
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
      </div> --}}

      {{-- Stat 2 --}}
      {{-- <div>
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
      </div> --}}

      {{-- Stat 3 --}}
      <div>
        <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
             x-data="{ count: 0 }"
             x-init="window.addEventListener('scroll', () => {
                 if ($el.getBoundingClientRect().top < window.innerHeight && count === 0) {
                     let interval = setInterval(() => {
                         if (count < 10) { count++; $el.textContent = count + '+'; }
                         else { clearInterval(interval); $el.textContent = '20+'; }
                     }, 200);
                 }
             })">
          0+
        </div>
        <p class="text-gray-400 text-sm md:text-base">Años de Experiencia</p>
      </div>

      {{-- Stat 4 --}}
      <div>
        <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
             x-data="{ count: 0 }"
             x-init="window.addEventListener('scroll', () => {
                 if ($el.getBoundingClientRect().top < window.innerHeight && count === 0) {
                     let interval = setInterval(() => {
                         if (count < 50) { count += 2; $el.textContent = count + '+'; }
                         else { clearInterval(interval); $el.textContent = '1000+'; }
                     }, 200);
                 }
             })">
          0+
        </div>
        <p class="text-gray-400 text-sm md:text-base">Clientes Satisfechos</p>
      </div>

    </div>
  </div>
</section>

<style>
/* Efecto de reflejo amarillo continuo en el fondo */
@keyframes shine-sweep {
  0% {
    transform: translateX(-100%) skewX(-15deg);
  }
  100% {
    transform: translateX(200%) skewX(-15deg);
  }
}

.stats-shine::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 50%;
  height: 100%;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(245, 245, 0, 0.1),
    rgba(245, 245, 0, 0.2),
    rgba(245, 245, 0, 0.1),
    transparent
  );
  animation: shine-sweep 4s ease-in-out infinite;
}
</style>
