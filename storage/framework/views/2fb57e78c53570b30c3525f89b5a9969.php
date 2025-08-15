<div class="lg:col-span-1">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4 border-2 border-gray-300 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Order Summary</h2>
        <!-- Cart Items -->
        <div class="space-y-4 mb-6">
            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center space-x-4">
                    <img src="<?php echo e(asset('img/products/' . $item['image'])); ?>"
                         alt="<?php echo e($item['name']); ?>"
                         class="w-16 h-16 object-cover rounded-lg">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate"><?php echo e($item['name']); ?></h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Qty: <?php echo e($item['quantity']); ?></p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">$<?php echo e(number_format($item['subtotal'], 2)); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- Order Totals -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">Subtotal (<?php echo e($cartTotals['total_quantity']); ?> items)</span>
                <span class="font-medium">$<?php echo e(number_format($cartTotals['subtotal'], 2)); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">Tax (<?php echo e(number_format($cartTotals['tax_rate'] * 100, 1)); ?>%)</span>
                <span class="font-medium">$<?php echo e(number_format($cartTotals['tax'], 2)); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">Shipping</span>
                <span class="font-medium text-green-600 dark:text-green-400">Free</span>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                <div class="flex justify-between text-lg font-bold">
                    <span class="text-gray-900 dark:text-gray-100">Total</span>
                    <span class="text-gray-900 dark:text-gray-100">$<?php echo e(number_format($cartTotals['total'], 2)); ?></span>
                </div>
            </div>
        </div>
        <!-- Place Order Button -->
        <button type="submit" id="place-order-btn"
            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full transition duration-300 mt-6">
            Place Order
        </button>
        <!-- Security Notice -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Your payment information is secure and encrypted</span>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/partials/order-summary.blade.php ENDPATH**/ ?>