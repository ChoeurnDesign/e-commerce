<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page header --}}
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
                <p class="text-sm text-gray-500 mt-1">Secure checkout — your information is protected</p>
            </div>

            {{-- Step progress indicator --}}
            <div class="flex items-center justify-center mb-8 select-none">
                <div id="progress-step-1" class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-pink-500 text-white">1</span>
                    <span class="text-sm font-semibold text-pink-600">Shipping</span>
                </div>
                <div class="flex-1 mx-3 h-0.5 bg-gray-300 rounded" id="progress-line"></div>
                <div id="progress-step-2" class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-rose-100 text-rose-400 transition-colors" id="step2-circle">2</span>
                    <span class="text-sm font-medium text-gray-400 transition-colors" id="step2-label">Payment</span>
                </div>
            </div>

            <form id="checkout-form" method="POST" action="{{ route('checkout.placeOrder') }}"
                  class="bg-white rounded-2xl shadow-lg p-8">
                @csrf

                @include('checkout.partials.customer_info')
                @include('checkout.partials.payment')

            </form>
        </div>
    </div>

    @push('scripts')
        @include('checkout.partials.script')
    @endpush
</x-app-layout>
