<?php $__env->startSection('title', 'Inicio'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php if($settings->hero_enabled): ?>
        <?php echo $__env->make('landing.sections.hero', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php if($settings->stats_enabled ?? true): ?>
        <?php echo $__env->make('landing.sections.stats', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php if($settings->about_enabled): ?>
        <?php echo $__env->make('landing.sections.about', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php if($settings->features_enabled ?? true): ?>
        <?php echo $__env->make('landing.sections.features', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php if($settings->services_enabled): ?>
        <?php echo $__env->make('landing.sections.services', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php echo $__env->make('landing.sections.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php if($settings->products_enabled): ?>
        <?php echo $__env->make('landing.sections.projects', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>


    
    <?php if($settings->gallery_enabled): ?>
        <?php echo $__env->make('landing.sections.gallery', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php if($settings->cta_enabled ?? true): ?>
        <?php echo $__env->make('landing.sections.cta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

        
    <?php if($settings->testimonials_enabled): ?>
        <?php echo $__env->make('landing.sections.testimonials', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <?php if($settings->contact_enabled): ?>
        <?php echo $__env->make('landing.sections.contact', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('landing.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/landing/index.blade.php ENDPATH**/ ?>