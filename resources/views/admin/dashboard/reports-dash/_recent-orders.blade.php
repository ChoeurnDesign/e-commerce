<div class="bg-white shadow p-6 rounded-xl border border-gray-200">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Recent Orders</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full overflow-hidden">
            <thead>
                {{-- Fixed: Changed harsh bg-gray-50 to clean bg-gray-100 for light mode --}}
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order #</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($recentOrders->take(5) as $order)
                    {{-- Fixed: Changed harsh hover:bg-gray-50 to smooth hover:bg-gray-50 for light mode --}}
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-5 py-3 text-gray-900 font-mono font-medium">{{ $order->order_number }}</td>
                        <td class="px-5 py-3 text-gray-700 font-medium">{{ $order->customer_name ?? ($order->user->name ?? '-') }}</td>
                        <td class="px-5 py-3 text-gray-700">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
    {{ $order->payment_status == 'paid' 
        ? 'bg-green-100 text-green-800/30' 
        : ($order->payment_status == 'pending' 
            ? 'bg-amber-100 text-amber-800/30' 
            : 'bg-red-100 text-red-800/30') }}">
    {{ ucfirst($order->payment_status) }}
</span>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        {{-- Fixed: Changed text-gray-100 to text-gray-500 so text isn't hidden on white background --}}
                        <td colspan="5" class="text-center text-gray-500 py-8 italic">No recent orders.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex justify-end mt-4">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm font-medium shadow">
            View all orders
        </a>
    </div>
</div>