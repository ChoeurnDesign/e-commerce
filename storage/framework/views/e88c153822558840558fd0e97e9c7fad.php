<button
    aria-haspopup="true"
    aria-expanded="false"
    aria-label="View latest reports"
    class="relative p-1 text-gray-500 bg-blue-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-full"
    @click="notifOpen = !notifOpen"
    x-data="{ notifOpen: false }"
    :aria-expanded="notifOpen.toString()"
>
    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
    </svg>
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