<div class="bg-white dark:bg-[#23263a] shadow p-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Recent Orders</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full overflow-hidden">
            <thead>
                <tr class="bg-gray-300 dark:bg-[#232c47]">
                    <th class="px-5 py-3 text-left text-sm text-gray-900 dark:text-white uppercase tracking-wider">Order #</th>
                    <th class="px-5 py-3 text-left text-sm text-gray-900 dark:text-white uppercase tracking-wider">Customer</th>
                    <th class="px-5 py-3 text-left text-sm text-gray-900 dark:text-white uppercase tracking-wider">Total</th>
                    <th class="px-5 py-3 text-left text-sm text-gray-900 dark:text-white uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-sm text-gray-900 dark:text-white uppercase tracking-wider">Order Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-[#232c47]">
                @forelse ($recentOrders->take(5) as $order)
                    <tr class="hover:bg-gray-300 dark:hover:bg-[#222842] transition-colors">
                        <td class="px-5 py-3 text-gray-900 dark:text-white font-mono">{{ $order->order_number }}</td>
                        <td class="px-5 py-3 text-gray-700 dark:text-gray-200">{{ $order->customer_name ?? ($order->user->name ?? '-') }}</td>
                        <td class="px-5 py-3 text-gray-700 dark:text-gray-200">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-5 py-3">
                            <span class="
                                inline-block px-3 py-1 rounded-lg text-xs font-semibold
                                bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700
                                dark:bg-{{ $order->status_color }}-600 dark:text-white
                                border border-transparent dark:border-{{ $order->status_color }}-400
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-700 dark:text-gray-200">{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-100 dark:text-gray-300 py-8">No recent orders.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex justify-end mt-4">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition dark:bg-indigo-500 dark:hover:bg-indigo-400 text-sm font-medium shadow">
            View all orders
        </a>
    </div>
</div>
