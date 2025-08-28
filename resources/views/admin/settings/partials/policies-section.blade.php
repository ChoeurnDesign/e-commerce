{{-- Policy Settings --}}
<form action="{{ route('admin.settings.savePolicies') }}" method="POST"
    class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
    @csrf
    <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Policy Settings</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <x-input-label for="return_policy" value="Return Policy" />
            <textarea id="return_policy" name="return_policy" rows="4"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
                placeholder="Write your return policy here...">{{ old('return_policy', $settings['return_policy'] ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="privacy_policy" value="Privacy Policy" />
            <textarea id="privacy_policy" name="privacy_policy" rows="4"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
                placeholder="Write your privacy policy here...">{{ old('privacy_policy', $settings['privacy_policy'] ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="terms_of_service" value="Terms of Service" />
            <textarea id="terms_of_service" name="terms_of_service" rows="4"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
                placeholder="Write your terms of service here...">{{ old('terms_of_service', $settings['terms_of_service'] ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="support_info" value="Support Info" />
            <textarea id="support_info" name="support_info" rows="4"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
                placeholder="Write your support info here...">{{ old('support_info', $settings['support_info'] ?? '') }}</textarea>
        </div>
    </div>
    <div>
        <x-input-label for="shipping_policy" value="Shipping Policy" />
        <textarea id="shipping_policy" name="shipping_policy" rows="4"
            class="w-full bg-gray-700 text-gray-100 border-gray-600 py-2 px-4"
            placeholder="Write your shipping policy here...">{{ old('shipping_policy', $settings['shipping_policy'] ?? '') }}</textarea>
    </div>
    <div class="flex justify-end">
        <x-admin.btn-submit>Save Policies</x-admin.btn-submit>
    </div>
</form>
