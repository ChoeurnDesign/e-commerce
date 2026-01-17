<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['seller', 'isFollowing' => null]));

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

foreach (array_filter((['seller', 'isFollowing' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    if (is_null($isFollowing)) {
        $isFollowing = auth()->check() ? auth()->user()->isFollowingSeller($seller) : false;
    }
?>

<?php if(auth()->guard()->check()): ?>
    <?php if($isFollowing): ?>
        <form action="<?php echo e(route('stores.unfollow', $seller)); ?>" method="POST" class="inline" aria-live="polite">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button
                type="submit"
                aria-pressed="true"
                title="Unfollow <?php echo e($seller->store_name ?? $seller->name); ?>"
                class="inline-flex items-center gap-2 text-amber-400 dark:text-amber-300 transition text-lg leading-none"
            >
                Following
            </button>
        </form>
    <?php else: ?>
        <form action="<?php echo e(route('stores.follow', $seller)); ?>" method="POST" class="inline" aria-live="polite">
            <?php echo csrf_field(); ?>
            <button
                type="submit"
                aria-pressed="false"
                title="Follow <?php echo e($seller->store_name ?? $seller->name); ?>"
                class="inline-flex items-center gap-2 text-sky-500 dark:text-sky-400 transition hover:text-gray-600 dark:hover:text-gray-500 text-lg leading-none"
            >
                Follow
            </button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <a
        href="<?php echo e(route('login')); ?>"
        aria-pressed="false"
        title="Sign in to follow <?php echo e($seller->store_name ?? $seller->name); ?>"
        class="inline-flex items-center gap-2 text-sky-500 dark:text-sky-400 hover:text-gray-600 dark:hover:text-gray-500 transition text-lg leading-none"
    >

        Follow
    </a>
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/stores/partials/follow-button.blade.php ENDPATH**/ ?>