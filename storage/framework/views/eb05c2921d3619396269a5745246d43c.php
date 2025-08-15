<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'class' => 'w-5 h-5']));

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

foreach (array_filter((['name', 'class' => 'w-5 h-5']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php switch($name):
    case ('dashboard'): ?>
        <svg class="<?php echo e($class); ?>" fill="none" stroke="currentColor" viewBox="0 0 22 22">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5a2 2 0 012-2h0a2 2 0 012 2v0H8v0z"></path>
        </svg>
        <?php break; ?>

    <?php case ('store'): ?>
        <svg <?php echo e($attributes->merge(['class' => $class . ' inline mr-2 text-gray-700 dark:text-white'])); ?> fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="7" width="18" height="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l1.5-4a1 1 0 0 1 .95-.68h13.1a1 1 0 0 1 .95.68L21 7" />
        </svg>
        <?php break; ?>

    <?php case ('about'): ?>
        <svg class="inline w-5 h-5 mr-1 text-pink-700 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none" />
        <path d="M4 20v-2a4 4 0 014-4h8a4 4 0 014 4v2" stroke="currentColor" stroke-width="2" fill="none" />
    </svg>
        <?php break; ?>

    <?php case ('admin'): ?>
        <svg class="inline w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-300" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.4 15a1.65 1.65 0 01-2.33 2.33L15 16.4M4.6 9a1.65 1.65 0 012.33-2.33L9 7.6M9 16.4l-1.33 1.33A1.65 1.65 0 014.6 15M16.4 7.6l1.33-1.33A1.65 1.65 0 0119.4 9" />
        </svg>
        <?php break; ?>

    <?php case ('cart'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="9" cy="21" r="1"/>
            <circle cx="20" cy="21" r="1"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M1 1h2l4 14a2 2 0 0 0 2 1.5h9a2 2 0 0 0 2-1.5l3-10.5H6"/>
        </svg>
        <?php break; ?>

    <?php case ('categories'): ?>
        <svg class="inline w-5 h-5 mr-2 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="2" />
            <rect x="14" y="3" width="7" height="7" rx="2" />
            <rect x="14" y="14" width="7" height="7" rx="2" />
            <rect x="3" y="14" width="7" height="7" rx="2" />
        </svg>
        <?php break; ?>

    <?php case ('contact'): ?>
        <svg class="inline w-5 h-5 mr-1 text-blue-700 dark:text-blue-300" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none" />
            <polyline points="3 7 12 13 21 7" stroke="currentColor" stroke-width="2" fill="none" />
        </svg>
        <?php break; ?>

    <?php case ('dark-mode'): ?>
        <svg viewBox="0 0 48 48" fill="currentColor" class="h-4 w-4 mr-2 text-gray-700 dark:text-white">
            <path d="M24 0A24 24 0 0 0 0 24c0 13.255 10.745 24 24 24 10.609 0 19.541-7.083 22.527-16.825C38.984 35.132 27.224 36.167 18.167 29.833 6.949 21.766 10.185 7.457 24 0z" />
        </svg>
        <?php break; ?>

    <?php case ('home'): ?>
        <svg class="inline w-5 h-5 mr-1 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <polygon points="12,3 2,12 5,12 5,21 19,21 19,12 22,12 12,3" stroke="currentColor" fill="none" />
            <rect x="10" y="15" width="4" height="6" fill="none" stroke="currentColor" />
        </svg>
        <?php break; ?>

    <?php case ('login'): ?>
        <svg class="inline w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5v14" />
        </svg>
        <?php break; ?>

    <?php case ('orders'): ?>
        <svg class="inline w-5 h-5 mr-2 text-yellow-700 dark:text-[#fbbf24]" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <rect x="3" y="7" width="18" height="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4" />
        </svg>
        <?php break; ?>

    <?php case ('products'): ?>
        <svg class="inline w-5 h-5 mr-2 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <rect width="20" height="8" x="2" y="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6" />
        </svg>
        <?php break; ?>

    <?php case ('profile'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-700 dark:text-white" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4" />
            <path d="M4 20c0-2.5 3.5-4.5 8-4.5s8 2 8 4.5" stroke-linecap="round" />
        </svg>
        <?php break; ?>

    <?php case ('register'): ?>
        <svg class="inline w-5 h-5 mr-2 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 11c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0-7v4m0 16v-4" />
        </svg>
        <?php break; ?>

    <?php case ('signout'): ?>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            class="inline w-5 h-5 mr-2 text-red-500 dark:text-red-400">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 17l5-5m0 0l-5-5m5 5H9m4 5v1a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2h4a2 2 0 012 2v1" />
        </svg>
        <?php break; ?>

    <?php case ('user'): ?>
       <svg class="w-10 h-10 text-gray-400 dark:text-gray-300" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.3" />
            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.3" />
            <path d="M7 17c1.5-2 7.5-2 9 0" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
        </svg>
        <?php break; ?>

    <?php case ('wishlist'): ?>
        <svg class="inline w-5 h-5 mr-2 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <?php break; ?>

    <?php case ('notification'): ?>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <?php break; ?>

    <?php default: ?>
        
<?php endswitch; ?>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/icon-nav.blade.php ENDPATH**/ ?>