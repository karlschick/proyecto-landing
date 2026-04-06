<?php $__env->startSection('title', 'Editar Testimonio'); ?>
<?php $__env->startSection('page-title', 'Editar Testimonio'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?php echo e(route('admin.testimonials.update', $testimonial)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="space-y-6">
                <!-- Nombre del Cliente -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Cliente *</label>
                    <input type="text" name="client_name" value="<?php echo e(old('client_name', $testimonial->client_name)); ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Cargo y Empresa -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cargo/Posición</label>
                        <input type="text" name="client_position" value="<?php echo e(old('client_position', $testimonial->client_position)); ?>"
                               placeholder="CEO, Director, etc."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php $__errorArgs = ['client_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                        <input type="text" name="client_company" value="<?php echo e(old('client_company', $testimonial->client_company)); ?>"
                               placeholder="Nombre de la empresa"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php $__errorArgs = ['client_company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Testimonio -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Testimonio *</label>
                    <textarea name="testimonial" rows="6" required
                              placeholder="Escribe aquí el testimonio del cliente..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?php echo e(old('testimonial', $testimonial->testimonial)); ?></textarea>
                    <?php $__errorArgs = ['testimonial'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Foto del Cliente -->
                <div x-data="{ selectedImage: '<?php echo e($testimonial->client_photo ?? ''); ?>' }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto del Cliente</label>

                    <?php if($testimonial->client_photo): ?>
                        <div class="mb-3">
                            <img src="<?php echo e($testimonial->getPhotoUrl()); ?>" alt="<?php echo e($testimonial->client_name); ?>" class="h-24 w-24 rounded-full object-cover shadow">
                            <p class="text-xs text-gray-600 mt-1">Foto actual: <?php echo e($testimonial->client_photo); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Galería de imágenes existentes -->
                    <?php
                        $testimonialsImagesPath = public_html_path('images/testimonials');
                        $testimonialsImages = [];
                        if (is_dir($testimonialsImagesPath)) {
                            $files = glob($testimonialsImagesPath . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
                            foreach ($files as $file) {
                                $testimonialsImages[] = 'testimonials/' . basename($file);
                            }
                        }
                    ?>

                    <?php if(count($testimonialsImages) > 0): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                📁 Fotos guardadas (<?php echo e(count($testimonialsImages)); ?>) — haz clic para seleccionar
                            </label>
                            <div class="grid grid-cols-3 md:grid-cols-4 gap-2 max-h-64 overflow-y-auto p-2 border border-gray-200 rounded-lg bg-white">
                                <?php $__currentLoopData = $testimonialsImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="relative cursor-pointer group"
                                         @click="selectedImage = '<?php echo e($img); ?>'">
                                        <img src="<?php echo e(asset('images/' . $img)); ?>"
                                             alt="<?php echo e(basename($img)); ?>"
                                             class="w-full h-20 object-cover rounded-lg border-2 transition"
                                             :class="selectedImage === '<?php echo e($img); ?>' ? 'border-blue-500 ring-2 ring-blue-300' : 'border-gray-200 group-hover:border-blue-300'">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition"></div>
                                        <?php if($testimonial->client_photo === $img): ?>
                                            <span class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-1 rounded">Actual</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <input type="hidden" name="image_selected" :value="selectedImage">
                            <p class="text-xs text-gray-500 mt-1" x-show="selectedImage">
                                ✅ Seleccionada: <span x-text="selectedImage" class="font-medium text-blue-600"></span>
                            </p>
                        </div>
                    <?php endif; ?>

                    <label class="block text-sm font-medium text-gray-700 mb-1">O subir nueva foto</label>
                    <input type="file" name="client_photo" accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. Máx: 2MB. Deja en blanco para mantener la foto actual.</p>
                    <?php $__errorArgs = ['client_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Calificación *</label>
                    <div class="flex items-center gap-2">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="rating" value="<?php echo e($i); ?>"
                                       <?php echo e(old('rating', $testimonial->rating) == $i ? 'checked' : ''); ?>

                                       class="sr-only peer">
                                <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-300 transition fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            </label>
                        <?php endfor; ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Selecciona de 1 a 5 estrellas</p>
                    <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Orden, Destacado y Estado -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Orden</label>
                        <input type="number" name="order" value="<?php echo e(old('order', $testimonial->order)); ?>" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Orden de visualización (menor número = aparece primero)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opciones</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                       <?php echo e(old('is_featured', $testimonial->is_featured) ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <label for="is_featured" class="ml-2 text-gray-700">Testimonio Destacado</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                       <?php echo e(old('is_active', $testimonial->is_active) ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 text-gray-700">Testimonio Activo</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between pt-6 border-t mt-8">
                <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="text-gray-600 hover:text-gray-800 font-medium">
                    ← Volver a la lista
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Actualizar Testimonio
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/testimonials/edit.blade.php ENDPATH**/ ?>