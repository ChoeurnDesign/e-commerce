<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <p class="text-gray-600 mt-2">Track and manage your order history</p>
            </div>

            @if($orders->count() > 0)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-rose-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-rose-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                                                <div class="text-sm text-gray-500">{{ $order->orderItems->count() }} item(s)</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                @foreach($order->orderItems->take(2) as $item)
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-xs bg-rose-100 text-rose-700 px-2 py-1 rounded-full mr-2">{{ $item->quantity }}x</span>
                                                        <span class="truncate">{{ $item->product_name }}</span>
                                                        <span class="ml-2 text-xs text-gray-600">
                                                            {{ \App\Helpers\CurrencyHelper::format($item->price) }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                                @if($order->orderItems->count() > 2)
                                                    <div class="text-xs text-gray-500">+{{ $order->orderItems->count() - 2 }} more items</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \App\Helpers\CurrencyHelper::format($order->total_price) }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ ucfirst($order->payment_method) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                                    'processing' => 'bg-pink-100 text-pink-700',
                                                    'shipped' => 'bg-purple-100 text-purple-800',
                                                    'delivered' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800'
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-rose-100 text-rose-700' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex flex-col gap-2">
                                            <a href="{{ route('orders.show', $order->order_number) }}"
                                               class="text-pink-600 hover:text-pink-800 hover:underline transition-colors duration-200">
                                                View Details
                                            </a>

                                            {{-- Confirm Receipt Action --}}
                                            @if(in_array($order->status, ['delivered', 'shipped', 'confirmed']))
                                                <form action="{{ route('orders.confirm', $order->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="button"
                                                        onclick="Swal.fire({
                                                            title: 'Confirm Receipt?',
                                                            text: 'You acknowledge that you received all items.',
                                                            icon: 'question',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#16a34a',
                                                            cancelButtonColor: '#6b7280',
                                                            confirmButtonText: 'Yes, received',
                                                            cancelButtonText: 'Cancel',
                                                        }).then(r => { if (r.isConfirmed) this.closest('form').submit(); })"
                                                        class="text-green-600 hover:text-green-800 text-xs font-bold uppercase tracking-tight">
                                                        Confirm Receipt
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-gray-400 text-6xl mb-6">📦</div>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">No Orders Yet</h3>
                    <p class="text-gray-500 mb-8">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                    <a href="{{ route('products.index') }}"
                       class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
