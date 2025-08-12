<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('home'),'active' => request()->routeIs('home'),'class' => 'text-sky-600 dark:text-white font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('home')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('home')),'class' => 'text-sky-600 dark:text-white font-medium']); ?>
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'home','class' => 'w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'home','class' => 'w-5 h-5 mr-1']); ?>
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
    <?php echo e(__('navigation.home')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('products.index'),'active' => request()->routeIs('products.*'),'class' => 'text-sky-600 dark:text-white font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('products.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('products.*')),'class' => 'text-sky-600 dark:text-white font-medium']); ?>
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'products','class' => 'w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'products','class' => 'w-5 h-5 mr-1']); ?>
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
    <?php echo e(__('navigation.products')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('categories.index'),'active' => request()->routeIs('categories.*'),'class' => 'text-sky-600 dark:text-white font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('categories.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('categories.*')),'class' => 'text-sky-600 dark:text-white font-medium']); ?>
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'categories','class' => 'w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'categories','class' => 'w-5 h-5 mr-1']); ?>
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
    <?php echo e(__('navigation.categories')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

<?php if(auth()->guard()->check()): ?>
<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('orders.history'),'active' => request()->routeIs('orders.*'),'class' => 'text-sky-600 dark:text-white font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('orders.history')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('orders.*')),'class' => 'text-sky-600 dark:text-white font-medium']); ?>
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'orders','class' => 'w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'orders','class' => 'w-5 h-5 mr-1']); ?>
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
    <?php echo e(__('navigation.orders')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('about'),'active' => request()->routeIs('about'),'class' => 'text-sky-600 dark:text-pink-300 font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('about')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('about')),'class' => 'text-sky-600 dark:text-pink-300 font-medium']); ?>
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'about','class' => 'w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'about','class' => 'w-5 h-5 mr-1']); ?>
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
    <?php echo e(__('navigation.about')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('contact'),'active' => request()->routeIs('contact'),'class' => 'text-sky-600 dark:text-white font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('contact')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('contact')),'class' => 'text-sky-600 dark:text-white font-medium']); ?>
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'contact','class' => 'w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'contact','class' => 'w-5 h-5 mr-1']); ?>
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
    <?php echo e(__('navigation.contact')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

<?php if(auth()->guard()->check()): ?>
    <?php if(auth()->user() && auth()->user()->role === 'admin'): ?>
        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('admin.dashboard'),'active' => request()->routeIs('admin.dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.dashboard'))]); ?>
            <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'dashboard','class' => 'w-5 h-5 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'dashboard','class' => 'w-5 h-5 mr-1']); ?>
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
            <span><?php echo e(__('navigation.dashboard')); ?></span>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/nav-desktop-links.blade.php ENDPATH**/ ?>