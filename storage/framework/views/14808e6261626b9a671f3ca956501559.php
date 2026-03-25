<?php $__env->startSection('title', 'Servicios'); ?>
<?php $__env->startSection('page-title', 'Gestión de Servicios'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-bold text-gray-800">Servicios</h3>
        <p class="text-gray-600 mt-1">Administra los servicios que ofreces</p>
    </div>
    <a href="<?php echo e(route('admin.services.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Servicio
    </a>
</div>

<?php if($services->count() > 0): ?>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icono</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción Corta</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <?php echo e($service->order); ?>

                </td>
                <td class="px-6 py-4 whitespace-nowrap text-2xl">
                    <?php echo e($service->icon ?? '📋'); ?>

                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900"><?php echo e($service->title); ?></div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-600 max-w-xs truncate">
                        <?php echo e($service->short_description ?? Str::limit($service->description, 60)); ?>

                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($service->is_active): ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Activo
                        </span>
                    <?php else: ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            Inactivo
                        </span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="<?php echo e(route('admin.services.edit', $service)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                        Editar
                    </a>
                    <form action="<?php echo e(route('admin.services.destroy', $service)); ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este servicio?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="mt-6">
    <?php echo e($services->links()); ?>

</div>
<?php else: ?>
<div class="bg-white rounded-lg shadow p-12 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay servicios creados</h3>
    <p class="text-gray-500 mb-6">Comienza agregando tu primer servicio</p>
    <a href="<?php echo e(route('admin.services.create')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        Crear Primer Servicio
    </a>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\Fitness\resources\views/admin/services/index.blade.php ENDPATH**/ ?>