<?php
    $currencies = config('currencies');
    $currentCurrency = session('currency', 'usd');
    $currentLang = session('lang', 'en');
?>

<div class="flex items-center space-x-4 mr-2">
    
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center py-1 bg-transparent rounded focus:outline-none transition text-gray-700 dark:text-white text-sm"
            :class="{ 'ring-2 ring-indigo-500': open }"
            aria-haspopup="true" :aria-expanded="open">
            <span class="text-gray-700 dark:text-gray-400 mx-1">
                <?php echo e($currencies[$currentCurrency]['symbol'] ?? '$'); ?>

                <?php echo e($currencies[$currentCurrency]['short_name'] ?? strtoupper($currentCurrency)); ?>

            </span>
            <svg class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open" x-cloak @click.away="open = false"
            x-transition
            class="absolute left-0 mt-1 w-44 bg-white dark:bg-[#181b23] text-gray-700 dark:text-white shadow-md rounded z-50 py-1 border border-indigo-500 text-sm">
            <div class="px-3 pt-1 pb-0 text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wider">Currency</div>

            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $cur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('currency.switch', $code)); ?>"
                    class="block px-3 py-2 text-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-[#2e1065] transition
                    <?php echo e($currentCurrency == $code ? 'font-bold bg-indigo-100 dark:bg-indigo-900' : ''); ?>">
                    <span class="mr-1"><?php echo e($cur['symbol'] ?? ''); ?></span>
                    <span class="font-semibold"><?php echo e($cur['short_name'] ?? strtoupper($code)); ?></span>
                    <span class="text-xs opacity-70">— <?php echo e($cur['name'] ?? ''); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center py-1 bg-transparent rounded focus:outline-none transition text-gray-700 dark:text-white text-sm"
            :class="{ 'ring-2 ring-indigo-500': open }"
            aria-haspopup="true" :aria-expanded="open">
            <span class="text-gray-700 dark:text-gray-400 mx-1">
                <?php echo e(strtoupper($currentLang)); ?>

            </span>
            <svg class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open" x-cloak @click.away="open = false"
            x-transition
            class="absolute left-0 mt-1 w-40 bg-white dark:bg-[#181b23] text-gray-700 dark:text-white shadow-md rounded z-50 py-1 border border-indigo-500 text-sm">
            <div class="px-3 pt-1 pb-0 text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wider">Language</div>

            <a href="<?php echo e(route('locale.switch', 'en')); ?>"
                class="block px-3 py-2 hover:bg-gray-300 dark:hover:bg-[#2e1065] transition
                <?php echo e($currentLang == 'en' ? 'font-bold bg-indigo-100 dark:bg-indigo-900' : ''); ?>">
                <span class="font-semibold">EN</span> <span class="text-xs opacity-70">— English</span>
            </a>

            <a href="<?php echo e(route('locale.switch', 'km')); ?>"
                class="block px-3 py-2 hover:bg-gray-300 dark:hover:bg-[#2e1065] transition
                <?php echo e($currentLang == 'km' ? 'font-bold bg-indigo-100 dark:bg-indigo-900' : ''); ?>">
                <span class="font-semibold">KM</span> <span class="text-xs opacity-70">— Khmer</span>
            </a>
        </div>
    </div>
</div><?php /**PATH D:\Year_IV\Semester II\pp\ShopExpress\resources\views/layouts/partials/nav-language-currency.blade.php ENDPATH**/ ?>