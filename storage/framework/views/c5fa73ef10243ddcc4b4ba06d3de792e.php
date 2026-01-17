<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'class' => '',
    'label' => null,
    'bare' => false, // when true return only the <i> element
]));

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

foreach (array_filter(([
    'name',
    'class' => '',
    'label' => null,
    'bare' => false, // when true return only the <i> element
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    // ensure we always include any sizing if not provided by caller
    $classes = trim($class);
?>

<?php if($bare): ?>
    <?php switch($name):
        case ('facebook'): ?>   <i class="fa-brands fa-facebook <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php case ('twitter'): ?>    <i class="fa-brands fa-twitter <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php case ('instagram'): ?>  <i class="fa-brands fa-instagram <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php case ('linkedin'): ?>   <i class="fa-brands fa-linkedin <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php case ('tiktok'): ?>     <i class="fa-brands fa-tiktok <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php case ('youtube'): ?>    <i class="fa-brands fa-youtube <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php case ('pinterest'): ?>  <i class="fa-brands fa-pinterest <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php case ('website'): ?>    <i class="fa-solid fa-globe <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i> <?php break; ?>
        <?php default: ?>            <i class="fa-solid fa-circle <?php echo e($classes ?: 'text-white text-xl'); ?>" aria-hidden="true"></i>
    <?php endswitch; ?>
<?php else: ?>
    <span class="inline-flex items-center" role="img" aria-label="<?php echo e($label ?? $name); ?>">
        <?php switch($name):
            case ('facebook'): ?>   <i class="fa-brands fa-facebook <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php case ('twitter'): ?>    <i class="fa-brands fa-twitter <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php case ('instagram'): ?>  <i class="fa-brands fa-instagram <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php case ('linkedin'): ?>   <i class="fa-brands fa-linkedin <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php case ('tiktok'): ?>     <i class="fa-brands fa-tiktok <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php case ('youtube'): ?>    <i class="fa-brands fa-youtube <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php case ('pinterest'): ?>  <i class="fa-brands fa-pinterest <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php case ('website'): ?>    <i class="fa-solid fa-globe <?php echo e($classes); ?>" aria-hidden="true"></i> <?php break; ?>
            <?php default: ?>            <i class="fa-solid fa-circle <?php echo e($classes); ?>" aria-hidden="true"></i>
        <?php endswitch; ?>

        <?php if($label): ?>
            <span class="sr-only"><?php echo e($label); ?></span>
        <?php endif; ?>
    </span>
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/icon-socials.blade.php ENDPATH**/ ?>