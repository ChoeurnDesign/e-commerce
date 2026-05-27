<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('orders.history') }}"
                   class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Orders
                </a>
            </div>

            {{-- Header Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Order #{{ $order->order_number }}</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex items-center gap-4">
                        @if($order->status === 'shipped' || $order->status === 'confirmed')
                            {{-- Show ONLY the Green Action Button when the user needs to do something --}}
                            <form action="{{ route('orders.confirm', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    onclick="return confirm('Confirm you received all items?')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all">
                                    Confirm Receipt
                                </button>
                            </form>
                        @else
                            {{-- Show the Status Badge ONLY when the order is already Completed, Pending, or Cancelled --}}
                            <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-lg border bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-700 dark:text-blue-100 dark:border-blue-600">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Side: Items Grouped by Store --}}
                <div class="lg:col-span-2 space-y-6">
                    @php
                        $groupedItems = $order->orderItems->groupBy(function($item) {
                            return $item->product->seller_id;
                        });
                    @endphp

                    @foreach($groupedItems as $sellerId => $items)
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Merchant</span>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $items->first()->product->seller->store_name ?? 'Official Store' }}
                                    </h3>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($items as $item)
                                    <div class="p-6 flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @php
                                                $image = $item->product->image ?? '';
                                                $imgSrc = filter_var($image, FILTER_VALIDATE_URL) ? $image : (str_starts_with($image, 'storage/') ? asset($image) : asset('storage/' . $image));
                                            @endphp
                                            <img src="{{ $imgSrc }}"
                                                alt="{{ $item->product_name }}"
                                                class="w-16 h-16 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 truncate">
                                                {{ $item->product_name }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $item->product_sku }}</p>
                                        </div>

                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                {{ \App\Helpers\CurrencyHelper::format($item->total) }}
                                            </p>
                                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Right Side: Order Summary & Shipping --}}
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Summary</h3>
                        <div class="space-y-2 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span>{{ \App\Helpers\CurrencyHelper::format($order->subtotal) }}</span>
                            </div>
                            
                            {{-- Tax Amount Added Here --}}
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Tax</span>
                                <span>{{ \App\Helpers\CurrencyHelper::format($order->tax_amount ?? 0) }}</span>
                            </div>

                            <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-gray-100 pt-2 border-t border-gray-100 dark:border-gray-700 mt-2">
                                <span>Total</span>
                                <span>{{ \App\Helpers\CurrencyHelper::format($order->total_price) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Shipping Info</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 font-bold">{{ $order->customer_name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->shipping_address }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $order->customer_phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>