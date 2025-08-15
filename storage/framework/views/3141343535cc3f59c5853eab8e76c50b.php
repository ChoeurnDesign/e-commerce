<!-- Billing Address -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-2 border-gray-300 dark:border-gray-700">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Billing Address</h2>
    <div class="mb-4">
        <label class="flex items-center">
            <input type="checkbox"
                name="billing_same_as_shipping"
                value="1"
                checked
                class="mr-2 rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                onchange="toggleBillingAddress(this)">
            <span class="text-sm text-gray-700 dark:text-gray-200">Billing address is the same as shipping address</span>
        </label>
    </div>
    <div id="billing-address-fields" class="hidden space-y-6">
        <div>
            <label for="billing_address" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Street Address</label>
            <textarea id="billing_address"
                name="billing_address"
                rows="3"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"><?php echo e(old('billing_address')); ?></textarea>
            <?php $__errorArgs = ['billing_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="billing_city" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">City</label>
                <input type="text"
                    id="billing_city"
                    name="billing_city"
                    value="<?php echo e(old('billing_city')); ?>"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                <?php $__errorArgs = ['billing_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="billing_state" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">State/Province</label>
                <input type="text"
                    id="billing_state"
                    name="billing_state"
                    value="<?php echo e(old('billing_state')); ?>"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                <?php $__errorArgs = ['billing_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="billing_postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Postal Code</label>
                <input type="text"
                    id="billing_postal_code"
                    name="billing_postal_code"
                    value="<?php echo e(old('billing_postal_code')); ?>"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                <?php $__errorArgs = ['billing_postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="billing_country" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Country</label>
                <select id="billing_country"
                    name="billing_country"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">Select Country</option>
                    <option value="United States" <?php echo e(old('billing_country') == 'United States' ? 'selected' : ''); ?>>United States</option>
                    <option value="Canada" <?php echo e(old('billing_country') == 'Canada' ? 'selected' : ''); ?>>Canada</option>
                    <option value="United Kingdom" <?php echo e(old('billing_country') == 'United Kingdom' ? 'selected' : ''); ?>>United Kingdom</option>
                    <option value="Australia" <?php echo e(old('billing_country') == 'Australia' ? 'selected' : ''); ?>>Australia</option>
                </select>
                <?php $__errorArgs = ['billing_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/partials/billing-address.blade.php ENDPATH**/ ?>