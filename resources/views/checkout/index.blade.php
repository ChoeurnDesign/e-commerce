<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Checkout</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Complete your order</p>
            </div>

            <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf

                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-8">
                    @include('checkout.partials.customer-info')
                    @include('checkout.partials.shipping-address')
                    @include('checkout.partials.billing-address')
                    @include('checkout.partials.payment-method')
                    @include('checkout.partials.order-notes')
                </div>

                @include('checkout.partials.order-summary')

                <!-- PayPal Button Section: Place after order summary -->
                <div class="col-span-1 lg:col-span-3 flex justify-center mt-8">
                    <div id="paypal-button-container" style="width: 100%;"></div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        @include('checkout.partials.billing-toggle-script')
        @include('checkout.partials.paypal-script')
    @endpush
</x-app-layout>
