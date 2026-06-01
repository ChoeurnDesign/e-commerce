<x-app-layout>
<div class="min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- ══ SUCCESS HERO ══ --}}
        <div class="bg-gradient-to-br from-pink-600 via-pink-500 to-rose-400 rounded-2xl shadow-lg px-8 py-10 text-center text-white">
            {{-- Checkmark --}}
            <div class="mx-auto mb-5 flex items-center justify-center w-16 h-16 rounded-full bg-white/20 ring-4 ring-white/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight mb-2">Order Confirmed!</h1>
            <p class="text-pink-100 text-sm mb-5">A confirmation email has been sent to <span class="font-semibold text-white">{{ $order->customer_email }}</span></p>

            {{-- Order number pill --}}
            <div class="inline-flex items-center gap-2 bg-white/15 border border-white/25 rounded-full px-5 py-2">
                <span class="text-xs text-pink-200 font-medium uppercase tracking-wider">Order</span>
                <span class="text-sm font-bold text-white">{{ $order->order_number }}</span>
            </div>

            {{-- Status badges --}}
            <div class="mt-4 flex items-center justify-center gap-2 flex-wrap">
                @php
                    $statusClasses = [
                        'pending'    => 'bg-yellow-100 text-yellow-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'confirmed'  => 'bg-green-100 text-green-800',
                        'shipped'    => 'bg-purple-100 text-purple-800',
                        'delivered'  => 'bg-green-100 text-green-800',
                        'cancelled'  => 'bg-red-100 text-red-800',
                    ];
                    $payStatusClasses = [
                        'paid'    => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'failed'  => 'bg-red-100 text-red-800',
                    ];
                    $orderStatusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700';
                    $payStatusClass   = $payStatusClasses[$order->payment_status] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $orderStatusClass }}">
                    {{ ucfirst($order->status) }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $payStatusClass }}">
                    Payment: {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>

        {{-- ══ MAIN CARD ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">

            {{-- Order meta strip --}}
            <div class="px-6 py-4 bg-pink-50 border-b border-pink-100 text-sm text-gray-500">
                Placed on <span class="font-medium text-gray-800">{{ $order->created_at->format('F j, Y') }}</span>
                at <span class="font-medium text-gray-800">{{ $order->created_at->format('g:i A') }}</span>
            </div>

            <div class="p-6 space-y-8">

                {{-- ── Items Ordered ── --}}
                <div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Items Ordered</h3>
                    <div class="divide-y divide-gray-100">
                        @foreach($order->orderItems as $item)
                        @php
                            $image = $item->product->image ?? '';
                            if (filter_var($image, FILTER_VALIDATE_URL)) {
                                $imgSrc = $image;
                            } elseif (!empty($image)) {
                                $imgSrc = str_starts_with($image, 'storage/') ? asset($image) : asset('storage/' . $image);
                            } else {
                                $imgSrc = 'https://placehold.co/400x400/fce7f3/db2777?text=No+Image';
                            }
                        @endphp
                        <div class="flex items-center gap-4 py-4">
                            <img src="{{ $imgSrc }}" alt="{{ $item->product_name }}"
                                 class="w-14 h-14 object-cover rounded-xl border border-pink-100 shrink-0"
                                 onerror="this.onerror=null;this.src='https://placehold.co/400x400/fce7f3/db2777?text=No+Image'">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->product_name }}</p>
                                @if($item->product_sku)
                                    <p class="text-xs text-gray-400 mt-0.5">SKU: {{ $item->product_sku }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-0.5">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-900 shrink-0">${{ number_format($item->total, 2) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── Delivery + Summary ── --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Delivery Details --}}
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Delivery Details</h3>

                        <div class="bg-pink-50 rounded-xl p-4 space-y-3 text-sm">
                            <div>
                                <p class="text-[11px] font-bold text-pink-400 uppercase tracking-wider mb-1">Contact</p>
                                <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                <p class="text-gray-500">{{ $order->customer_email }}</p>
                                @if($order->customer_phone)
                                    <p class="text-gray-500">{{ $order->customer_phone }}</p>
                                @endif
                            </div>

                            <div class="border-t border-pink-100 pt-3">
                                <p class="text-[11px] font-bold text-pink-400 uppercase tracking-wider mb-1">Shipping Address</p>
                                <p class="text-gray-800">{{ $order->shipping_address }}</p>
                                <p class="text-gray-500">{{ $order->shipping_city }}{{ $order->shipping_state ? ', '.$order->shipping_state : '' }} {{ $order->shipping_postal_code }}</p>
                                <p class="text-gray-500">{{ $order->shipping_country }}</p>
                            </div>

                            <div class="border-t border-pink-100 pt-3">
                                <p class="text-[11px] font-bold text-pink-400 uppercase tracking-wider mb-1">Payment Method</p>
                                <p class="text-gray-800">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Order Summary</h3>

                        <div class="bg-pink-50 rounded-xl p-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>

                            @if($order->discount_amount > 0)
                            <div class="flex justify-between text-green-600 font-medium">
                                <span>Discount{{ $order->coupon_code ? ' ('.$order->coupon_code.')' : '' }}</span>
                                <span>-${{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                            @endif

                            @if($order->tax_amount > 0)
                            <div class="flex justify-between text-gray-600">
                                <span>Tax</span>
                                <span>${{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600 font-semibold">Free</span>
                            </div>

                            <div class="border-t border-pink-200 pt-3 mt-1 flex justify-between font-bold text-gray-900 text-base">
                                <span>Total</span>
                                <span class="text-pink-600">${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                            <p class="text-[11px] font-bold text-amber-500 uppercase tracking-wider mb-1">Order Notes</p>
                            <p class="text-sm text-gray-600 italic">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- ══ ESTIMATED DELIVERY ══ --}}
        <div class="bg-white border border-pink-100 rounded-2xl p-5 flex items-center gap-4 shadow-sm">
            <div class="w-11 h-11 rounded-full bg-pink-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900 text-sm">Estimated Delivery</p>
                <p class="text-pink-600 font-medium text-sm mt-0.5">
                    {{ $order->created_at->addDays(3)->format('F j') }} – {{ $order->created_at->addDays(7)->format('F j, Y') }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">We'll send you tracking information once your order ships.</p>
            </div>
        </div>

        {{-- ══ ACTION BUTTONS ══ --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pb-4">
            <a href="{{ route('products.index') }}"
               class="flex items-center justify-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-4 rounded-xl transition text-sm text-center shadow-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Continue Shopping
            </a>
            <a href="{{ route('orders.show', $order->order_number) }}"
               class="flex items-center justify-center gap-2 bg-white hover:bg-pink-50 border border-pink-200 text-pink-700 font-semibold py-3 px-4 rounded-xl transition text-sm text-center shadow-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                View Order
            </a>
            <a href="{{ route('orders.history') }}"
               class="flex items-center justify-center gap-2 bg-white hover:bg-pink-50 border border-pink-200 text-pink-700 font-semibold py-3 px-4 rounded-xl transition text-sm text-center shadow-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Order History
            </a>
        </div>

    </div>
</div>
</x-app-layout>
