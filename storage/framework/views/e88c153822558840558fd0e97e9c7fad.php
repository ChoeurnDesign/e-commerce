<button aria-haspopup="true" aria-expanded="false" aria-label="View latest reports"
    class="relative p-1 text-gray-500 bg-gray-600 dark:text-gray-100 hover:text-gray-700 dark:hover:text-white z rounded-full"
    @click="notifOpen = !notifOpen" x-data="{ notifOpen: false }" :aria-expanded="notifOpen.toString()">

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

    <?php if(isset($unreadCount) && $unreadCount > 0): ?>
    <span class="absolute top-0 right-0 translate-x-1/3 -translate-y-1/3
             bg-red-500 text-white text-[10px] font-bold rounded-full
             h-5 w-5 flex items-center justify-center shadow">
        <?php echo e($unreadCount); ?>

    </span>
    <?php endif; ?>

    <div x-show="notifOpen" @click.away="notifOpen = false" x-transition
        class="absolute right-0 mt-2 w-72 bg-white dark:bg-[#23263a] rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 transition-colors"
        style="display: none;">
        <div class="py-2 px-4 border-b border-gray-100 dark:border-[#23263a] font-semibold">
            Latest Reports
        </div>
        <div class="max-h-60 overflow-y-auto">
            <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('admin.reports.show', $report->id)); ?>"
                class="block px-4 py-2 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#262c47] transition-colors">
                <div class="flex items-center">
                    <span class="font-medium truncate"><?php echo e($report->title); ?></span>
                    <?php if(!$report->is_read): ?>
                    <span class="ml-2 h-2 w-2 rounded-full bg-red-500 inline-block"></span>
                    <?php endif; ?>
                    <span class="ml-auto text-xs text-gray-400"><?php echo e($report->created_at->diffForHumans()); ?></span>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-4 py-2 text-gray-400">No reports found.</div>
            <?php endif; ?>
        </div>
    </div>
</button>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/partials/noti.blade.php ENDPATH**/ ?>