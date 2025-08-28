{{-- General Settings --}}
<form action="{{ route('admin.settings.save_general') }}" method="POST" enctype="multipart/form-data"
    class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
    @csrf
    <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">General Settings</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <x-input-label for="store_name" value="Store Name" />
            <x-text-input
                name="store_name"
                id="store_name"
                type="text"
                :value="old('store_name', $settings['store_name'] ?? '')"
                placeholder="e.g., My Awesome Shop"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
            />
        </div>
        <div>
            <x-input-label for="base_currency" value="Base Currency" />
            <x-text-input
                name="base_currency"
                id="base_currency"
                type="text"
                value="USD"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
                disabled
            />
            <p class="text-xs text-gray-400 mt-1">
                All product prices are stored in USD. Display currency can be changed by users only.
            </p>
        </div>
        <div>
            <x-input-label for="store_email" value="Store Email" />
            <x-text-input
                name="store_email"
                id="store_email"
                type="email"
                :value="old('store_email', $settings['store_email'] ?? '')"
                placeholder="e.g., contact@myawesomeshop.com"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
            />
        </div>
        <div>
            <x-input-label for="store_phone" value="Store Phone" />
            <x-text-input
                name="store_phone"
                id="store_phone"
                type="text"
                :value="old('store_phone', $settings['store_phone'] ?? '')"
                placeholder="e.g., +855 12 345 678"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
            />
        </div>
        <div>
            <x-input-label for="support_email" value="Support Email" />
            <x-text-input
                name="support_email"
                id="support_email"
                type="email"
                :value="old('support_email', $settings['support_email'] ?? '')"
                placeholder="e.g., support@yourshop.com"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
            />
        </div>
        <div>
            <x-input-label for="support_phone" value="Support Phone" />
            <x-text-input
                name="support_phone"
                id="support_phone"
                type="text"
                :value="old('support_phone', $settings['support_phone'] ?? '')"
                placeholder="e.g., +855 99 888 777"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
            />
        </div>
        <div class="col-span-1 md:col-span-2">
            <x-input-label for="store_address" value="Store Address" />
            <textarea id="store_address" name="store_address" rows="3"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
                placeholder="e.g., 123 E-Commerce St, Suite 456, Phnom Penh, Cambodia">{{ old('store_address', $settings['store_address'] ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="store_logo" value="Store Logo" />
            @if(!empty($settings['store_logo']))
                <div class="mb-2">
                    <img src="{{ asset($settings['store_logo']) }}" alt="Current Logo" class="h-16" />
                </div>
                <label class="block mt-2 text-gray-300">
                    <input type="checkbox" name="remove_logo" value="1" class="mr-2"> Remove current logo
                </label>
            @endif
            <input type="file" id="store_logo" name="store_logo"
                class="block w-full text-sm mt-2 rounded-full text-gray-300">
        </div>
    </div>
    <div class="flex justify-end">
        <x-admin.btn-submit>Save General</x-admin.btn-submit>
    </div>
</form>
