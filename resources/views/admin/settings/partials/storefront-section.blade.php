{{-- Storefront Settings --}}
<form action="{{ route('admin.settings.save_storefront') }}" method="POST"
    class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
    @csrf
    <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Storefront Settings</h2>
    <div class="space-y-6">
        <div>
            <x-input-label for="storefront_title" value="Storefront Title" />
            <x-text-input
                id="storefront_title"
                name="storefront_title"
                type="text"
                :value="old('storefront_title', $settings['storefront_title'] ?? '')"
                placeholder="e.g., Your Online Shopping Destination"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
            />
        </div>
        <div>
            <x-input-label for="welcome_message" value="Welcome Message" />
            <textarea id="welcome_message" name="welcome_message" rows="3"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
                placeholder="e.g., Welcome to our store! We're glad you're here.">{{ old('welcome_message', $settings['welcome_message'] ?? '') }}</textarea>
        </div>
    </div>
    <div class="flex justify-end">
        <x-admin.btn-submit>Save Storefront</x-admin.btn-submit>
    </div>
</form>
