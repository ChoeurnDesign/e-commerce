<div x-data="{ reportOpen: false }" class="relative">
    <!-- Button to open modal -->
    <button
        @click="reportOpen = true"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full  shadow transition"
    >
        Report a Problem
    </button>

    <!-- Modal overlay -->
    <div
        x-show="reportOpen"
        x-cloak
        class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50 dark:bg-opacity-80"
        @keydown.escape.window="reportOpen = false"
    >
        <!-- Modal box -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 relative z-50 transition-all"
            @click.away="reportOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <button
                @click="reportOpen = false"
                class="absolute top-3 right-3 text-gray-500 dark:text-gray-300 text-2xl leading-none hover:text-red-500"
            >&times;</button>
            <h4 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">Report a Problem</h4>
            <form action="<?php echo e(route('user_report.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo $__env->make('user_report._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/user-report.blade.php ENDPATH**/ ?>