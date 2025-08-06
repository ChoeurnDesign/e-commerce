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
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">{{ old('shipping_address') }}</textarea>
            @error('shipping_address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="shipping_city" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">City *</label>
                <input type="text"
                    id="shipping_city"
                    name="shipping_city"
                    value="{{ old('shipping_city') }}"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('shipping_city')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="shipping_state" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">State/Province *</label>
                <input type="text"
                    id="shipping_state"
                    name="shipping_state"
                    value="{{ old('shipping_state') }}"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('shipping_state')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Postal Code *</label>
                <input type="text"
                    id="shipping_postal_code"
                    name="shipping_postal_code"
                    value="{{ old('shipping_postal_code') }}"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                @error('shipping_postal_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="shipping_country" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Country *</label>
                <select id="shipping_country"
                    name="shipping_country"
                    required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                    <option value="">Select Country</option>
                    <option value="United States" {{ old('shipping_country') == 'United States' ? 'selected' : '' }}>United States</option>
                    <option value="Canada" {{ old('shipping_country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                    <option value="United Kingdom" {{ old('shipping_country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                    <option value="Australia" {{ old('shipping_country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                    <option value="Cambodia" {{ old('shipping_country') == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
                    <!-- Add more countries as needed -->
                </select>
                @error('shipping_country')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
