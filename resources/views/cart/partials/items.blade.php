<div class="bg-white rounded-xl shadow divide-y divide-gray-100">
    @include('cart.partials.header', ['cartTotals' => $cartTotals])
    @foreach($cartItems as $item)
        @include('cart.partials.item', ['item' => $item])
    @endforeach
    <div class="flex justify-end items-center px-6 py-3 bg-rose-50 border-t border-rose-100">
        <button type="button" id="update-cart-btn"
            class="text-sm bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full font-medium transition-all shadow-sm"
            style="min-width:0.5rem;" disabled>
            Update Cart
        </button>
    </div>
</div>
    