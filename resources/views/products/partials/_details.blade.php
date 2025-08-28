<div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 flex flex-col md:flex-row gap-6 border border-gray-100 dark:border-[#23263a]">
    <div class="flex-shrink-0 flex justify-center items-center">
        <img
            class="h-50 w-50 max-w-full rounded-xl object-cover border border-gray-100 dark:border-[#23263a] shadow-lg"
            src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name) }}"
            alt="{{ $product->name }}"
        >
    </div>
    <div class="flex-1 space-y-3">
        <h3 class="text-xl text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
        <div class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Category:</span>
            <span class="text-gray-900 dark:text-gray-100">{{ $product->category->name ?? 'No Category' }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Price:</span>
            <span class="text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</span>
            @if($product->sale_price)
                <span class="ml-3 font-medium text-green-600 dark:text-green-400">Sale: ${{ number_format($product->sale_price, 2) }}</span>
            @endif
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Stock:</span>
            <span class="text-gray-900 dark:text-gray-100">{{ $product->stock_quantity }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Status:</span>
            <span class="inline-flex px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 dark:bg-green-950 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-950 text-red-800 dark:text-red-300' }}">
                {{ $product->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Description:</span>
            <span class="text-gray-800 dark:text-gray-200 ml-1">
                {!! nl2br(e($product->description)) !!}
            </span>
        </div>
    </div>
</div>
