<x-app-layout>
    <div class="py-8 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form id="checkout-form" method="POST" action="{{ route('checkout.placeOrder') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
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
