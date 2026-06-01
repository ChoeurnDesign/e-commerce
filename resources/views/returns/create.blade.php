<x-app-layout>
<div class="py-6 sm:py-8 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <a href="{{ route('orders.show', $order->order_number) }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-pink-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Order
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h1 class="text-xl font-bold text-gray-900">Request Return</h1>
            <p class="text-sm text-gray-500 mt-1">
                For order <span class="font-semibold text-gray-800">#{{ $order->order_number }}</span>
                · from <span class="font-semibold text-gray-800">{{ $items->first()->product->seller->store_name ?? 'Seller' }}</span>
            </p>
        </div>

        <form action="{{ route('returns.store', ['order' => $order->id, 'vendorOrder' => $vendorOrder->id]) }}"
              method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Items to return --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Select Items to Return</h2>
                <div class="space-y-3">
                    @foreach($items as $idx => $item)
                    @php
                        $img = $item->product->image ?? '';
                        $imgSrc = filter_var($img, FILTER_VALIDATE_URL) ? $img : (str_starts_with($img, 'storage/') ? asset($img) : asset('storage/' . $img));
                    @endphp
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <img src="{{ $imgSrc }}" alt="{{ $item->product_name }}"
                             class="w-14 h-14 object-cover rounded-lg border border-gray-200 shrink-0"
                             onerror="this.src='https://placehold.co/100x100/f3f4f6/9ca3af?text=?'">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-400">${{ number_format($item->price, 2) }} × ordered {{ $item->quantity }}</p>
                        </div>
                        <input type="hidden" name="items[{{ $idx }}][order_item_id]" value="{{ $item->id }}">
                        <div class="flex items-center gap-2 shrink-0">
                            <label class="text-xs text-gray-500">Qty to return:</label>
                            <input type="number" name="items[{{ $idx }}][quantity]"
                                   min="0" max="{{ $item->quantity }}" value="0"
                                   class="w-16 px-2 py-1 border border-gray-200 rounded-lg text-center text-sm focus:ring-2 focus:ring-pink-300">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Reason --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Reason for Return</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-4">
                    @foreach(\App\Models\ReturnRequest::REASON_LABELS as $code => $label)
                    <label class="flex items-center gap-2 px-3 py-2.5 border border-gray-200 rounded-xl cursor-pointer hover:border-pink-300 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50">
                        <input type="radio" name="reason_code" value="{{ $code }}"
                               class="text-pink-600 focus:ring-pink-400" {{ $loop->first ? 'required' : '' }}>
                        <span class="text-sm text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Details (optional)</label>
                    <textarea name="reason_description" rows="3" placeholder="Tell us more about the issue..."
                              class="mt-1 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-pink-300"></textarea>
                </div>

                <div class="mt-4">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Upload Photos (optional)</label>
                    <input type="file" name="attachments[]" multiple accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                  file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-700
                                  hover:file:bg-pink-100">
                    <p class="text-xs text-gray-400 mt-1">Photos help the seller process your return faster.</p>
                </div>
            </div>

            {{-- Refund method --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">How should we refund you?</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-pink-300 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50">
                        <input type="radio" name="refund_method" value="original_payment" checked
                               class="mt-0.5 text-pink-600 focus:ring-pink-400">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Original payment method</p>
                            <p class="text-xs text-gray-500 mt-0.5">Refunded to {{ ucwords(str_replace('_', ' ', $order->payment_method)) }} (3–7 business days)</p>
                        </div>
                    </label>
                    <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-pink-300 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50">
                        <input type="radio" name="refund_method" value="store_credit"
                               class="mt-0.5 text-pink-600 focus:ring-pink-400">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Store credit</p>
                            <p class="text-xs text-gray-500 mt-0.5">Instant — use for any future purchase</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-xl transition shadow-sm">
                    Submit Return Request
                </button>
                <a href="{{ route('orders.show', $order->order_number) }}"
                   class="px-6 py-3 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium">Cancel</a>
            </div>
        </form>

    </div>
</div>
</x-app-layout>
