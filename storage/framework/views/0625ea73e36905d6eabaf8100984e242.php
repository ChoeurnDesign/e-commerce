<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product' => null, 'image' => null, 'class' => '', 'alt' => null, 'id' => null]));

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

foreach (array_filter((['product' => null, 'image' => null, 'class' => '', 'alt' => null, 'id' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    use Illuminate\Support\Str;
    $raw = $image ?? ($product->image ?? null);
    $name = $product->name ?? 'Product';
    $placeholder = 'https://via.placeholder.com/800x800?text=' . urlencode(Str::limit($name, 12, ''));
    $src = $placeholder;

    if (is_string($raw) && trim($raw) !== '') {
        $p = trim($raw, "\"' \t\n\r\0\x0B");
        $p = str_replace('\\', '/', $p);
        $p = ltrim($p, './');
        if (preg_match('#^https?://#i', $p)) {
            $src = $p; // remote image
        } elseif (str_starts_with($p, 'storage/')) {
            $relative = Str::after($p, 'storage/');
            // ✅ Accept either the public disk (storage/app/public) OR the public symlink (public/storage)
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relative) || file_exists(public_path($p))) {
                $src = asset($p);
            }
        } else {
            if (file_exists(public_path($p))) {
                $src = asset($p);
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($p)) {
                $src = asset('storage/'.$p);
            }
        }
    }
?>

<img
    <?php if($id): ?> id="<?php echo e($id); ?>" <?php endif; ?>
    src="<?php echo e($src); ?>"
    alt="<?php echo e($alt ?? $name); ?>"
    class="<?php echo e($class ?: 'h-10 w-10 rounded-lg object-cover border border-gray-100 dark:border-[#23263a]'); ?>"
    loading="lazy"
    onerror="this.onerror=null;this.src='<?php echo e($placeholder); ?>';"
/>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/partials/image-seller.blade.php ENDPATH**/ ?>