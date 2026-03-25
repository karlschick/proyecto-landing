<?php $__env->startSection('title', 'Página no encontrada'); ?>

<?php $__env->startSection('content'); ?>
<section class="min-h-screen flex flex-col items-center justify-center bg-gray-900 text-white text-center">
    <h1 class="text-6xl font-bold mb-4">404</h1>
    <p class="text-xl mb-6">La página que buscas no existe o ha sido movida.</p>
    <a href="<?php echo e(route('home')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
        Volver al inicio
    </a>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/errors/404.blade.php ENDPATH**/ ?>