<div id="step-2" style="display:none;">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Payment</h2>
    <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Order Summary</h4>
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-700 dark:text-gray-200"><?php echo e($item['name']); ?></span>
                    <span class="text-gray-700 dark:text-gray-200">x<?php echo e($item['quantity']); ?></span>
                    <span class="text-gray-700 dark:text-gray-200">
                        <?php echo e(\App\Helpers\CurrencyHelper::format($item['subtotal'])); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="flex justify-between mb-2 border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                <span class="text-gray-700 dark:text-gray-200">Subtotal</span>
                <span class="text-gray-700 dark:text-gray-200">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($cartTotals['subtotal'])); ?>

                </span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-700 dark:text-gray-200">
                    Tax (<?php echo e(number_format($cartTotals['tax_rate'] * 100, 1)); ?>%)
                </span>
                <span class="text-gray-700 dark:text-gray-200">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($cartTotals['tax'])); ?>

                </span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-700 dark:text-gray-200">Shipping</span>
                <span class="text-green-600 dark:text-green-400 font-semibold">
                    <?php echo e(isset($cartTotals['shipping']) ? \App\Helpers\CurrencyHelper::format($cartTotals['shipping']) : 'Free'); ?>

                </span>
            </div>
            <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                <span class="font-bold text-gray-900 dark:text-gray-100">Total</span>
                <span class="font-bold text-gray-900 dark:text-gray-100">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($cartTotals['total'])); ?>

                </span>
            </div>
        </div>
    </div>
    <div class="flex justify-between">
        <button type="button" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded font-semibold" id="prev-step-btn">Back</button>
        <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded font-semibold" id="place-order-btn">Place Order</button>
    </div>
    <p class="mt-4 text-xs text-gray-500 dark:text-gray-400 text-center">Your payment information is secure and encrypted</p>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/partials/payment.blade.php ENDPATH**/ ?>