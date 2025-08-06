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
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ old('billing_address') }}</textarea>
            @error('billing_address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="billing_city" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">City</label>
                <input type="text"
                    id="billing_city"
                    name="billing_city"
                    value="{{ old('billing_city') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('billing_city')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="billing_state" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">State/Province</label>
                <input type="text"
                    id="billing_state"
                    name="billing_state"
                    value="{{ old('billing_state') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('billing_state')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="billing_postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Postal Code</label>
                <input type="text"
                    id="billing_postal_code"
                    name="billing_postal_code"
                    value="{{ old('billing_postal_code') }}"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('billing_postal_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="billing_country" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Country</label>
                <select id="billing_country"
                    name="billing_country"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">Select Country</option>
                    <option value="United States" {{ old('billing_country') == 'United States' ? 'selected' : '' }}>United States</option>
                    <option value="Canada" {{ old('billing_country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                    <option value="United Kingdom" {{ old('billing_country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                    <option value="Australia" {{ old('billing_country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                </select>
                @error('billing_country')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
