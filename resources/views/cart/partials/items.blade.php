<div class="bg-white dark:bg-gray-800 rounded-xl shadow divide-y divide-gray-100 dark:divide-gray-700">
    @include('cart.partials.header', ['cartTotals' => $cartTotals])
    @foreach($cartItems as $item)
        @include('cart.partials.item', ['item' => $item])
    @endforeach
    <div class="flex justify-end items-center px-6 py-3 bg-gray-300 dark:bg-gray-700">
        <button type="button" id="update-cart-btn"
            class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full font-medium transition-all shadow-sm"
            style="min-width:0.5rem;" disabled>
            Update Cart
        </button>
    </div>
</div>
