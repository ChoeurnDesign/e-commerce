<x-app-layout>
    @include('cart.partials.flash')
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Shopping Cart</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Review your items and proceed to checkout</p>
            </div>
            @if(!empty($cartItems))
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        @include('cart.partials.items', ['cartItems' => $cartItems, 'cartTotals' => $cartTotals])
                    </div>
                    <div>
                        @include('cart.partials.summary', ['cartTotals' => $cartTotals])
                    </div>
                </div>
            @else
                @include('cart.partials.empty')
            @endif
        </div>
    </div>
    @push('scripts')
        @include('cart.partials.scripts', ['cartTotals' => $cartTotals])
    @endpush
</x-app-layout>
