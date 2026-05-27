<a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2 min-w-0">
    <div class="w-12 h-12 rounded-full bg-white overflow-hidden flex items-center justify-center shrink-0">
        <?php if(!empty($settings['store_logo'])): ?>
            <img
                src="<?php echo e(asset($settings['store_logo'])); ?>"
                alt="Logo"
                class="w-full h-full object-cover object-center"
            />
        <?php endif; ?>
    </div>

    <span class="text-xl font-bold text-[#8b5cf6] dark:text-[#a78bfa] truncate">
        <?php echo e($settings['store_name']); ?>

    </span>
</a><?php /**PATH D:\Year_IV\Semester II\pp\ShopExpress\resources\views/layouts/partials/nav-logo.blade.php ENDPATH**/ ?>