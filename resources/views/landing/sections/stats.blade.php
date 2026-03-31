{{--
    resources/views/landing/sections/stats.blade.php
    Los stats vienen de la variable $stats (colección de App\Models\Stat)
    pasada desde LandingController.
--}}

@if($stats->isNotEmpty())
<section class="py-5 bg-black text-white flex items-center justify-center relative overflow-hidden" style="height: 13vh;">

    {{-- Efecto de reflejo amarillo en el fondo --}}
    <div class="stats-shine absolute inset-0 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="flex flex-wrap justify-center items-center gap-8 text-center">

            @foreach($stats as $stat)
            <div>
                <div class="text-4xl md:text-5xl font-bold text-accent mb-2"
                     x-data="{ count: 0, done: false }"
                     x-init="window.addEventListener('scroll', () => {
                         if (!done && $el.getBoundingClientRect().top < window.innerHeight) {
                             done = true;
                             let interval = setInterval(() => {
                                 if (count < {{ $stat->target }}) {
                                     count += {{ $stat->step }};
                                     if (count > {{ $stat->target }}) count = {{ $stat->target }};
                                     $el.textContent = count + '{{ $stat->suffix }}';
                                 } else {
                                     clearInterval(interval);
                                     $el.textContent = '{{ $stat->value }}';
                                 }
                             }, {{ $stat->duration }});
                         }
                     })">
                    0{{ $stat->suffix }}
                </div>
                <p class="text-gray-400 text-sm md:text-base">{{ $stat->label }}</p>
            </div>
            @endforeach

        </div>
    </div>
</section>
@endif

<style>
@keyframes shine-sweep {
    0%   { transform: translateX(-100%) skewX(-15deg); }
    100% { transform: translateX(200%) skewX(-15deg); }
}
.stats-shine::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 50%; height: 100%;
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
