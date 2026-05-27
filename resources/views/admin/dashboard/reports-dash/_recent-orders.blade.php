<div class="bg-white dark:bg-[#23263a] shadow p-6 rounded-xl border border-gray-200 dark:border-transparent">
    <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Recent Orders</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full overflow-hidden">
            <thead>
                {{-- Fixed: Changed harsh bg-gray-300 to clean bg-gray-100 for light mode --}}
                <tr class="bg-gray-100 dark:bg-[#232c47] border-b border-gray-200 dark:border-[#23263a]">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order #</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-[#232c47]">
                @forelse ($recentOrders->take(5) as $order)
                    {{-- Fixed: Changed harsh hover:bg-gray-300 to smooth hover:bg-gray-50 for light mode --}}
                    <tr class="hover:bg-gray-50 dark:hover:bg-[#222842] transition-colors duration-150">
                        <td class="px-5 py-3 text-gray-900 dark:text-white font-mono font-medium">{{ $order->order_number }}</td>
                        <td class="px-5 py-3 text-gray-700 dark:text-gray-200 font-medium">{{ $order->customer_name ?? ($order->user->name ?? '-') }}</td>
                        <td class="px-5 py-3 text-gray-700 dark:text-gray-200">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
    {{ $order->payment_status == 'paid' 
        ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' 
        : ($order->payment_status == 'pending' 
            ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' 
            : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
    {{ ucfirst($order->payment_status) }}
</span>
                        </td>
                        <td class="px-5 py-3 text-gray-700 dark:text-gray-200">{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        {{-- Fixed: Changed text-gray-100 to text-gray-500 so text isn't hidden on white background --}}
                        <td colspan="5" class="text-center text-gray-500 dark:text-gray-300 py-8 italic">No recent orders.</td>
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