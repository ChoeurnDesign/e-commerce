{{-- General Settings --}}
<form action="{{ route('admin.settings.save_general') }}" method="POST" enctype="multipart/form-data"
    class="bg-white p-8 rounded-xl shadow-lg space-y-8 border border-gray-200">
    @csrf
    <h2 class="text-3xl text-gray-900 mb-6 border-b border-gray-200 pb-4">General Settings</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <x-input-label for="store_name" value="Store Name" class="text-gray-700" />
            <x-text-input name="store_name" id="store_name" type="text" :value="old('store_name', $settings['store_name'] ?? '')" 
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4" />
        </div>
        <div>
            <x-input-label for="base_currency" value="Base Currency" class="text-gray-700" />
            <x-text-input name="base_currency" id="base_currency" type="text" value="USD" disabled 
                class="w-full bg-gray-100 text-gray-500 border-gray-200 rounded-lg py-2 px-4" />
            <p class="text-xs text-gray-500 mt-1">All product prices are stored in USD.</p>
        </div>
        <div>
            <x-input-label for="store_email" value="Store Email" class="text-gray-700" />
            <x-text-input name="store_email" id="store_email" type="email" :value="old('store_email', $settings['store_email'] ?? '')" 
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4" />
        </div>
        <div>
            <x-input-label for="store_phone" value="Store Phone" class="text-gray-700" />
            <x-text-input name="store_phone" id="store_phone" type="text" :value="old('store_phone', $settings['store_phone'] ?? '')" 
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4" />
        </div>
        <div>
            <x-input-label for="support_email" value="Support Email" class="text-gray-700" />
            <x-text-input name="support_email" id="support_email" type="email" :value="old('support_email', $settings['support_email'] ?? '')" 
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4" />
        </div>
        <div>
            <x-input-label for="support_phone" value="Support Phone" class="text-gray-700" />
            <x-text-input name="support_phone" id="support_phone" type="text" :value="old('support_phone', $settings['support_phone'] ?? '')" 
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4" />
        </div>
        <div class="col-span-1 md:col-span-2">
            <x-input-label for="store_address" value="Store Address" class="text-gray-700" />
            <textarea id="store_address" name="store_address" rows="3"
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4">{{ old('store_address', $settings['store_address'] ?? '') }}</textarea>
        </div>
        <div class="col-span-1 md:col-span-2">
            <x-input-label for="store_logo" value="Store Logo" class="text-gray-700" />
            @if(!empty($settings['store_logo']))
                <div class="mb-2"><img src="{{ asset($settings['store_logo']) }}" alt="Logo" class="h-16" /></div>
            @endif
            <input type="file" id="store_logo" name="store_logo" class="block w-full text-sm text-gray-500 mt-2">
        </div>
    </div>
    <div class="flex justify-end">
        <x-admin.btn-submit>Save General</x-admin.btn-submit>
    </div>
</form>