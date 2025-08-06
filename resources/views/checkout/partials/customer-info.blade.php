<!-- Customer Information -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-2 border-gray-300 dark:border-gray-700">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Customer Information</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Full Name *</label>
            <input type="text"
                id="customer_name"
                name="customer_name"
                value="{{ old('customer_name', $user->name) }}"
                required
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            @error('customer_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Email Address *</label>
            <input type="email"
                id="customer_email"
                name="customer_email"
                value="{{ old('customer_email', $user->email) }}"
                required
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            @error('customer_email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="md:col-span-2">
            <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Phone Number</label>
            <input type="tel"
                id="customer_phone"
                name="customer_phone"
                value="{{ old('customer_phone') }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            @error('customer_phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
