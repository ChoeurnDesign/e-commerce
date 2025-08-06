<div class="flex flex-col w-full">
    <!-- Top Nav: Logo + Links -->
    <div class="flex items-center h-16 w-full border-b border-gray-200 dark:border-gray-800">
        <?php echo $__env->make('layouts.partials.nav-logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Desktop Links -->
        <div class="hidden md:flex space-x-4 ml-8">
            <?php echo $__env->make('layouts.partials.nav-desktop-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="hidden md:flex ml-auto space-x-4 items-center">
            <?php echo $__env->make('layouts.partials.nav-faq-help', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Search bar: Only show on mobile (below md) -->
        <div class="md:hidden mx-4 pr-4 flex-1 justify-center ml-6">
            <?php echo $__env->make('layouts.partials.nav-search', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- Bottom Nav: Search + Global Actions + Hamburger -->
    <div class="flex items-center justify-between h-16 w-full">
        <div class="hidden md:flex flex-1 items-center">
            <?php echo $__env->make('layouts.partials.nav-search', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="md:hidden flex-1 justify-start ml-auto space-x-4">
            <?php echo $__env->make('layouts.partials.nav-faq-help', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="flex items-center">
            <!-- Language/Currency -->
            <div x-data="{ open: false }" class="relative">
                <?php echo $__env->make('layouts.partials.nav-language-currency', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <div x-data="{ open: false }" class="relative">
                <?php echo $__env->make('layouts.partials.nav-notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div class="flex items-center">
                <?php echo $__env->make('layouts.partials.nav-cart-wishlist', [
                    'cartCount' => $cartCount ?? 0,
                    'wishlistCount' => $wishlistCount ?? 0
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <!-- User Dropdown -->
            <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                <?php echo $__env->make('layouts.partials.nav-user-dropdown', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/desktop-nav.blade.php ENDPATH**/ ?>