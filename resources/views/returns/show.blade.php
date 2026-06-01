<x-app-layout>
@php
    $statusBadge = match($returnRequest->status) {
        'pending_seller_review' => ['bg-amber-100 text-amber-700 border-amber-200', 'Pending Seller Review'],
        'approved'              => ['bg-blue-100 text-blue-700 border-blue-200', 'Approved'],
        'refunded'              => ['bg-green-100 text-green-700 border-green-200', 'Refunded'],
        'completed'             => ['bg-green-100 text-green-700 border-green-200', 'Completed'],
        'rejected'              => ['bg-red-100 text-red-700 border-red-200', 'Rejected'],
        'cancelled'             => ['bg-gray-100 text-gray-600 border-gray-200', 'Cancelled'],
        'disputed'              => ['bg-purple-100 text-purple-700 border-purple-200', 'Disputed'],
        default                 => ['bg-gray-100 text-gray-600 border-gray-200', ucfirst($returnRequest->status)],
    };
@endphp

<div class="py-6 sm:py-8 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <a href="{{ route('returns.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-pink-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Returns
        </a>

        {{-- Header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $returnRequest->reference }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        For order <a href="{{ route('orders.show', $returnRequest->order->order_number) }}" class="text-pink-600 font-medium hover:underline">#{{ $returnRequest->order->order_number }}</a>
                        · {{ $returnRequest->created_at->format('M d, Y g:i A') }}
                    </p>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold border {{ $statusBadge[0] }}">
                    {{ $statusBadge[1] }}
                </span>
            </div>
        </div>

        {{-- Refund amount --}}
        <div class="bg-gradient-to-br from-pink-600 to-rose-500 rounded-2xl p-6 text-white shadow-sm">
            <p class="text-pink-100 text-xs font-semibold uppercase tracking-wider">Refund Amount</p>
            <p class="text-3xl font-extrabold mt-1">${{ number_format($returnRequest->refund_amount, 2) }}</p>
            <p class="text-pink-100 text-sm mt-1">
                Method: {{ $returnRequest->refund_method === 'store_credit' ? 'Store Credit' : 'Original Payment ('.ucwords(str_replace('_', ' ', $returnRequest->order->payment_method)).')' }}
            </p>
        </div>

        {{-- Items being returned --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Items Being Returned</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($returnRequest->items as $item)
                @php
                    $product = $item->orderItem->product ?? null;
                    $img = $product?->image ?? '';
                    $imgSrc = filter_var($img, FILTER_VALIDATE_URL) ? $img : (str_starts_with($img, 'storage/') ? asset($img) : asset('storage/' . $img));
                @endphp
                <div class="flex items-center gap-4 px-5 py-4">
                    <img src="{{ $imgSrc }}" alt="{{ $item->orderItem->product_name }}"
                         class="w-12 h-12 object-cover rounded-lg border border-gray-200"
                         onerror="this.src='https://placehold.co/100x100/f3f4f6/9ca3af?text=?'">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->orderItem->product_name }}</p>
                        <p class="text-xs text-gray-400">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_refund, 2) }}</p>
                    </div>
                    <p class="text-sm font-bold text-gray-900">${{ number_format($item->line_refund, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Reason --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Reason</h2>
            <p class="text-sm font-semibold text-gray-900">{{ $returnRequest->reasonLabel() }}</p>
            @if($returnRequest->reason_description)
                <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $returnRequest->reason_description }}</p>
            @endif

            @if($returnRequest->attachments->isNotEmpty())
            <div class="mt-4 grid grid-cols-3 sm:grid-cols-4 gap-2">
                @foreach($returnRequest->attachments as $attachment)
                <a href="{{ $attachment->url }}" target="_blank" class="aspect-square rounded-lg overflow-hidden border border-gray-200 hover:opacity-80">
                    <img src="{{ $attachment->url }}" alt="" class="w-full h-full object-cover">
                </a>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Seller response --}}
        @if($returnRequest->seller_response)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">
                Seller Response
                <span class="text-[10px] font-normal text-gray-400 ml-1">{{ $returnRequest->seller_responded_at?->diffForHumans() }}</span>
            </h2>
            <p class="text-sm text-gray-700 italic">"{{ $returnRequest->seller_response }}"</p>
        </div>
        @endif

        {{-- Refund details --}}
        @if($returnRequest->refund)
        <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-bold text-green-800">Refund Issued</p>
                    <p class="text-xs text-green-700 mt-1">
                        Reference: <span class="font-mono">{{ $returnRequest->refund->reference }}</span>
                        · Status: <span class="font-semibold">{{ ucfirst($returnRequest->refund->status) }}</span>
                    </p>
                    @if($returnRequest->refund->notes)
                        <p class="text-xs text-green-700 mt-2">{{ $returnRequest->refund->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Actions --}}
        @if(in_array($returnRequest->status, ['pending_seller_review', 'approved']))
        <form action="{{ route('returns.cancel', $returnRequest) }}" method="POST"
              onsubmit="return confirm('Cancel this return request?')">
            @csrf
            <button type="submit"
                    class="w-full bg-white border border-red-200 text-red-600 hover:bg-red-50 py-2.5 rounded-xl text-sm font-semibold">
                Cancel Return Request
            </button>
        </form>
        @endif

    </div>
</div>
</x-app-layout>
