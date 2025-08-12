<a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2">
    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white">
        <?php if(!empty($settings['store_logo'])): ?>
            <img
                src="<?php echo e(asset($settings['store_logo'])); ?>"
                alt="Logo"
                class="w-full h-full object-contain rounded-full border border-violet-400"
            />
        <?php endif; ?>
    </div>
    <span class="text-xl font-bold text-[#8b5cf6] dark:text-[#a78bfa]">
        <?php echo e($settings['store_name']); ?>

    </span>
</a>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/nav-logo.blade.php ENDPATH**/ ?>