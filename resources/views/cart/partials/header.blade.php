<div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
    <h2 class="text-base font-semibold text-gray-900">
        Cart ({{ $cartTotals['total_quantity'] ?? 0 }} items)
    </h2>
    <form action="{{ route('cart.clear') }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="text-xs text-red-500 hover:text-red-700 font-medium px-3 py-1 rounded transition"
            onclick="confirmClear(event, this)">
            Clear All
        </button>
    </form>
</div>