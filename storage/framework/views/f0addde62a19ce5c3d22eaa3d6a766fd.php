<!-- Shipping Address -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-2 border-gray-300 dark:border-gray-700">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Shipping Address</h2>
    <div class="space-y-6">
        <div>
            <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Street Address *</label>
            <textarea id="shipping_address"
                name="shipping_address"
                rows="3"
                required
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"><?php echo e(old('shipping_address')); ?></textarea>
            <?php $__errorArgs = ['shipping_address'];
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
                <label for="shipping_city" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">City *</label>
                <input type="text"
                    id="shipping_city"
                    name="shipping_city"
                    value="<?php echo e(old('shipping_city')); ?>"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                <?php $__errorArgs = ['shipping_city'];
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
                <label for="shipping_state" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">State/Province *</label>
                <input type="text"
                    id="shipping_state"
                    name="shipping_state"
                    value="<?php echo e(old('shipping_state')); ?>"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                <?php $__errorArgs = ['shipping_state'];
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
                <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Postal Code *</label>
                <input type="text"
                    id="shipping_postal_code"
                    name="shipping_postal_code"
                    value="<?php echo e(old('shipping_postal_code')); ?>"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                <?php $__errorArgs = ['shipping_postal_code'];
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
                <label for="shipping_country" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Country *</label>
                <select id="shipping_country"
                    name="shipping_country"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">Select Country</option>
                    <option value="United States" <?php echo e(old('shipping_country') == 'United States' ? 'selected' : ''); ?>>United States</option>
                    <option value="Canada" <?php echo e(old('shipping_country') == 'Canada' ? 'selected' : ''); ?>>Canada</option>
                    <option value="United Kingdom" <?php echo e(old('shipping_country') == 'United Kingdom' ? 'selected' : ''); ?>>United Kingdom</option>
                    <option value="Australia" <?php echo e(old('shipping_country') == 'Australia' ? 'selected' : ''); ?>>Australia</option>
                    <option value="Cambodia" <?php echo e(old('shipping_country') == 'Cambodia' ? 'selected' : ''); ?>>Cambodia</option>
                    <!-- Add more countries as needed -->
                </select>
                <?php $__errorArgs = ['shipping_country'];
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
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/partials/shipping-address.blade.php ENDPATH**/ ?>