<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['label' => '', 'value' => '—', 'color' => 'indigo', 'icon' => null, 'size' => 'lg']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['label' => '', 'value' => '—', 'color' => 'indigo', 'icon' => null, 'size' => 'lg']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php if (isset($component)) { $__componentOriginal3b4b596281d3ff3ad76d0cc5661e1bda = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b4b596281d3ff3ad76d0cc5661e1bda = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seller.stat-card','data' => ['label' => $label,'value' => $value,'color' => $color,'icon' => $icon,'size' => $size]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seller.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value),'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($size)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b4b596281d3ff3ad76d0cc5661e1bda)): ?>
<?php $attributes = $__attributesOriginal3b4b596281d3ff3ad76d0cc5661e1bda; ?>
<?php unset($__attributesOriginal3b4b596281d3ff3ad76d0cc5661e1bda); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b4b596281d3ff3ad76d0cc5661e1bda)): ?>
<?php $component = $__componentOriginal3b4b596281d3ff3ad76d0cc5661e1bda; ?>
<?php unset($__componentOriginal3b4b596281d3ff3ad76d0cc5661e1bda); ?>
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/seller/metric-card.blade.php ENDPATH**/ ?>