<?php $__env->startSection('title', 'Tienda'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-200">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-black to-[rgb(245,245,0)] text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Nuestra Tienda</h1>
            <p class="text-blue-100">SELECCIONA TU PRODUCTO Y TE LLEGARA EL LINK DE DESCARGA</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar - Filtros -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Filtros</h3>

                    <form method="GET" action="<?php echo e(route('shop.index')); ?>">
                        <!-- Búsqueda -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                   placeholder="Buscar productos..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Categorías -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categorías</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="category" value=""
                                           <?php echo e(request('category') == '' ? 'checked' : ''); ?>

                                           class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Todas</span>
                                </label>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="<?php echo e($category->id); ?>"
                                           <?php echo e(request('category') == $category->id ? 'checked' : ''); ?>

                                           class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">
                                        <?php echo e($category->name); ?>

                                        <span class="text-gray-400">(<?php echo e($category->products_count); ?>)</span>
                                    </span>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Ordenamiento -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                            <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Más recientes</option>
                                <option value="featured" <?php echo e(request('sort') == 'featured' ? 'selected' : ''); ?>>Destacados</option>
                                <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Precio: Menor a Mayor</option>
                                <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Precio: Mayor a Menor</option>
                                <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Nombre A-Z</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                Aplicar Filtros
                            </button>
                            <?php if(request()->hasAny(['search', 'category', 'sort'])): ?>
                            <a href="<?php echo e(route('shop.index')); ?>" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                                Limpiar Filtros
                            </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Productos -->
            <main class="flex-1">
                <!-- Productos Destacados -->
                <?php if($featuredProducts->count() > 0 && !request()->hasAny(['search', 'category', 'sort'])): ?>
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Productos Destacados</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            <a href="<?php echo e(route('shop.show', $product->slug)); ?>" class="block">
                                <div class="relative aspect-square overflow-hidden">
                                    <img src="<?php echo e($product->getFeaturedImageUrl()); ?>"
                                         alt="<?php echo e($product->name); ?>"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    <?php if($product->hasDiscount()): ?>
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                        -<?php echo e($product->getDiscountPercentage()); ?>%
                                    </div>
                                    <?php endif; ?>
                                    <?php if($product->is_featured): ?>
                                    <div class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                                        ⭐ Destacado
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                        <?php echo e($product->name); ?>

                                    </h3>
                                    <?php if($product->short_description): ?>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e($product->short_description); ?></p>
                                    <?php endif; ?>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <?php if($product->hasDiscount()): ?>
                                            <p class="text-sm text-gray-500 line-through">$<?php echo e(number_format($product->compare_price, 0, ',', '.')); ?></p>
                                            <?php endif; ?>
                                            <p class="text-xl font-bold text-blue-600">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                                        </div>
                                        <?php if($product->isInStock()): ?>
                                        <span class="text-xs text-green-600 font-medium">En stock</span>
                                        <?php else: ?>
                                        <span class="text-xs text-red-600 font-medium">Agotado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Todos los Productos -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">
                            <?php if(request('search')): ?>
                                Resultados para "<?php echo e(request('search')); ?>"
                            <?php elseif(request('category')): ?>
                                <?php echo e($categories->firstWhere('id', request('category'))->name ?? 'Productos'); ?>

                            <?php else: ?>
                                Todos los Productos
                            <?php endif; ?>
                        </h2>
                        <p class="text-gray-600"><?php echo e($products->total()); ?> productos</p>
                    </div>

                    <?php if($products->count() > 0): ?>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            <a href="<?php echo e(route('shop.show', $product->slug)); ?>" class="block">
                                <div class="relative aspect-square overflow-hidden">
                                    <img src="<?php echo e($product->getFeaturedImageUrl()); ?>"
                                         alt="<?php echo e($product->name); ?>"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    <?php if($product->hasDiscount()): ?>
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                        -<?php echo e($product->getDiscountPercentage()); ?>%
                                    </div>
                                    <?php endif; ?>
                                    <?php if($product->is_featured): ?>
                                    <div class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                                        ⭐ Destacado
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4">
                                    <?php if($product->category): ?>
                                    <p class="text-xs text-gray-500 mb-1"><?php echo e($product->category->name); ?></p>
                                    <?php endif; ?>
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                        <?php echo e($product->name); ?>

                                    </h3>
                                    <?php if($product->short_description): ?>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e($product->short_description); ?></p>
                                    <?php endif; ?>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <?php if($product->hasDiscount()): ?>
                                            <p class="text-sm text-gray-500 line-through">$<?php echo e(number_format($product->compare_price, 0, ',', '.')); ?></p>
                                            <?php endif; ?>
                                            <p class="text-xl font-bold text-blue-600">$<?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                                        </div>
                                        <?php if($product->isInStock()): ?>
                                        <span class="text-xs text-green-600 font-medium">En stock</span>
                                        <?php else: ?>
                                        <span class="text-xs text-red-600 font-medium">Agotado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8">
                        <?php echo e($products->appends(request()->query())->links()); ?>

                    </div>
                    <?php else: ?>
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No se encontraron productos</h3>
                        <p class="text-gray-500 mb-6">Intenta con otros criterios de búsqueda</p>
                        <a href="<?php echo e(route('shop.index')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                            Ver todos los productos
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('landing.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/landing/shop/index.blade.php ENDPATH**/ ?>