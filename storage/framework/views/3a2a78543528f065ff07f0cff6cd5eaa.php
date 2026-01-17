<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['route' => '#', 'label' => 'Chat', 'badge' => null, 'unreadUrl' => null]));

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

foreach (array_filter((['route' => '#', 'label' => 'Chat', 'badge' => null, 'unreadUrl' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    // Priority: explicit prop -> seller unread -> user unread -> 0
    $initial = (int) ($badge ?? $unreadSellerChats ?? $unreadUserChats ?? 0);

    // unreadUrl kept for backwards-compatibility if you later want client polling
    $unreadUrl = $unreadUrl ?? (Route::has('chat.unread-count') ? route('chat.unread-count') : '/chat/unread-count');
?>

<a href="<?php echo e($route ?? '#'); ?>" class="relative group" aria-label="<?php echo e($label ?? 'Chat'); ?>">
    <!-- Chat SVG -->
    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'chat','class' => 'w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chat','class' => 'w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition']); ?>
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

    <!-- Server-rendered badge: hidden when 0 -->
    <span class="chat-unread-badge absolute -top-3 -right-2 bg-red-500 text-xs text-white rounded-full w-5 h-5 inline-flex items-center justify-center leading-none <?php echo e($initial === 0 ? 'hidden' : ''); ?>"
      role="status" aria-live="polite"
      data-unread="<?php echo e($initial); ?>"
      data-unread-url="<?php echo e($unreadUrl); ?>">
    <span class="sr-only">
        <?php echo e($initial === 0 ? 'No unread messages' : ($initial > 99 ? '99+ unread messages' : $initial . ' unread messages')); ?>

    </span>
    <span aria-hidden="true" class="chat-unread-visible"><?php echo e($initial > 99 ? '99+' : $initial); ?></span>
</span>
</a><?php /**PATH D:\Year_IV\pp\ShopExpress\resources\views/components/chat/chat-icon.blade.php ENDPATH**/ ?>