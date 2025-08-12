<?php
    $currencies = config('currencies');
    $currentCurrency = session('currency', 'usd');
?>

<div class="flex items-center space-x-4">
    
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center py-1 bg-transparent rounded focus:outline-none transition text-gray-700 dark:text-white text-sm"
            :class="{ 'ring-2 ring-indigo-500': open }"
            aria-haspopup="true" :aria-expanded="open">
            <span class="text-gray-400 dark:text-gray-300 mx-1">
                <?php echo e($currencies[$currentCurrency]['symbol'] ?? '$'); ?> <?php echo e($currencies[$currentCurrency]['name'] ?? 'USD'); ?>

            </span>
            <svg class="w-4 h-4 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Dropdown -->
        <div x-show="open" x-cloak @click.away="open = false"
            x-transition
            class="absolute left-0 mt-1 w-40 bg-white dark:bg-[#181b23] text-gray-700 dark:text-white shadow-md rounded z-50 py-1 border border-indigo-500 text-sm">
            <div class="px-3 pt-1 pb-0 text-xs text-gray-600 dark:text-gray-300 uppercase tracking-wider">Currency</div>
            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $cur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('currency.switch', $code)); ?>"
                    class="block px-3 py-1 text-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-[#2e1065] transition
                    <?php echo e($currentCurrency == $code ? 'font-bold bg-indigo-100 dark:bg-indigo-900' : ''); ?>">
                    <?php echo e($cur['symbol']); ?> - <?php echo e($cur['name']); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center py-1 bg-transparent rounded focus:outline-none transition text-gray-700 dark:text-white text-sm"
            :class="{ 'ring-2 ring-indigo-500': open }"
            aria-haspopup="true" :aria-expanded="open">
            <span class="text-gray-400 dark:text-gray-300 mx-1 capitalize">
                <?php echo e(session('lang', 'en') == 'en' ? 'English' : (session('lang') == 'km' ? 'Khmer' : session('lang'))); ?>

            </span>
            <svg class="w-4 h-4 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-cloak @click.away="open = false"
            x-transition
            class="absolute left-0 mt-1 w-40 bg-white dark:bg-[#181b23] text-gray-700 dark:text-white shadow-md rounded z-50 py-1 border border-indigo-500 text-sm">
            <div class="px-3 pt-1 pb-0 text-xs text-gray-600 dark:text-gray-300 uppercase tracking-wider">Language</div>
            <a href="<?php echo e(route('locale.switch', 'en')); ?>"
                class="block px-3 py-1 hover:bg-gray-300 dark:hover:bg-[#2e1065] transition
                <?php echo e(session('lang', 'en') == 'en' ? 'font-bold bg-indigo-100 dark:bg-indigo-900' : ''); ?>">
                English
            </a>
            <a href="<?php echo e(route('locale.switch', 'km')); ?>"
                class="block px-3 py-1 hover:bg-gray-300 dark:hover:bg-[#2e1065] transition
                <?php echo e(session('lang') == 'km' ? 'font-bold bg-indigo-100 dark:bg-indigo-900' : ''); ?>">
                Khmer
            </a>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/nav-language-currency.blade.php ENDPATH**/ ?>