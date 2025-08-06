<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen"> {{-- Added dark mode background and min-h-screen --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">My Orders</h1> {{-- Added dark:text-gray-100 --}}
                <p class="text-gray-600 dark:text-gray-400 mt-2">Track and manage your order history</p> {{-- Added dark:text-gray-400 --}}
            </div>

            @if($orders->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden"> {{-- Added dark:bg-gray-800 --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"> {{-- Added dark:divide-gray-700 --}}
                            <thead class="bg-gray-300 dark:bg-gray-700"> {{-- Added dark:bg-gray-700 --}}
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order</th> {{-- Added dark:text-gray-300 --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th> {{-- Added dark:text-gray-300 --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Items</th> {{-- Added dark:text-gray-300 --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th> {{-- Added dark:text-gray-300 --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th> {{-- Added dark:text-gray-300 --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th> {{-- Added dark:text-gray-300 --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"> {{-- Added dark:bg-gray-800, dark:divide-gray-700 --}}
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors duration-200"> {{-- Added dark:hover:bg-gray-700 --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">#{{ $order->order_number }}</div> {{-- Added dark:text-gray-100 --}}
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->orderItems->count() }} item(s)</div> {{-- Added dark:text-gray-400 --}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $order->created_at->format('M d, Y') }}</div> {{-- Added dark:text-gray-100 --}}
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('h:i A') }}</div> {{-- Added dark:text-gray-400 --}}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-gray-100"> {{-- Added dark:text-gray-100 --}}
                                                @foreach($order->orderItems->take(2) as $item)
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-xs bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full mr-2">{{ $item->quantity }}x</span> {{-- Added dark mode for badge --}}
                                                        <span class="truncate">{{ $item->product_name }}</span>
                                                    </div>
                                                @endforeach
                                                @if($order->orderItems->count() > 2)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">+{{ $order->orderItems->count() - 2 }} more items</div> {{-- Added dark:text-gray-400 --}}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">${{ number_format($order->total_price, 2) }}</div> {{-- Added dark:text-gray-100 --}}
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($order->payment_method) }}</div> {{-- Added dark:text-gray-400 --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                                    'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
                                                    'processing' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-700 dark:text-indigo-100',
                                                    'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-100',
                                                    'delivered' => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
                                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100'
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-100' }}"> {{-- Added dark mode for default status --}}
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('orders.show', $order->order_number) }}"
                                               class="text-indigo-600 hover:text-indigo-900 hover:underline transition-colors duration-200 dark:text-indigo-400 dark:hover:text-indigo-200"> {{-- Added dark mode text colors --}}
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 dark:text-gray-400"> {{-- Added dark:text-gray-400 for potential pagination text --}}
                    {{-- Note: Laravel's pagination rendering might need customization in its own view files
                         (e.g., by publishing them: php artisan vendor:publish --tag=laravel-pagination)
                         to fully support dark mode colors within the pagination links themselves.
                         The outer div has been given a dark text color for general visibility. --}}
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-gray-400 dark:text-gray-600 text-6xl mb-6">📦</div> {{-- Added dark:text-gray-600 --}}
                    <h3 class="text-2xl font-semibold text-gray-600 dark:text-gray-300 mb-4">No Orders Yet</h3> {{-- Added dark:text-gray-300 --}}
                    <p class="text-gray-500 dark:text-gray-400 mb-8">You haven't placed any orders yet. Start shopping to see your order history here.</p> {{-- Added dark:text-gray-400 --}}
                    <a href="{{ route('products.index') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 dark:bg-indigo-700 dark:hover:bg-indigo-600"> {{-- Added dark mode for button --}}
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
