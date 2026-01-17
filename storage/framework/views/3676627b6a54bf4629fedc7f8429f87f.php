<div class="flex flex-col w-full">
    <!-- Top Nav: Logo + Links -->
    <div class="flex items-center h-16 w-full border-b border-gray-200 bg-gray-800 dark:bg-gray-900 dark:border-gray-800">
        <?php echo $__env->make('layouts.partials.nav-logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Desktop Links -->
        <div class="hidden lg:flex space-x-4 ml-8">
            <?php echo $__env->make('layouts.partials.nav-desktop-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="hidden lg:flex ml-auto space-x-4 items-center">
            <?php echo $__env->make('layouts.partials.nav-faq-help', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Search bar: Only show on mobile (below lg) -->
        <div class="lg:hidden mx-4 pr-4 flex-1 justify-center ml-6">
            <?php echo $__env->make('layouts.partials.nav-search', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- Bottom Nav: Search + Global Actions + Hamburger -->
    <div class="flex items-center justify-between h-16 w-full">
        <div class="hidden lg:flex flex-1 mr-2 items-center">
            <?php echo $__env->make('layouts.partials.nav-search', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="lg:hidden flex-1 justify-start ml-auto space-x-4">
            <?php echo $__env->make('layouts.partials.nav-faq-help', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="flex items-center">
            <!-- Language/Currency -->
            <div x-data="{ open: false }" class="relative">
                <?php echo $__env->make('layouts.partials.nav-language-currency', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <?php if (isset($component)) { $__componentOriginale746c89893559e87ed0d7d5b9911963f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale746c89893559e87ed0d7d5b9911963f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chat.chat-icon','data' => ['route' => route('chat.index'),'label' => 'User Chat','badge' => $unreadUserChats ?? 0]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chat.chat-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('chat.index')),'label' => 'User Chat','badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadUserChats ?? 0)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale746c89893559e87ed0d7d5b9911963f)): ?>
<?php $attributes = $__attributesOriginale746c89893559e87ed0d7d5b9911963f; ?>
<?php unset($__attributesOriginale746c89893559e87ed0d7d5b9911963f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale746c89893559e87ed0d7d5b9911963f)): ?>
<?php $component = $__componentOriginale746c89893559e87ed0d7d5b9911963f; ?>
<?php unset($__componentOriginale746c89893559e87ed0d7d5b9911963f); ?>
<?php endif; ?>

            
            <div x-data="{ open: false }" class="relative">
                <?php echo $__env->make('layouts.partials.nav-notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div class="flex items-center">
                <?php echo $__env->make('layouts.partials.nav-cart-wishlist', [
                    'cartCount' => $cartCount ?? 0,
                    'wishlistCount' => $wishlistCount ?? 0
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <?php if (isset($component)) { $__componentOriginalfefe5dbf3b22960644eea9a713073a08 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfefe5dbf3b22960644eea9a713073a08 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dark-mode-toggle','data' => ['class' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dark-mode-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfefe5dbf3b22960644eea9a713073a08)): ?>
<?php $attributes = $__attributesOriginalfefe5dbf3b22960644eea9a713073a08; ?>
<?php unset($__attributesOriginalfefe5dbf3b22960644eea9a713073a08); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfefe5dbf3b22960644eea9a713073a08)): ?>
<?php $component = $__componentOriginalfefe5dbf3b22960644eea9a713073a08; ?>
<?php unset($__componentOriginalfefe5dbf3b22960644eea9a713073a08); ?>
<?php endif; ?>

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
<?php /**PATH D:\Year_IV\pp\ShopExpress\resources\views/layouts/partials/desktop-nav.blade.php ENDPATH**/ ?>