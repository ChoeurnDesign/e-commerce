<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen"> {{-- Added dark mode background and min-h-screen --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('orders.history') }}"
                   class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 transition-colors duration-200"> {{-- Added dark mode text colors --}}
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Orders
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6"> {{-- Added dark:bg-gray-800 --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Order #{{ $order->order_number }}</h1> {{-- Added dark:text-gray-100 --}}
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p> {{-- Added dark:text-gray-400 --}}
                    </div>
                    <div class="mt-4 md:mt-0">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-700 dark:text-yellow-100 dark:border-yellow-600',
                                'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-700 dark:text-blue-100 dark:border-blue-600',
                                'processing' => 'bg-indigo-100 text-indigo-800 border-indigo-200 dark:bg-indigo-700 dark:text-indigo-100 dark:border-indigo-600',
                                'shipped' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-700 dark:text-purple-100 dark:border-purple-600',
                                'delivered' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-700 dark:text-green-100 dark:border-green-600',
                                'cancelled' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-700 dark:text-red-100 dark:border-red-600'
                            ];
                        @endphp
                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-lg border {{ $statusColors[$order->status] ?? 'bg-gray-300 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600' }}"> {{-- Added dark mode for default status --}}
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden"> {{-- Added dark:bg-gray-800 --}}
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700"> {{-- Added dark:border-gray-700 --}}
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Order Items ({{ $order->orderItems->count() }} items)</h2> {{-- Added dark:text-gray-100 --}}
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700"> {{-- Added dark:divide-gray-700 --}}
                            @foreach($order->orderItems as $item)
                                <div class="p-6 flex items-center space-x-4">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('img/products/' . $item->product->image) }}"
                                             alt="{{ $item->product_name }}"
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-300 dark:bg-gray-700 rounded-lg flex items-center justify-center"> {{-- Added dark:bg-gray-700 --}}
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"> {{-- Added dark:text-gray-500 --}}
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $item->product_name }}</h3> {{-- Added dark:text-gray-100 --}}
                                        <p class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $item->product_sku }}</p> {{-- Added dark:text-gray-400 --}}
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: {{ $item->quantity }}</p> {{-- Added dark:text-gray-400 --}}
                                    </div>

                                    <div class="text-right">
                                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">${{ number_format($item->price, 2) }}</p> {{-- Added dark:text-gray-100 --}}
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Each</p> {{-- Added dark:text-gray-400 --}}
                                    </div>

                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">${{ number_format($item->total, 2) }}</p> {{-- Added dark:text-gray-100 --}}
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Total</p> {{-- Added dark:text-gray-400 --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="px-6 py-4 bg-gray-300 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700"> {{-- Added dark:bg-gray-700, dark:border-gray-700 --}}
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal</span> {{-- Added dark:text-gray-400 --}}
                                    <span class="text-gray-900 dark:text-gray-100">${{ number_format($order->subtotal, 2) }}</span> {{-- Added dark:text-gray-100 --}}
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Tax</span> {{-- Added dark:text-gray-400 --}}
                                    <span class="text-gray-900 dark:text-gray-100">${{ number_format($order->tax_amount, 2) }}</span> {{-- Added dark:text-gray-100 --}}
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-gray-700 pt-2"> {{-- Added dark:border-gray-700 --}}
                                    <span class="text-gray-900 dark:text-gray-100">Total</span> {{-- Added dark:text-gray-100 --}}
                                    <span class="text-gray-900 dark:text-gray-100">${{ number_format($order->total_price, 2) }}</span> {{-- Added dark:text-gray-100 --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6"> {{-- Added dark:bg-gray-800 --}}
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Payment Information</h3> {{-- Added dark:text-gray-100 --}}
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Method</span> {{-- Added dark:text-gray-400 --}}
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p> {{-- Added dark:text-gray-100 --}}
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Status</span> {{-- Added dark:text-gray-400 --}}
                                <p class="text-sm font-medium {{ $order->payment_status === 'paid' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}"> {{-- Added dark:text-green-400 and dark:text-yellow-400 --}}
                                    {{ ucfirst($order->payment_status) }}
                                </p>
                            </div>
                            @if($order->payment_id)
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Transaction ID</span> {{-- Added dark:text-gray-400 --}}
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $order->payment_id }}</p> {{-- Added dark:text-gray-100 --}}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6"> {{-- Added dark:bg-gray-800 --}}
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Shipping Address</h3> {{-- Added dark:text-gray-100 --}}
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1"> {{-- Added dark:text-gray-400 --}}
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->customer_name }}</p> {{-- Added dark:text-gray-100 --}}
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                            <p>{{ $order->shipping_country }}</p>
                            @if($order->customer_phone)
                                <p class="mt-2">{{ $order->customer_phone }}</p>
                            @endif
                        </div>
                    </div>

                    @if($order->billing_address !== $order->shipping_address)
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6"> {{-- Added dark:bg-gray-800 --}}
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Billing Address</h3> {{-- Added dark:text-gray-100 --}}
                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1"> {{-- Added dark:text-gray-400 --}}
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->customer_name }}</p> {{-- Added dark:text-gray-100 --}}
                                <p>{{ $order->billing_address }}</p>
                                <p>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}</p>
                                <p>{{ $order->billing_country }}</p>
                            </div>
                        </div>
                    @endif

                    @if($order->notes)
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6"> {{-- Added dark:bg-gray-800 --}}
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Notes</h3> {{-- Added dark:text-gray-100 --}}
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->notes }}</p> {{-- Added dark:text-gray-400 --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
