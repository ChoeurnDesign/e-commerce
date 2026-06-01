<form action="{{ route('admin.settings.savePolicies') }}" method="POST"
    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
    @csrf
    <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">Policy Settings</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="return_policy" value="Return Policy" />
            <textarea id="return_policy" name="return_policy" rows="4"
                class="w-full mt-1 border-gray-300 text-gray-900 rounded-lg"
                placeholder="Write your return policy here...">{{ old('return_policy', $settings['return_policy'] ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="privacy_policy" value="Privacy Policy" />
            <textarea id="privacy_policy" name="privacy_policy" rows="4"
                class="w-full mt-1 border-gray-300 text-gray-900 rounded-lg"
                placeholder="Write your privacy policy here...">{{ old('privacy_policy', $settings['privacy_policy'] ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="terms_of_service" value="Terms of Service" />
            <textarea id="terms_of_service" name="terms_of_service" rows="4"
                class="w-full mt-1 border-gray-300 text-gray-900 rounded-lg"
                placeholder="Write your terms of service here...">{{ old('terms_of_service', $settings['terms_of_service'] ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="support_info" value="Support Info" />
            <textarea id="support_info" name="support_info" rows="4"
                class="w-full mt-1 border-gray-300 text-gray-900 rounded-lg"
                placeholder="Write your support info here...">{{ old('support_info', $settings['support_info'] ?? '') }}</textarea>
        </div>
        <div class="col-span-1 md:col-span-2">
            <x-input-label for="shipping_policy" value="Shipping Policy" />
            <textarea id="shipping_policy" name="shipping_policy" rows="4"
                class="w-full mt-1 border-gray-300 text-gray-900 rounded-lg"
                placeholder="Write your shipping policy here...">{{ old('shipping_policy', $settings['shipping_policy'] ?? '') }}</textarea>
        </div>
    </div>
    <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
        <x-admin.btn-submit>Save Policies</x-admin.btn-submit>
    </div>
</form>