<!-- Cart -->
<a href="<?php echo e(route('cart.index')); ?>"
    class="relative p-2 mx-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-600 dark:hover:bg-[#2e1065] transition-colors">
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'cart','class' => 'w-8 h-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cart','class' => 'w-8 h-8']); ?>
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
    <?php if(auth()->guard()->check()): ?>
    <?php if(isset($cartCount) && $cartCount > 0): ?>
    <span
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none"><?php echo e($cartCount); ?></span>
    <?php endif; ?>
    <?php endif; ?>
</a>
<!-- Wishlist -->
<a href="<?php echo e(route('wishlist.index')); ?>"
    class="relative p-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-600 dark:hover:bg-[#2e1065] transition-colors">
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'wishlist-filled','class' => 'w-8 h-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'wishlist-filled','class' => 'w-8 h-8']); ?>
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
    <?php if(auth()->guard()->check()): ?>
    <?php if(isset($wishlistCount) && $wishlistCount > 0): ?>
    <span
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none"><?php echo e($wishlistCount); ?></span>
    <?php endif; ?>
    <?php endif; ?>
</a>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/nav-cart-wishlist.blade.php ENDPATH**/ ?>