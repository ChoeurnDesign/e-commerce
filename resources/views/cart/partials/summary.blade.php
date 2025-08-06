<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 sticky top-4">
    <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-3">Order Summary</h2>
    <div class="space-y-2 text-sm mb-4">
        <div class="flex justify-between">
            <span class="text-gray-600 dark:text-gray-400">Subtotal ({{ $cartTotals['total_quantity'] }} items)</span>
            <span class="font-medium text-gray-900 dark:text-gray-100" id="cart-subtotal">${{ number_format($cartTotals['subtotal'], 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600 dark:text-gray-400">Tax ({{ number_format($cartTotals['tax_rate'] * 100, 1) }}%)</span>
            <span class="font-medium text-gray-900 dark:text-gray-100" id="cart-tax">${{ number_format($cartTotals['tax'], 2) }}</span>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
            <div class="flex justify-between font-bold text-gray-900 dark:text-gray-100">
                <span>Total</span>
                <span id="cart-total">${{ number_format($cartTotals['total'], 2) }}</span>
            </div>
        </div>
    </div>
    @auth
        <a href="{{ route('checkout.index') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-full transition duration-300 text-center shadow">
            Checkout
        </a>
    @else
        <div class="space-y-2 mb-3">
            <p class="text-sm text-gray-700 dark:text-gray-300 text-center font-medium">Please log in to checkout</p>
            <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">
                <a href="{{ route('login') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition text-center shadow">Login</a>
                <a href="{{ route('register') }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-lg transition text-center shadow">Create Account</a>
            </div>
        </div>
    @endauth
    <div class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-600 dark:text-gray-400 space-y-1">
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Secure checkout</span>
        </div>
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Free shipping over $50</span>
        </div>
        <div class="flex items-center gap-1">
            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>30-day return policy</span>
        </div>
    </div>
</div>
