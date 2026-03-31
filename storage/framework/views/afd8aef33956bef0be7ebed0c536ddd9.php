<?php $__env->startSection('title', 'Configuración General'); ?>
<?php $__env->startSection('page-title', 'Configuración General'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow" x-data="{ activeTab: 'identity' }">

    <!-- Navigation Tabs -->
    <?php echo $__env->make('admin.settings.partials.tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Tab Content: Identidad -->
        <?php echo $__env->make('admin.settings.partials.identity', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Tab Content: Colores -->
        <?php echo $__env->make('admin.settings.partials.colors', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Tab Content: Secciones -->
        <?php echo $__env->make('admin.settings.partials.sections', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Tab Content: Navbar -->
        <?php echo $__env->make('admin.settings.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Tab Content: Redes Sociales -->
        <?php echo $__env->make('admin.settings.partials.social', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Tab Content: Contacto -->
        <?php echo $__env->make('admin.settings.partials.contact', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Tab Content: Footer -->
        <?php echo $__env->make('admin.settings.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Tab Content: SEO -->
        <?php echo $__env->make('admin.settings.partials.seo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Action Buttons -->
        <?php echo $__env->make('admin.settings.partials.actions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>