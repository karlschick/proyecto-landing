<?php $__env->startSection('title', 'Sección Nosotros'); ?>
<?php $__env->startSection('page-title', 'Editor - Sección Nosotros'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <form action="<?php echo e(route('admin.about.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="bg-white rounded-xl shadow p-6 space-y-5">

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                <input type="text" name="about_title"
                       value="<?php echo e(old('about_title', $settings->about_title)); ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="about_description" rows="5"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?php echo e(old('about_description', $settings->about_description)); ?></textarea>
            </div>

            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Imagen</label>
                <?php if($settings->about_image): ?>
                    <div class="mb-3">
                        <img src="<?php echo e($settings->getAboutImageUrl()); ?>" alt="Imagen About"
                             class="h-40 object-cover rounded-lg shadow">
                        <p class="text-xs text-gray-500 mt-1">Imagen actual</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="about_image" accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. Máx: 5MB.</p>
            </div>

            
            <div class="pt-2">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                    Guardar cambios
                </button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\Fitness\resources\views/admin/about/index.blade.php ENDPATH**/ ?>