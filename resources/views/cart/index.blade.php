<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
                <p class="text-gray-600 mt-2">Review your items and proceed to checkout</p>
            </div>
            {{-- Cart change notices (price/stock/removed) --}}
            @if(session('cart_changes'))
                <div class="mb-6 bg-amber-50 border border-amber-300 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold text-amber-800 text-sm mb-2">Your cart was updated — please review the changes below:</p>
                            <ul class="space-y-1">
                                @foreach(session('cart_changes') as $change)
                                    <li class="text-sm text-amber-700">
                                        @if($change['type'] === 'removed')
                                            <span class="font-medium">{{ $change['name'] }}</span> was removed — {{ $change['reason'] }}.
                                        @elseif($change['type'] === 'price')
                                            <span class="font-medium">{{ $change['name'] }}</span> price changed from
                                            <span class="line-through">${{ number_format($change['old_price'], 2) }}</span>
                                            to <span class="font-semibold text-amber-900">${{ number_format($change['new_price'], 2) }}</span>.
                                        @elseif($change['type'] === 'stock')
                                            <span class="font-medium">{{ $change['name'] }}</span> quantity reduced from
                                            {{ $change['old_qty'] }} to <span class="font-semibold">{{ $change['new_qty'] }}</span> (limited stock).
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if(!empty($cartItems))
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        @include('cart.partials.items', ['cartItems' => $cartItems, 'cartTotals' => $cartTotals])
                    </div>
                    <div>
                        @include('cart.partials.summary', ['cartTotals' => $cartTotals])
                    </div>
                </div>
            @else
                @include('cart.partials.empty')
            @endif
        </div>
    </div>
    @push('scripts')
        @include('cart.partials.scripts', ['cartTotals' => $cartTotals])
    @endpush
</x-app-layout>
