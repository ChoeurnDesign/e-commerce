{{-- Payment Settings --}}
<form action="{{ route('admin.settings.save_payment') }}" method="POST"
    class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
    @csrf
    <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Payment Settings</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <x-input-label for="payment_gateway" value="Payment Gateway" />
            <select id="payment_gateway" name="payment_gateway"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4">
                <option value="none"
                    {{ (old('payment_gateway', $settings['payment_gateway'] ?? '') == 'none') ? 'selected' : '' }}>
                    Select a Gateway</option>
                <option value="paypal"
                    {{ (old('payment_gateway', $settings['payment_gateway'] ?? '') == 'paypal') ? 'selected' : '' }}>
                    PayPal</option>
                <option value="aba_payway"
                    {{ (old('payment_gateway', $settings['payment_gateway'] ?? '') == 'aba_payway') ? 'selected' : '' }}>
                    ABA PayWay</option>
                <option value="wing"
                    {{ (old('payment_gateway', $settings['payment_gateway'] ?? '') == 'wing') ? 'selected' : '' }}>Wing
                </option>
                <option value="truemoney"
                    {{ (old('payment_gateway', $settings['payment_gateway'] ?? '') == 'truemoney') ? 'selected' : '' }}>
                    TrueMoney</option>
            </select>
        </div>
        <div>
            <x-input-label for="api_key" value="API Key" />
            <x-text-input
                id="api_key"
                name="api_key"
                type="text"
                :value="old('api_key', $settings['api_key'] ?? '')"
                placeholder="Enter your API key"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4"
            />
        </div>
    </div>
    <div class="flex justify-end">
        <x-admin.btn-submit>Save Payment</x-admin.btn-submit>
    </div>
</form>
