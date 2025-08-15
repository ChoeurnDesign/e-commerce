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
    <div class="py-8 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if($errors->any()): ?>
                <div class="mb-6">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc ml-5">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('checkout.placeOrder')); ?>" id="checkout-form" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                <?php echo csrf_field(); ?>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Payment</h2>
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 dark:text-gray-200 mb-2">Select Payment Method</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="payment_method" value="credit_card" id="pm-credit" required class="rounded-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Credit Card</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="payment_method" value="paypal" id="pm-paypal" class="rounded-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700 dark:text-gray-300">PayPal</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="payment_method" value="cash_on_delivery" id="pm-cod" class="rounded-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Cash on Delivery</span>
                        </label>
                    </div>
                </div>
                <div id="paypal-button-container" style="display:none; margin-bottom: 1em;"></div>
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Order Summary</h4>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700 dark:text-gray-200">Product</span>
                            <span class="text-gray-700 dark:text-gray-200">iPhone 16</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700 dark:text-gray-200">Quantity</span>
                            <span class="text-gray-700 dark:text-gray-200">1</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700 dark:text-gray-200">Subtotal</span>
                            <span class="text-gray-700 dark:text-gray-200">$499.00</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700 dark:text-gray-200">Tax (8.5%)</span>
                            <span class="text-gray-700 dark:text-gray-200">$42.42</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700 dark:text-gray-200">Shipping</span>
                            <span class="text-green-600 dark:text-green-400 font-semibold">Free</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                            <span class="font-bold text-gray-900 dark:text-gray-100">Total</span>
                            <span class="font-bold text-gray-900 dark:text-gray-100">$541.42</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between">
                    <a href="<?php echo e(route('checkout.index')); ?>" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded font-semibold" id="prev-step-btn">Back</a>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded font-semibold" id="place-order-btn">Place Order</button>
                </div>
                <p class="mt-4 text-xs text-gray-500 dark:text-gray-400 text-center">Your payment information is secure and encrypted</p>
            </form>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
document.addEventListener('DOMContentLoaded', function () {
    const paypalRadio = document.getElementById('pm-paypal');
    const creditRadio = document.getElementById('pm-credit');
    const codRadio = document.getElementById('pm-cod');
    const paypalContainer = document.getElementById('paypal-button-container');
    const placeOrderBtn = document.getElementById('place-order-btn');
    let paypalRendered = false;

    function togglePayPal() {
        if (paypalRadio.checked) {
            paypalContainer.style.display = '';
            placeOrderBtn.style.display = 'none';
            if (!paypalRendered && window.paypal) {
                paypalRendered = true;
                // Render PayPal button
                paypal.Buttons({
                    // Customize this according to your flow
                    createOrder: function(data, actions) {
                        // Set up transaction here (amount, etc.)
                        return actions.order.create({
                            purchase_units: [{
                                amount: { value: '541.42' } // Replace with your dynamic total
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        // Capture order and submit to your server
                        return actions.order.capture().then(function(details) {
                            // Optionally submit details/orderID to your backend via AJAX
                            // Or submit a hidden field and submit the form
                            alert('Transaction completed by ' + details.payer.name.given_name);
                            // Example: document.getElementById('checkout-form').submit();
                        });
                    }
                }).render('#paypal-button-container');
            }
        } else {
            paypalContainer.style.display = 'none';
            placeOrderBtn.style.display = '';
        }
    }

    paypalRadio.addEventListener('change', togglePayPal);
    creditRadio.addEventListener('change', togglePayPal);
    codRadio.addEventListener('change', togglePayPal);

    // Initial state
    togglePayPal();
});
</script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/payment.blade.php ENDPATH**/ ?>