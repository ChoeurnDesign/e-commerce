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
            <form method="POST" action="<?php echo e(route('checkout.storeCustomer')); ?>" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                <?php echo csrf_field(); ?>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Checkout</h2>
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Full Name *</label>
                            <input type="text" name="customer_name" value="<?php echo e(old('customer_name')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Email Address *</label>
                            <input type="email" name="customer_email" value="<?php echo e(old('customer_email')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                            <input type="text" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Shipping Address</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Street Address *</label>
                            <input type="text" name="shipping_address" value="<?php echo e(old('shipping_address')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">City *</label>
                            <input type="text" name="shipping_city" value="<?php echo e(old('shipping_city')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">State/Province *</label>
                            <input type="text" name="shipping_state" value="<?php echo e(old('shipping_state')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Postal Code *</label>
                            <input type="text" name="shipping_postal_code" value="<?php echo e(old('shipping_postal_code')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Country *</label>
                            <input type="text" name="shipping_country" value="<?php echo e(old('shipping_country')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <input class="rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500"
                               type="checkbox"
                               name="billing_same_as_shipping"
                               id="billing_same"
                               value="1"
                               <?php echo e(old('billing_same_as_shipping', '1') === '1' ? 'checked' : ''); ?>>
                        <label for="billing_same" class="ml-2 text-gray-700 dark:text-gray-300">Billing address is the same as shipping</label>
                    </div>
                    <div id="billing-fields" style="display:none;" class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Billing Address</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-1">Street Address *</label>
                                <input type="text" name="billing_address" value="<?php echo e(old('billing_address')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-1">City *</label>
                                <input type="text" name="billing_city" value="<?php echo e(old('billing_city')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-1">State/Province *</label>
                                <input type="text" name="billing_state" value="<?php echo e(old('billing_state')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-1">Postal Code *</label>
                                <input type="text" name="billing_postal_code" value="<?php echo e(old('billing_postal_code')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 dark:text-gray-300 mb-1">Country *</label>
                                <input type="text" name="billing_country" value="<?php echo e(old('billing_country')); ?>" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Order Notes</label>
                    <textarea name="notes" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" placeholder="Any special instructions for your order..."><?php echo e(old('notes')); ?></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold" id="next-step-btn">Next</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Show/hide billing fields
        document.addEventListener('DOMContentLoaded', function () {
            const billingCheckbox = document.getElementById('billing_same');
            const billingFields = document.getElementById('billing-fields');
            function toggleBillingFields() {
                if (billingCheckbox.checked) {
                    billingFields.style.display = 'none';
                } else {
                    billingFields.style.display = '';
                }
            }
            billingCheckbox.addEventListener('change', toggleBillingFields);
            toggleBillingFields();
        });
    </script>
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
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/customer_info.blade.php ENDPATH**/ ?>