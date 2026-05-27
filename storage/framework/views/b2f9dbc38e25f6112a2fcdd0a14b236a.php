<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <script>
        // Apply theme BEFORE first paint to avoid white flash
        (function () {
            try {
                const theme = localStorage.getItem('theme'); // 'dark' | 'light' | null
                const prefersDark = window.matchMedia &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (theme === 'dark' || (theme === null && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col">
    <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.flash-messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-1 bg-gray-100 dark:bg-gray-900">
        <?php echo e($slot); ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if (isset($component)) { $__componentOriginalc970f1c64894fa26df2506220f45d129 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc970f1c64894fa26df2506220f45d129 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.info-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('info-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc970f1c64894fa26df2506220f45d129)): ?>
<?php $attributes = $__attributesOriginalc970f1c64894fa26df2506220f45d129; ?>
<?php unset($__attributesOriginalc970f1c64894fa26df2506220f45d129); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc970f1c64894fa26df2506220f45d129)): ?>
<?php $component = $__componentOriginalc970f1c64894fa26df2506220f45d129; ?>
<?php unset($__componentOriginalc970f1c64894fa26df2506220f45d129); ?>
<?php endif; ?>
    <?php echo $__env->make('layouts.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
      window.toggleTheme = function () {
        const root = document.documentElement;
        const isDark = root.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
      };
    </script>

    <script src="<?php echo e(asset('js/shop-actions.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\Year_IV\Semester II\pp\ShopExpress\resources\views/layouts/app.blade.php ENDPATH**/ ?>