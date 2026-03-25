<div x-show="activeTab === 'identity'" class="space-y-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Identidad de Marca</h3>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Sitio *</label>
            <input type="text" name="site_name" value="<?php echo e(old('site_name', $settings->site_name)); ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            <?php $__errorArgs = ['site_name'];
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
            <label class="block text-sm font-medium text-gray-700 mb-2">Slogan</label>
            <input type="text" name="site_slogan" value="<?php echo e(old('site_slogan', $settings->site_slogan)); ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
            <?php if($settings->logo): ?>
                <div class="mb-2">
                    <img src="<?php echo e($settings->getLogoUrl()); ?>" alt="Logo actual" class="h-20 object-contain">
                </div>
            <?php endif; ?>
            <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg,image/svg+xml"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, SVG. Máx: 2MB</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
            <?php if($settings->favicon): ?>
                <div class="mb-2">
                    <img src="<?php echo e($settings->getFaviconUrl()); ?>" alt="Favicon actual" class="h-8 object-contain">
                </div>
            <?php endif; ?>
            <input type="file" name="favicon" accept="image/x-icon,image/png"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Formatos: ICO, PNG. Máx: 1MB</p>
        </div>
    </div>
</div>
<?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/settings/partials/identity.blade.php ENDPATH**/ ?>