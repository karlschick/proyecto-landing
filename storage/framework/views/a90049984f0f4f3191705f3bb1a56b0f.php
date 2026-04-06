<?php $__env->startSection('title', 'Testimonios'); ?>
<?php $__env->startSection('page-title', 'Gestión de Testimonios'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-bold text-gray-800">Testimonios</h3>
        <p class="text-gray-600 mt-1">Administra las opiniones de tus clientes</p>
    </div>
    <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Testimonio
    </a>
</div>

<?php if($testimonials->count() > 0): ?>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
        <!-- Header con foto y rating -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <?php if($testimonial->client_photo): ?>
                    <img src="<?php echo e($testimonial->getPhotoUrl()); ?>" alt="<?php echo e($testimonial->client_name); ?>" class="w-12 h-12 rounded-full object-cover">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                        <?php echo e($testimonial->getInitials()); ?>

                    </div>
                <?php endif; ?>
                <div>
                    <h4 class="font-semibold text-gray-800"><?php echo e($testimonial->client_name); ?></h4>
                    <?php if($testimonial->client_position): ?>
                        <p class="text-xs text-gray-500"><?php echo e($testimonial->client_position); ?></p>
                    <?php endif; ?>
                    <?php if($testimonial->client_company): ?>
                        <p class="text-xs text-gray-500"><?php echo e($testimonial->client_company); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Rating -->
        <div class="flex items-center gap-1 mb-3">
            <?php for($i = 1; $i <= 5; $i++): ?>
                <?php if($i <= $testimonial->rating): ?>
                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                <?php else: ?>
                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                    </svg>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

        <!-- Testimonio -->
        <p class="text-gray-600 text-sm mb-4 line-clamp-4"><?php echo e($testimonial->testimonial); ?></p>

        <!-- Badges -->
        <div class="flex items-center gap-2 mb-4">
            <?php if($testimonial->is_featured): ?>
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    ⭐ Destacado
                </span>
            <?php endif; ?>
            <?php if($testimonial->is_active): ?>
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    Activo
                </span>
            <?php else: ?>
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                    Inactivo
                </span>
            <?php endif; ?>
        </div>

        <!-- Acciones -->
        <div class="flex items-center justify-between pt-4 border-t">
            <span class="text-xs text-gray-500">Orden: <?php echo e($testimonial->order); ?></span>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.testimonials.edit', $testimonial)); ?>" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                    Editar
                </a>
                <form action="<?php echo e(route('admin.testimonials.destroy', $testimonial)); ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este testimonio?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-6">
    <?php echo e($testimonials->links()); ?>

</div>
<?php else: ?>
<div class="bg-white rounded-lg shadow p-12 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay testimonios creados</h3>
    <p class="text-gray-500 mb-6">Comienza agregando tu primer testimonio</p>
    <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        Crear Primer Testimonio
    </a>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/testimonials/index.blade.php ENDPATH**/ ?>