<div id="step-1">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Checkout</h2>
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Customer Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Full Name *</label>
                <input type="text" name="customer_name" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Email Address *</label>
                <input type="email" name="customer_email" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                <input type="text" name="customer_phone" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Shipping Address</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Street Address *</label>
                <input type="text" name="shipping_address" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">City *</label>
                <input type="text" name="shipping_city" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">State/Province *</label>
                <input type="text" name="shipping_state" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Postal Code *</label>
                <input type="text" name="shipping_postal_code" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 dark:text-gray-300 mb-1">Country *</label>
                <input type="text" name="shipping_country" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
        </div>
        <div class="flex items-center mt-4">
            <!-- Hidden input to send 0 if unchecked -->
            <input type="hidden" name="billing_same_as_shipping" value="0">
            <input class="rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600" type="checkbox" name="billing_same_as_shipping" id="billing_same" value="1" checked>
            <label for="billing_same" class="ml-2 text-gray-700 dark:text-gray-300">Billing address is the same as shipping</label>
        </div>
        <div id="billing-fields" style="display:none;" class="mt-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Billing Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Street Address *</label>
                    <input type="text" name="billing_address" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">City *</label>
                    <input type="text" name="billing_city" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">State/Province *</label>
                    <input type="text" name="billing_state" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Postal Code *</label>
                    <input type="text" name="billing_postal_code" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">Country *</label>
                    <input type="text" name="billing_country" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>
    </div>
    <div class="mb-6">
        <label class="block text-gray-700 dark:text-gray-300 mb-1">Order Notes</label>
        <textarea name="notes" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" placeholder="Any special instructions for your order..."></textarea>
    </div>
    <div class="flex justify-end">
        <button type="button" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold" id="next-step-btn">Next</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Billing address toggle
    const billingSameCheckbox = document.getElementById('billing_same');
    const billingFields = document.getElementById('billing-fields');
    if (billingSameCheckbox) {
        function toggleBillingFields() {
            billingFields.style.display = billingSameCheckbox.checked ? 'none' : '';
        }
        billingSameCheckbox.addEventListener('change', toggleBillingFields);
        toggleBillingFields();
    }

    // Multi-step validation
    const nextStepBtn = document.getElementById('next-step-btn');
    if (nextStepBtn) {
        nextStepBtn.addEventListener('click', function() {
            const step1 = document.getElementById('step-1');
            const inputs = step1.querySelectorAll('input, textarea, select');
            let isValid = true;
            for (const input of inputs) {
                // Only validate visible and enabled inputs
                if (
                    input.offsetParent !== null && // skip hidden
                    !input.disabled &&            // skip disabled
                    !input.checkValidity()
                ) {
                    input.reportValidity();
                    isValid = false;
                    break;
                }
            }
            if (isValid) {
                // Proceed to next step if valid
                document.getElementById('step-1').style.display = 'none';
                document.getElementById('step-2').style.display = 'block';
            }
        });
    }

    // Prev button for step 2
    const prevStepBtn = document.getElementById('prev-step-btn');
    if (prevStepBtn) {
        prevStepBtn.addEventListener('click', function() {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-1').style.display = 'block';
        });
    }
});
</script>
