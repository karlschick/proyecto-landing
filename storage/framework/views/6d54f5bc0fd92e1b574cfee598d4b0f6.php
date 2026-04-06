

<?php if($stats->isNotEmpty()): ?>

<?php
    $bgColor     = $settings->stats_bg_color     ?? '#000000';
    $numberColor = $settings->stats_number_color ?? '#f5f500';
?>

<section class="py-5 text-white flex items-center justify-center relative overflow-hidden"
         style="height: 13vh; background-color: <?php echo e($bgColor); ?>;">

    
    <div class="stats-shine absolute inset-0 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="flex flex-wrap justify-center items-center gap-8 text-center">

            <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div class="text-4xl md:text-5xl font-bold mb-2"
                     style="color: <?php echo e($numberColor); ?>;"
                     x-data="{ count: 0, done: false }"
                     x-init="window.addEventListener('scroll', () => {
                         if (!done && $el.getBoundingClientRect().top < window.innerHeight) {
                             done = true;
                             let interval = setInterval(() => {
                                 if (count < <?php echo e($stat->target); ?>) {
                                     count += <?php echo e($stat->step); ?>;
                                     if (count > <?php echo e($stat->target); ?>) count = <?php echo e($stat->target); ?>;
                                     $el.textContent = count + '<?php echo e($stat->suffix); ?>';
                                 } else {
                                     clearInterval(interval);
                                     $el.textContent = '<?php echo e($stat->value); ?>';
                                 }
                             }, <?php echo e($stat->duration); ?>);
                         }
                     })">
                    0<?php echo e($stat->suffix); ?>

                </div>
                <p class="text-gray-400 text-sm md:text-base"><?php echo e($stat->label); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</section>
<?php endif; ?>

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
<?php /**PATH D:\htdocs\skubox\landing\resources\views/landing/sections/stats.blade.php ENDPATH**/ ?>