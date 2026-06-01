<x-app-layout>
<div class="py-6 sm:py-8 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Returns & Refunds</h1>
                <p class="text-sm text-gray-500 mt-1">Track your return requests and refund status</p>
            </div>
            <a href="{{ route('orders.history') }}"
               class="text-sm text-pink-600 hover:text-pink-700 font-medium">← Back to Orders</a>
        </div>

        @if($returns->count())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-100">
                @foreach($returns as $return)
                @php
                    $statusBadge = match($return->status) {
                        'pending_seller_review' => ['bg-amber-100 text-amber-700', 'Pending Review'],
                        'approved'              => ['bg-blue-100 text-blue-700', 'Approved'],
                        'refunded'              => ['bg-green-100 text-green-700', 'Refunded'],
                        'completed'             => ['bg-green-100 text-green-700', 'Completed'],
                        'rejected'              => ['bg-red-100 text-red-700', 'Rejected'],
                        'cancelled'             => ['bg-gray-100 text-gray-600', 'Cancelled'],
                        'disputed'              => ['bg-purple-100 text-purple-700', 'Disputed'],
                        default                 => ['bg-gray-100 text-gray-600', ucfirst($return->status)],
                    };
                @endphp
                <a href="{{ route('returns.show', $return) }}"
                   class="block px-5 py-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-sm font-bold text-gray-900">{{ $return->reference }}</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $statusBadge[0] }}">{{ $statusBadge[1] }}</span>
                            </div>
                            <p class="text-xs text-gray-500">
                                For order <span class="font-medium text-gray-700">#{{ $return->order->order_number }}</span>
                                · {{ $return->seller->store_name ?? 'Seller' }}
                                · {{ $return->created_at->diffForHumans() }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Reason: {{ $return->reasonLabel() }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-pink-600">${{ number_format($return->refund_amount, 2) }}</p>
                            <p class="text-[10px] text-gray-400">Refund amount</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            @if($returns->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                {{ $returns->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="w-14 h-14 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">No return requests yet</h3>
            <p class="text-sm text-gray-400 mb-6">You haven't requested any returns. If you have an issue with an order, you can request a return from your order details.</p>
            <a href="{{ route('orders.history') }}"
               class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold">
                View My Orders
            </a>
        </div>
        @endif

    </div>
</div>
</x-app-layout>
