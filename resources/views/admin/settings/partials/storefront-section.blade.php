{{-- Storefront Settings --}}
<form action="{{ route('admin.settings.save_storefront') }}" method="POST"
    class="mb-12 bg-white p-8 rounded-xl shadow-lg space-y-8 border border-gray-200">
    @csrf
    <h2 class="text-3xl text-gray-900 mb-6 border-b border-gray-200 pb-4">
        Storefront Settings
    </h2>
    
    <div class="space-y-6">
        {{-- Storefront Title --}}
        <div>
            <x-input-label for="storefront_title" value="Storefront Title" class="text-gray-700" />
            <x-text-input
                id="storefront_title"
                name="storefront_title"
                type="text"
                :value="old('storefront_title', $settings['storefront_title'] ?? '')"
                placeholder="e.g., Your Online Shopping Destination"
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500"
            />
        </div>

        {{-- Welcome Message --}}
        <div>
            <x-input-label for="welcome_message" value="Welcome Message" class="text-gray-700" />
            <textarea 
                id="welcome_message" 
                name="welcome_message" 
                rows="3"
                class="w-full bg-white text-gray-900 border-gray-300 rounded-lg py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="e.g., Welcome to our store! We're glad you're here.">{{ old('welcome_message', $settings['welcome_message'] ?? '') }}</textarea>
        </div>
    </div>

    <div class="flex justify-end">
        <x-admin.btn-submit>Save Storefront</x-admin.btn-submit>
    </div>
</form>