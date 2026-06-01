<x-app-layout>
@php
    $steps = [
        ['key' => 'pending',    'label' => 'Order Placed',    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['key' => 'confirmed',  'label' => 'Confirmed',       'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['key' => 'shipped',    'label' => 'Shipped',         'icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0'],
        ['key' => 'delivered',  'label' => 'Delivered',       'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['key' => 'completed',  'label' => 'Completed',       'icon' => 'M5 13l4 4L19 7'],
    ];

    $statusOrder = ['pending', 'processing', 'confirmed', 'shipped', 'delivered', 'completed'];
    $currentIdx  = array_search($order->status, $statusOrder);
    if ($currentIdx === false) $currentIdx = -1;

    // Map status to step index (processing maps to pending step)
    $stepMap = ['pending' => 0, 'processing' => 0, 'confirmed' => 1, 'shipped' => 2, 'delivered' => 3, 'completed' => 4];
    $activeStep = $stepMap[$order->status] ?? -1;
    $isCancelled = $order->status === 'cancelled';
@endphp

<div class="py-6 sm:py-8 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Back --}}
        <a href="{{ route('orders.history') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-pink-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>

        {{-- ══ ORDER HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">#{{ $order->order_number }}</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Placed {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>

                @if(in_array($order->status, ['delivered', 'shipped', 'confirmed']))
                    <form action="{{ route('orders.confirm', $order->id) }}" method="POST" id="confirmReceiptForm">
                        @csrf
                        <button type="button" onclick="confirmReceipt()"
                                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Confirm Receipt
                        </button>
                    </form>
                @elseif($order->status === 'completed')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-xl bg-green-100 text-green-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Completed
                    </span>
                    @php
                        $deliveredAt = $order->delivered_at ?? $order->updated_at;
                        $eligibleForReturn = $deliveredAt && $deliveredAt->diffInDays(now()) <= 7;
                        $vendorOrders = $order->vendorOrders ?? collect();
                    @endphp
                    @if($eligibleForReturn && $vendorOrders->isNotEmpty())
                        @foreach($vendorOrders as $vo)
                        <a href="{{ route('returns.create', ['order' => $order->id, 'vendorOrder' => $vo->id]) }}"
                           class="bg-white hover:bg-pink-50 border border-pink-200 text-pink-700 px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                            Request Return
                        </a>
                        @endforeach
                    @endif
                @elseif($isCancelled)
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-xl bg-red-100 text-red-700">Cancelled</span>
                @else
                    <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-xl bg-amber-100 text-amber-700">{{ ucfirst($order->status) }}</span>
                @endif
            </div>

            {{-- ══ STATUS TRACKER ══ --}}
            @unless($isCancelled)
            <div class="px-6 py-5 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center justify-between max-w-2xl mx-auto">
                    @foreach($steps as $idx => $step)
                        @php
                            $isDone    = $activeStep > $idx;
                            $isCurrent = $activeStep === $idx;
                            $isPending = $activeStep < $idx;

                            $circleClass = $isDone
                                ? 'bg-green-500 text-white'
                                : ($isCurrent ? 'bg-pink-500 text-white ring-4 ring-pink-100' : 'bg-gray-200 text-gray-400');
                            $textClass = ($isDone || $isCurrent) ? 'text-gray-800 font-semibold' : 'text-gray-400';
                        @endphp

                        <div class="flex flex-col items-center relative z-10">
                            {{-- Circle --}}
                            <div class="w-9 h-9 rounded-full flex items-center justify-center {{ $circleClass }} transition-all">
                                @if($isDone)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                    </svg>
                                @endif
                            </div>
                            {{-- Label --}}
                            <span class="text-[10px] mt-1.5 {{ $textClass }} text-center leading-tight">{{ $step['label'] }}</span>
                            @if($isCurrent && $order->status === 'shipped' && $order->shipped_at)
                                <span class="text-[9px] text-pink-500 mt-0.5">{{ $order->shipped_at->format('M d') }}</span>
                            @elseif($isCurrent && $order->status === 'delivered' && $order->delivered_at)
                                <span class="text-[9px] text-pink-500 mt-0.5">{{ $order->delivered_at->format('M d') }}</span>
                            @endif
                        </div>

                        {{-- Connector line --}}
                        @if(!$loop->last)
                            <div class="flex-1 h-0.5 mx-1 {{ $activeStep > $idx ? 'bg-green-400' : 'bg-gray-200' }} transition-all"></div>
                        @endif
                    @endforeach
                </div>
            </div>
            @else
                <div class="px-6 py-4 bg-red-50 border-t border-red-100 text-center">
                    <p class="text-sm text-red-600 font-medium">This order has been cancelled.</p>
                </div>
            @endunless
        </div>

        {{-- ══ PAYMENT INFO ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                        <p class="text-xs text-gray-400">Payment Method</p>
                    </div>
                </div>
                @php
                    $payBadge = match($order->payment_status) {
                        'paid'                  => 'bg-green-100 text-green-700',
                        'pending'               => 'bg-amber-100 text-amber-700',
                        'awaiting_verification' => 'bg-blue-100 text-blue-700',
                        'failed'                => 'bg-red-100 text-red-700',
                        default                 => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $payBadge }}">
                    {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ══ LEFT: ITEMS ══ --}}
            <div class="lg:col-span-2 space-y-4">
                @php
                    $groupedItems = $order->orderItems->groupBy(fn($item) => $item->product->seller_id ?? 0);
                @endphp

                @foreach($groupedItems as $sellerId => $items)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Seller header --}}
                    <div class="px-5 py-3 bg-pink-50/50 border-b border-pink-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Seller</span>
                        <span class="text-sm font-semibold text-gray-800">
                            {{ $items->first()->product->seller->store_name ?? 'Store' }}
                        </span>
                    </div>

                    {{-- Items --}}
                    <div class="divide-y divide-gray-50">
                        @foreach($items as $item)
                        @php
                            $img = $item->product->image ?? '';
                            $imgSrc = filter_var($img, FILTER_VALIDATE_URL) ? $img : (str_starts_with($img, 'storage/') ? asset($img) : asset('storage/' . $img));
                        @endphp
                        <div class="flex items-center gap-4 px-5 py-4">
                            <img src="{{ $imgSrc }}" alt="{{ $item->product_name }}"
                                 class="w-14 h-14 object-cover rounded-xl border border-gray-100 shrink-0"
                                 onerror="this.onerror=null;this.src='https://placehold.co/100x100/f3f4f6/9ca3af?text=?'">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">SKU: {{ $item->product_sku }} · Qty: {{ $item->quantity }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-900 shrink-0">{{ \App\Helpers\CurrencyHelper::format($item->total) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ══ RIGHT: SUMMARY + SHIPPING ══ --}}
            <div class="space-y-4">

                {{-- Summary --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Order Summary</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>{{ \App\Helpers\CurrencyHelper::format($order->subtotal) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-green-600 font-medium">
                            <span>Discount{{ $order->coupon_code ? ' ('.$order->coupon_code.')' : '' }}</span>
                            <span>-{{ \App\Helpers\CurrencyHelper::format($order->discount_amount) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-gray-600">
                            <span>Tax</span>
                            <span>{{ \App\Helpers\CurrencyHelper::format($order->tax_amount ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="text-green-600 font-medium">Free</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 mt-2 flex justify-between font-bold text-gray-900 text-base">
                            <span>Total</span>
                            <span class="text-pink-600">{{ \App\Helpers\CurrencyHelper::format($order->total_price) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Shipping --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Shipping Info</h3>
                    <div class="space-y-1.5 text-sm">
                        <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                        <p class="text-gray-500">{{ $order->shipping_address }}</p>
                        <p class="text-gray-500">{{ $order->shipping_city }}{{ $order->shipping_state ? ', '.$order->shipping_state : '' }} {{ $order->shipping_postal_code }}</p>
                        <p class="text-gray-500">{{ $order->shipping_country }}</p>
                        @if($order->customer_phone)
                            <p class="text-gray-500 pt-1">{{ $order->customer_phone }}</p>
                        @endif
                    </div>
                </div>

                {{-- Notes --}}
                @if($order->notes)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Order Notes</h3>
                    <p class="text-sm text-gray-600 italic">{{ $order->notes }}</p>
                </div>
                @endif

                {{-- Estimated Delivery (show for active orders) --}}
                @if(in_array($order->status, ['pending', 'processing', 'confirmed', 'shipped']))
                <div class="bg-pink-50 border border-pink-100 rounded-2xl p-5 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Estimated Delivery</p>
                        <p class="text-sm text-pink-600 font-medium mt-0.5">
                            {{ $order->created_at->addDays(3)->format('M d') }} – {{ $order->created_at->addDays(7)->format('M d, Y') }}
                        </p>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmReceipt() {
    Swal.fire({
        title: 'Confirm Receipt?',
        text: 'By confirming, you acknowledge that you have received all items in this order.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, I received it',
        cancelButtonText: 'Cancel',
    }).then(result => {
        if (result.isConfirmed) document.getElementById('confirmReceiptForm').submit();
    });
}
</script>
@endpush
</x-app-layout>
