<div x-data="{ open: false }" class="relative flex items-center justify-center">
    <button type="button" @click="open = !open"
        class="relative p-2 text-gray-400 transition-colors duration-150 focus:outline-none focus-visible:ring focus-visible:ring-indigo-300 group">
        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'notification','class' => 'inline w-6 h-6 dark:text-gray-400 text-gray-700 group-hover:text-indigo-500 transition-colors duration-150']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notification','class' => 'inline w-6 h-6 dark:text-gray-400 text-gray-700 group-hover:text-indigo-500 transition-colors duration-150']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $attributes = $__attributesOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__attributesOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $component = $__componentOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__componentOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>

        <?php
            $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
        ?>

        <?php if($unreadCount > 0): ?>
        <span class="absolute top-1.5 right-1.5 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center leading-none ring-2 ring-white dark:ring-gray-900">
            <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

        </span>
        <?php endif; ?>
    </button>

    <div x-show="open"
        x-cloak
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute top-full right-0 mt-2 w-80 rounded-xl shadow-xl bg-white dark:bg-gray-900 ring-1 ring-black/10 dark:ring-white/10 z-[100]"
    >
        
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-800">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Notifications</span>
            <?php if(auth()->check() && $unreadCount > 0): ?>
            <form action="<?php echo e(route('notifications.markAllAsRead')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-xs text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition-colors">
                    Mark all read
                </button>
            </form>
            <?php endif; ?>
        </div>

        
        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-gray-800">
            <?php if(auth()->check()): ?>
                <?php $__empty_1 = true; $__currentLoopData = auth()->user()->unreadNotifications->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $nData    = $notification->data;
                    $isChat   = ($nData['type'] ?? '') === 'chat_message';
                    $label    = $nData['message'] ?? 'New notification';
                    $preview  = $nData['preview'] ?? null;
                ?>
                <form action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors flex items-start gap-3 group">
                        
                        <div class="flex-shrink-0 mt-0.5">
                            <?php if($isChat): ?>
                            <div class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                                <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'chat','class' => 'w-4 h-4 text-indigo-500 dark:text-indigo-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chat','class' => 'w-4 h-4 text-indigo-500 dark:text-indigo-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $attributes = $__attributesOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__attributesOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $component = $__componentOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__componentOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
                            </div>
                            <?php else: ?>
                            <div class="w-9 h-9 rounded-full bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'notification','class' => 'w-4 h-4 text-amber-500 dark:text-amber-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notification','class' => 'w-4 h-4 text-amber-500 dark:text-amber-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $attributes = $__attributesOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__attributesOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $component = $__componentOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__componentOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors"><?php echo e($label); ?></p>
                            <?php if($preview): ?>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5 italic">"<?php echo e($preview); ?>"</p>
                            <?php endif; ?>
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                        </div>
                        
                        <div class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0 mt-2"></div>
                    </button>
                </form>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="flex flex-col items-center py-10">
                    <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'notification','class' => 'w-6 h-6 text-gray-400 dark:text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'notification','class' => 'w-6 h-6 text-gray-400 dark:text-gray-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $attributes = $__attributesOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__attributesOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $component = $__componentOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__componentOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">All caught up!</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">No new notifications</p>
                </div>
                <?php endif; ?>
            <?php else: ?>
            <div class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                Please log in to see your notifications.
            </div>
            <?php endif; ?>
        </div>

        
        <?php if(auth()->check()): ?>
        <div class="px-4 py-2.5 border-t border-gray-100 dark:border-gray-800">
            <a href="<?php echo e(route('notifications.index')); ?>"
               class="text-xs text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 font-medium transition-colors">
                View all notifications →
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\Year_IV\Semester II\pp\ShopExpress\resources\views/layouts/partials/nav-notification.blade.php ENDPATH**/ ?>