@extends('layouts.seller')

@section('title', 'Return ' . $returnRequest->reference)

@section('content')
@php
    $badge = match($returnRequest->status) {
        'pending_seller_review' => ['bg-amber-100 text-amber-700 border-amber-200', 'Pending Your Review'],
        'approved'              => ['bg-blue-100 text-blue-700 border-blue-200', 'Approved'],
        'refunded'              => ['bg-green-100 text-green-700 border-green-200', 'Refunded'],
        'completed'             => ['bg-green-100 text-green-700 border-green-200', 'Completed'],
        'rejected'              => ['bg-red-100 text-red-700 border-red-200', 'Rejected'],
        'cancelled'             => ['bg-gray-100 text-gray-600 border-gray-200', 'Cancelled'],
        default                 => ['bg-gray-100 text-gray-600 border-gray-200', ucfirst($returnRequest->status)],
    };
@endphp

<div class="space-y-6 max-w-4xl">

    <a href="{{ route('seller.returns.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-pink-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Returns
    </a>

    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $returnRequest->reference }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Order #{{ $returnRequest->order->order_number }} · Customer: {{ $returnRequest->customer->name ?? 'Unknown' }}
                    · {{ $returnRequest->created_at->diffForHumans() }}
                </p>
            </div>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold border {{ $badge[0] }}">{{ $badge[1] }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            {{-- Items --}}
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
                <div class="px-5 py-3 bg-pink-50 border-b border-pink-100">
                    <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Items Customer Wants to Return</h2>
                </div>
                <div class="divide-y divide-pink-50">
                    @foreach($returnRequest->items as $item)
                    @php
                        $product = $item->orderItem->product ?? null;
                        $img = $product?->image ?? '';
                        $imgSrc = filter_var($img, FILTER_VALIDATE_URL) ? $img : (str_starts_with($img, 'storage/') ? asset($img) : asset('storage/' . $img));
                    @endphp
                    <div class="flex items-center gap-4 px-5 py-4">
                        <img src="{{ $imgSrc }}" alt="{{ $item->orderItem->product_name }}"
                             class="w-14 h-14 object-cover rounded-lg border border-pink-100"
                             onerror="this.src='https://placehold.co/100x100/fce7f3/db2777?text=?'">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->orderItem->product_name }}</p>
                            <p class="text-xs text-gray-400">SKU: {{ $item->orderItem->product_sku }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Returning {{ $item->quantity }} of {{ $item->orderItem->quantity }} ordered</p>
                        </div>
                        <p class="text-sm font-bold text-gray-900">${{ number_format($item->line_refund, 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Customer's reason --}}
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Customer's Reason</h2>
                <p class="text-sm font-semibold text-gray-900">{{ $returnRequest->reasonLabel() }}</p>
                @if($returnRequest->reason_description)
                <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-700 italic">"{{ $returnRequest->reason_description }}"</p>
                </div>
                @endif

                @if($returnRequest->attachments->isNotEmpty())
                <div class="mt-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Customer's Photos</p>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                        @foreach($returnRequest->attachments as $attachment)
                        <a href="{{ $attachment->url }}" target="_blank"
                           class="aspect-square rounded-lg overflow-hidden border border-pink-100 hover:opacity-80">
                            <img src="{{ $attachment->url }}" alt="" class="w-full h-full object-cover">
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Seller actions --}}
            @if($returnRequest->status === 'pending_seller_review')
            <div class="bg-amber-50 border-2 border-amber-200 rounded-2xl p-6">
                <h2 class="text-sm font-bold text-amber-800 uppercase tracking-wider mb-4">Action Required</h2>
                <p class="text-sm text-amber-700 mb-4">
                    Review the request and choose to approve (refund will be processed automatically) or reject with a reason.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    {{-- Approve --}}
                    <form action="{{ route('seller.returns.approve', $returnRequest) }}" method="POST"
                          onsubmit="return confirm('Approve this return and process the ${{ number_format($returnRequest->refund_amount, 2) }} refund?\n\nThis cannot be undone. The customer will be refunded and stock restored.')">
                        @csrf
                        <textarea name="seller_response" rows="2" placeholder="Optional message to customer..."
                                  class="w-full mb-2 border border-amber-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-300"></textarea>
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Approve & Refund ${{ number_format($returnRequest->refund_amount, 2) }}
                        </button>
                    </form>

                    {{-- Reject --}}
                    <form action="{{ route('seller.returns.reject', $returnRequest) }}" method="POST"
                          onsubmit="return confirm('Reject this return? The customer can dispute it with admin.')">
                        @csrf
                        <textarea name="seller_response" rows="2" required placeholder="Reason for rejection (required, min 5 chars)..."
                                  class="w-full mb-2 border border-amber-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-300"></textarea>
                        <button type="submit"
                                class="w-full bg-white hover:bg-red-50 border-2 border-red-200 text-red-700 font-bold py-2.5 rounded-xl text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reject Return
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Your response --}}
            @if($returnRequest->seller_response)
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">
                    Your Response
                    <span class="text-[10px] font-normal text-gray-400">{{ $returnRequest->seller_responded_at?->diffForHumans() }}</span>
                </h2>
                <p class="text-sm text-gray-700 italic">"{{ $returnRequest->seller_response }}"</p>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Summary --}}
            <div class="bg-gradient-to-br from-pink-600 to-rose-500 rounded-2xl p-6 text-white">
                <p class="text-pink-100 text-xs font-bold uppercase tracking-wider">Refund Amount</p>
                <p class="text-3xl font-extrabold mt-1">${{ number_format($returnRequest->refund_amount, 2) }}</p>
                <p class="text-pink-100 text-xs mt-1">
                    To: {{ $returnRequest->refund_method === 'store_credit' ? 'Store Credit' : ucwords(str_replace('_', ' ', $returnRequest->order->payment_method)) }}
                </p>
            </div>

            {{-- Impact on your wallet --}}
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Impact if Approved</h3>
                @php
                    $vendorOrder = $returnRequest->vendorOrder;
                    $proportionalLoss = $vendorOrder && $vendorOrder->subtotal > 0
                        ? round(($returnRequest->refund_amount / $vendorOrder->subtotal) * $vendorOrder->seller_earnings, 2)
                        : 0;
                @endphp
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Order subtotal</span>
                        <span>${{ number_format($vendorOrder->subtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Your earnings on this order</span>
                        <span class="text-green-600">${{ number_format($vendorOrder->seller_earnings ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-red-600 font-semibold border-t border-gray-100 pt-2 mt-2">
                        <span>Refund reversal</span>
                        <span>-${{ number_format($proportionalLoss, 2) }}</span>
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 mt-3">Stock for returned items will be restored automatically.</p>
            </div>

            {{-- Refund result --}}
            @if($returnRequest->refund)
            <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
                <h3 class="text-xs font-bold text-green-700 uppercase tracking-wider mb-2">Refund Processed</h3>
                <p class="text-xs text-green-700">
                    Ref: <span class="font-mono font-semibold">{{ $returnRequest->refund->reference }}</span><br>
                    Status: <span class="font-semibold">{{ ucfirst($returnRequest->refund->status) }}</span>
                </p>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
