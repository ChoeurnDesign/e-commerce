<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="relative p-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-300 dark:hover:bg-[#2e1065] transition-colors focus:outline-none">
        <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'notification','class' => 'inline w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notification','class' => 'inline w-5 h-5 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
        <?php
        $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
        ?>
        <?php if($unreadCount > 0): ?>
        <span
            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none">
            <?php echo e($unreadCount); ?>

        </span>
        <?php endif; ?>
    </button>
    <!-- Dropdown content -->
    <div x-show="open" x-cloak @click.away="open = false"
        class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-[#181b23] ring-1 ring-black ring-opacity-5 z-50"
        x-cloak>
        <div class="py-2 px-4 max-h-96 overflow-y-auto">
            <?php if(auth()->check()): ?>
            <?php $__empty_1 = true; $__currentLoopData = auth()->user()->unreadNotifications->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <form action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>" method="POST" class="mb-2">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full text-left bg-transparent px-2 py-1 rounded cursor-pointer">
                    <?php echo e($notification->data['message']); ?>

                </button>
            </form>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-gray-500 py-4 text-center">No new notifications</div>
            <?php endif; ?>
            <?php else: ?>
            <div class="text-gray-500 py-4 text-center">Please log in to see your notifications.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/nav-notification.blade.php ENDPATH**/ ?>