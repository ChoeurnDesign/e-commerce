<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-2 border-gray-300 dark:border-gray-700">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Payment Method</h2>
    <div class="space-y-4">
        <div class="flex items-center">
            <input id="credit_card"
                name="payment_method"
                type="radio"
                value="credit_card"
                {{ old('payment_method', 'credit_card') == 'credit_card' ? 'checked' : '' }}
                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
            <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-200">
                Credit Card
            </label>
            <div class="ml-auto flex space-x-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" class="h-6 w-auto bg-white rounded" style="padding:2px;"/>
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6 w-auto bg-white rounded" style="padding:2px;"/>
            </div>
        </div>
        <div class="flex items-center">
            <input id="paypal"
                name="payment_method"
                type="radio"
                value="paypal"
                {{ old('payment_method') == 'paypal' ? 'checked' : '' }}
                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
            <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-200">
                PayPal
            </label>
            <div class="ml-auto">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" class="h-6 w-auto bg-white rounded" style="padding:2px;"/>
            </div>
        </div>
        <div class="flex items-center">
            <input id="cash_on_delivery"
                name="payment_method"
                type="radio"
                value="cash_on_delivery"
                {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}
                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600">
            <label for="cash_on_delivery" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-200">
                Cash on Delivery
            </label>
            <div class="ml-auto">
                <img src="https://unpkg.com/@tabler/icons@2.47.0/icons/cash.svg" alt="Cash on Delivery" class="h-8 w-auto" style="filter: invert(1)" />
            </div>
        </div>
    </div>
    @error('payment_method')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>
