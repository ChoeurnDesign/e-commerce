<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="py-12 min-h-screen flex flex-col items-center bg-gray-300 dark:bg-[#101624]">
        <div class="w-full max-w-4xl bg-white dark:bg-[#181f31] rounded-2xl shadow-xl p-10 border border-gray-300 dark:border-gray-700">
            <h1 class="text-4xl font-extrabold mb-4 text-center text-blue-700 dark:text-blue-300">About Us</h1>
            <p class="mb-8 text-xl text-gray-700 dark:text-gray-200 text-center">
                Welcome to Roe – your trusted destination for seamless online shopping, quality products, and great value.
            </p>
            <div class="space-y-6 text-gray-700 dark:text-gray-200">
                <p>
                    <strong>Roe</strong> was created to make shopping enjoyable, accessible, and reliable for everyone. We select our products for quality, value, and style so you always find something you love.
                </p>
                <p>
                    Our catalog covers fashion, electronics, home essentials, beauty, and more. We regularly update with new arrivals and exclusive deals, always focused on great customer care.
                </p>
                <p>
                    At Roe, customers come first. We offer fast shipping, secure payments, responsive support, and easy returns to give you a shopping experience you can trust.
                </p>
                <p>
                    Thank you for choosing Roe. We look forward to serving you!
                </p>
            </div>
            <div class="mt-10 text-right text-gray-600 dark:text-gray-300">
                <span class="font-semibold">Created by: Chun Choeurn</span>
            </div>
            <div class="mt-12 text-center">
                <span class="inline-block bg-blue-600 dark:bg-blue-800 text-white px-6 py-3 rounded-full font-semibold shadow-md">
                    Shop with confidence. Shop with Roe.
                </span>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/about.blade.php ENDPATH**/ ?>