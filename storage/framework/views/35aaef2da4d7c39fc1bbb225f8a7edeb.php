<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <?php if (isset($component)) { $__componentOriginal46074e4381a20ab3ec96fa5c86c7b952 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal46074e4381a20ab3ec96fa5c86c7b952 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner-slider','data' => ['banners' => $banners]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner-slider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['banners' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($banners)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal46074e4381a20ab3ec96fa5c86c7b952)): ?>
<?php $attributes = $__attributesOriginal46074e4381a20ab3ec96fa5c86c7b952; ?>
<?php unset($__attributesOriginal46074e4381a20ab3ec96fa5c86c7b952); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal46074e4381a20ab3ec96fa5c86c7b952)): ?>
<?php $component = $__componentOriginal46074e4381a20ab3ec96fa5c86c7b952; ?>
<?php unset($__componentOriginal46074e4381a20ab3ec96fa5c86c7b952); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginale2733d0d1260161024b28b314de00085 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2733d0d1260161024b28b314de00085 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.categories-preview','data' => ['parentCategories' => $parentCategories]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.categories-preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['parentCategories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($parentCategories)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2733d0d1260161024b28b314de00085)): ?>
<?php $attributes = $__attributesOriginale2733d0d1260161024b28b314de00085; ?>
<?php unset($__attributesOriginale2733d0d1260161024b28b314de00085); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2733d0d1260161024b28b314de00085)): ?>
<?php $component = $__componentOriginale2733d0d1260161024b28b314de00085; ?>
<?php unset($__componentOriginale2733d0d1260161024b28b314de00085); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal3d937ea687b6d9dabd654b0dee1cf417 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d937ea687b6d9dabd654b0dee1cf417 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.featured-products','data' => ['featuredProducts' => $featuredProducts]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.featured-products'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['featuredProducts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($featuredProducts)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d937ea687b6d9dabd654b0dee1cf417)): ?>
<?php $attributes = $__attributesOriginal3d937ea687b6d9dabd654b0dee1cf417; ?>
<?php unset($__attributesOriginal3d937ea687b6d9dabd654b0dee1cf417); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d937ea687b6d9dabd654b0dee1cf417)): ?>
<?php $component = $__componentOriginal3d937ea687b6d9dabd654b0dee1cf417; ?>
<?php unset($__componentOriginal3d937ea687b6d9dabd654b0dee1cf417); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal95b9a11feba8fdfddeb64c9c68b661c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal95b9a11feba8fdfddeb64c9c68b661c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.trust-section','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.trust-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal95b9a11feba8fdfddeb64c9c68b661c0)): ?>
<?php $attributes = $__attributesOriginal95b9a11feba8fdfddeb64c9c68b661c0; ?>
<?php unset($__attributesOriginal95b9a11feba8fdfddeb64c9c68b661c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal95b9a11feba8fdfddeb64c9c68b661c0)): ?>
<?php $component = $__componentOriginal95b9a11feba8fdfddeb64c9c68b661c0; ?>
<?php unset($__componentOriginal95b9a11feba8fdfddeb64c9c68b661c0); ?>
<?php endif; ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/home.blade.php ENDPATH**/ ?>