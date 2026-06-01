<div id="step-1">

    {{-- Customer Information --}}
    <div class="mb-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Contact Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name"
                       value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors"
                       required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="customer_email"
                       value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors"
                       required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="tel" name="customer_phone"
                       value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                       placeholder="+855070229710"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors">
            </div>
        </div>
    </div>

    {{-- Shipping Address --}}
    <div class="mb-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Shipping Address
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Street Address <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_address" value="{{ old('shipping_address') }}"
                       placeholder="123 Main Street"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors"
                       required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors"
                       required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">State / Province <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_state" value="{{ old('shipping_state') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors"
                       required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors"
                       required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                <input type="text" name="shipping_country" value="{{ old('shipping_country', 'Cambodia') }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors"
                       required>
            </div>
        </div>

        {{-- Billing same as shipping --}}
        <div class="flex items-center mt-5 p-3 bg-rose-50 rounded-lg">
            <input type="hidden" name="billing_same_as_shipping" value="0">
            <input type="checkbox" name="billing_same_as_shipping" id="billing_same" value="1" checked
                   class="rounded border-gray-300 text-pink-600 focus:ring-pink-400">
            <label for="billing_same" class="ml-2 text-sm text-gray-700">
                Billing address is the same as shipping
            </label>
        </div>

        <div id="billing-fields" style="display:none;" class="mt-5">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Billing Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Street Address <span class="text-red-500">*</span></label>
                    <input type="text" name="billing_address" value="{{ old('billing_address') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                    <input type="text" name="billing_city" value="{{ old('billing_city') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State / Province <span class="text-red-500">*</span></label>
                    <input type="text" name="billing_state" value="{{ old('billing_state') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
                    <input type="text" name="billing_postal_code" value="{{ old('billing_postal_code') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country <span class="text-red-500">*</span></label>
                    <input type="text" name="billing_country" value="{{ old('billing_country') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors">
                </div>
            </div>
        </div>
    </div>

    {{-- Order Notes --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes <span class="text-gray-400 font-normal">(optional)</span></label>
        <textarea name="notes" rows="3"
                  placeholder="Special delivery instructions, gift message, etc."
                  class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-colors resize-none">{{ old('notes') }}</textarea>
    </div>

    <div class="flex justify-end">
        <button type="button" id="next-step-btn"
                class="px-8 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
            Continue to Payment
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>

