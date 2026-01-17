<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'class' => '']));

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

foreach (array_filter((['name', 'class' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php switch($name):
    case ('dashboard'): ?>
        <svg class="inline <?php echo e($class ?? 'w-5 h-5'); ?> " fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5a2 2 0 012-2h0a2 2 0 012 2v0H8v0z"></path>
        </svg>
        <?php break; ?>

    <?php case ('store'): ?>
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" stroke="currentColor" stroke-width="2" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 10-8 0v4M5 8h14l1 12a2 2 0 01-2 2H6a2 2 0 01-2-2l1-12z" />
        </svg>
        <?php break; ?>

    <?php case ('about'): ?>
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none" />
        <path d="M4 20v-2a4 4 0 014-4h8a4 4 0 014 4v2" stroke="currentColor" stroke-width="2" fill="none" />
    </svg>
        <?php break; ?>

    <?php case ('admin'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.4 15a1.65 1.65 0 01-2.33 2.33L15 16.4M4.6 9a1.65 1.65 0 012.33-2.33L9 7.6M9 16.4l-1.33 1.33A1.65 1.65 0 014.6 15M16.4 7.6l1.33-1.33A1.65 1.65 0 0119.4 9" />
        </svg>
        <?php break; ?>

    <?php case ('cart'): ?>
        <svg class="inline w-6 h-6 text-gray-200 dark:text-gray-300" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" >
            <path strokeLinecap="round" strokeLinejoin="round" stroke-width="1" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg>
        <?php break; ?>

    <?php case ('categories'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="2" />
            <rect x="14" y="3" width="7" height="7" rx="2" />
            <rect x="14" y="14" width="7" height="7" rx="2" />
            <rect x="3" y="14" width="7" height="7" rx="2" />
        </svg>
        <?php break; ?>

    <?php case ('contact'): ?>
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none" />
            <polyline points="3 7 12 13 21 7" stroke="currentColor" stroke-width="2" fill="none" />
        </svg>
        <?php break; ?>

    <?php case ('dark-mode'): ?>
        <svg viewBox="0 0 48 48" fill="currentColor" class="h-4 w-4 mr-2 text-gray-300 dark:text-gray-500">
            <path d="M24 0A24 24 0 0 0 0 24c0 13.255 10.745 24 24 24 10.609 0 19.541-7.083 22.527-16.825C38.984 35.132 27.224 36.167 18.167 29.833 6.949 21.766 10.185 7.457 24 0z" />
        </svg>
        <?php break; ?>

    <?php case ('home'): ?>
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <polygon points="12,3 2,12 5,12 5,21 19,21 19,12 22,12 12,3" stroke="currentColor" fill="none" />
            <rect x="10" y="15" width="4" height="6" fill="none" stroke="currentColor" />
        </svg>
        <?php break; ?>

    <?php case ('login'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5v14" />
        </svg>
        <?php break; ?>

    <?php case ('orders'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <rect x="3" y="7" width="18" height="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4" />
        </svg>
        <?php break; ?>

    <?php case ('products'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <rect width="20" height="8" x="2" y="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6" />
        </svg>
        <?php break; ?>

    <?php case ('profile'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4" />
            <path d="M4 20c0-2.5 3.5-4.5 8-4.5s8 2 8 4.5" stroke-linecap="round" />
        </svg>
        <?php break; ?>

    <?php case ('register'): ?>
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 11c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0-7v4m0 16v-4" />
        </svg>
        <?php break; ?>

    <?php case ('signout'): ?>
        <svg class="w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 17l5-5m0 0l-5-5m5 5H9m4 5v1a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2h4a2 2 0 012 2v1" />
        </svg>
        <?php break; ?>

    <?php case ('user'): ?>

        <svg class="<?php echo e($class ?? 'w-10 h-10'); ?> text-gray-300 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>

        <?php break; ?>

    <?php case ('wishlist'): ?>
        <svg class="inline w-6 h-6 text-gray-300 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
            <path stroke-width="1" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        <?php break; ?>

    <?php case ('wishlist-filled'): ?>
    <svg class="inline w-6 h-6 <?php echo e($class ?? 'text-gray-300 dark:text-gray-400'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
    </svg>
    <?php break; ?>

    <?php case ('chat'): ?>
        <svg class="<?php echo e($class ?? ''); ?> " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
        </svg>
    <?php break; ?>

    <?php case ('notification'): ?>
        <svg class="h-6 w-6 text-gray-300 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <?php break; ?>

    <?php case ('info'): ?>
        <svg class="inline w-6 h-6 <?php echo e($class ?? 'text-gray-300 dark:text-gray-400'); ?>" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        </svg>
        <?php break; ?>

     <?php case ('star-filled'): ?>
        <svg class="inline <?php echo e($class ?? 'w-5 h-5'); ?> text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>
        <?php break; ?>

    <?php case ('star-empty'): ?>
        <svg class="inline <?php echo e($class ?? 'w-5 h-5'); ?> text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>
        <?php break; ?>
    
    <?php case ('download'): ?>
        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        <?php break; ?>

    <?php case ('back'): ?>
        <svg class="<?php echo e($class ?? 'w-5 h-5'); ?> text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
        </svg>
        <?php break; ?>

    <?php case ('add'): ?>
        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <?php break; ?>

    <?php case ('approve'): ?>
        <svg class="<?php echo e($class ?? 'w-5 h-5'); ?> mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    <?php break; ?>

    <?php case ('pending'): ?>
        <svg class="<?php echo e($class ?? 'w-5 h-5'); ?> text-yellow-500 dark:text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 8v4m0 4h.01" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="10" />
        </svg>
        <?php break; ?>

    <?php case ('reject'): ?>
        <svg class="<?php echo e($class ?? 'w-5 h-5'); ?> mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    <?php break; ?>

    <?php case ('edit'): ?>
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
    <?php break; ?>

    <?php case ('delete'): ?>
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
    <?php break; ?>

    <?php case ('view'): ?>
    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
    </svg>
        
    <?php break; ?>

    <?php default: ?>
        
<?php endswitch; ?>
<?php /**PATH D:\Year_IV\pp\ShopExpress\resources\views/components/icon-nav.blade.php ENDPATH**/ ?>