<div class="flex items-center space-x-4 mt-4">
    <label class="flex items-center">
        <input type="radio" name="payment_method" value="credit_card" id="pm-credit"
            <?php echo e(old('payment_method', 'credit_card') == 'credit_card' ? 'checked' : ''); ?>

            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
        <span class="ml-2">Credit Card</span>
    </label>
    <label class="flex items-center">
        <input type="radio" name="payment_method" value="paypal" id="pm-paypal"
            <?php echo e(old('payment_method') == 'paypal' ? 'checked' : ''); ?>

            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
        <span class="ml-2">PayPal</span>
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal"
            class="h-6 w-auto bg-white rounded ml-2" style="padding:2px;"/>
    </label>
    <label class="flex items-center">
        <input type="radio" name="payment_method" value="cash_on_delivery" id="pm-cod"
            <?php echo e(old('payment_method') == 'cash_on_delivery' ? 'checked' : ''); ?>

            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
        <span class="ml-2">Cash on Delivery</span>
    </label>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/partials/payment-method.blade.php ENDPATH**/ ?>