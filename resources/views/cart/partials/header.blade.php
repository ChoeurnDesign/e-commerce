<div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-700">
    <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">
        Cart ({{ $cartTotals['total_quantity'] ?? 0 }} items)
    </h2>
    <form action="{{ route('cart.clear') }}" method="POST" class="inline">
        @csrf <input type="hidden" name="_method" value="">
        <button type="submit"
            class="text-xs text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600 font-medium px-3 py-1 rounded transition"
            onclick="return confirm('Clear your cart?')">
            Clear All
        </button>
    </form>
</div>

