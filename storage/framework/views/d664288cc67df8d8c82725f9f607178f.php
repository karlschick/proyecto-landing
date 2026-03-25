<?php $__env->startSection('title', 'Productos'); ?>
<?php $__env->startSection('page-title', 'Gestión de Productos'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Productos</h3>
            <p class="text-gray-600 mt-1">Administra tu inventario de productos</p>
        </div>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Producto
        </a>
    </div>

    <!-- Filtros -->
    <div class="mt-6 bg-white rounded-lg shadow p-4">
        <form method="GET" class="grid md:grid-cols-4 gap-4">
            <!-- Búsqueda -->
            <div>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Buscar productos..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Categoría -->
            <div>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas las categorías</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Estado -->
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos los estados</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Activos</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactivos</option>
                </select>
            </div>

            <!-- Stock -->
            <div>
                <select name="stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todo el stock</option>
                    <option value="in_stock" <?php echo e(request('stock') == 'in_stock' ? 'selected' : ''); ?>>En stock</option>
                    <option value="low_stock" <?php echo e(request('stock') == 'low_stock' ? 'selected' : ''); ?>>Stock bajo</option>
                    <option value="out_of_stock" <?php echo e(request('stock') == 'out_of_stock' ? 'selected' : ''); ?>>Sin stock</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    Filtrar
                </button>
                <?php if(request()->hasAny(['search', 'category', 'status', 'stock'])): ?>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    Limpiar
                </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php if($products->count() > 0): ?>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                <img src="<?php echo e($product->getFeaturedImageUrl()); ?>" alt="<?php echo e($product->name); ?>" class="h-16 w-16 rounded object-cover">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($product->name); ?></div>
                                <div class="text-sm text-gray-500">SKU: <?php echo e($product->sku); ?></div>
                                <?php if($product->is_featured): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                        ⭐ Destacado
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <?php echo e($product->category->name ?? 'Sin categoría'); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></div>
                        <?php if($product->hasDiscount()): ?>
                            <div class="text-sm text-gray-500 line-through">$<?php echo e(number_format($product->compare_price, 0, ',', '.')); ?></div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                -<?php echo e($product->getDiscountPercentage()); ?>%
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($product->track_quantity): ?>
                            <?php if($product->quantity > 10): ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <?php echo e($product->quantity); ?> unidades
                                </span>
                            <?php elseif($product->quantity > 0): ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <?php echo e($product->quantity); ?> unidades
                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Sin stock
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Siempre disponible
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if($product->is_active): ?>
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
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                            Editar
                        </a>
                        <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
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
</div>

<div class="mt-6">
    <?php echo e($products->appends(request()->query())->links()); ?>

</div>
<?php else: ?>
<div class="bg-white rounded-lg shadow p-12 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay productos</h3>
    <p class="text-gray-500 mb-6">Comienza agregando tu primer producto</p>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        Crear Primer Producto
    </a>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/products/index.blade.php ENDPATH**/ ?>