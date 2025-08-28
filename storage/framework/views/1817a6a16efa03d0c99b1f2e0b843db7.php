<?php $__env->startSection('title', 'Settings Management'); ?>

<?php $__env->startSection('content'); ?>
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto p-8 min-h-screen font-sans">

    <?php echo $__env->make('admin.settings.partials.banner-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.settings.partials.general-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.settings.partials.storefront-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.settings.partials.payment-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.settings.partials.policies-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>