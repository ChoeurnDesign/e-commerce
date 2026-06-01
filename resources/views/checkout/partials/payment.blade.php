<div id="step-2" style="display:none;">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Payment') }}</h2>

    {{-- Order Summary --}}
    <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ __('Order Summary') }}</h4>
        <div class="bg-rose-50 p-4 rounded-lg">
            @foreach($cartItems as $item)
                <div class="flex justify-between mb-2 text-sm">
                    <span class="text-gray-700">{{ $item['name'] }} <span class="text-gray-400">×{{ $item['quantity'] }}</span></span>
                    <span class="text-gray-700">{{ \App\Helpers\CurrencyHelper::format($item['subtotal']) }}</span>
                </div>
            @endforeach

            <div class="border-t border-gray-200 mt-3 pt-3 space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>{{ __('Subtotal') }}</span>
                    <span>{{ \App\Helpers\CurrencyHelper::format($cartTotals['subtotal']) }}</span>
                </div>

                <div id="discount-row" class="{{ $cartTotals['discount_amount'] > 0 ? '' : 'hidden' }} flex justify-between text-sm text-green-600 font-medium">
                    <span>{{ __('Discount') }} (<span id="coupon-code-label">{{ $cartTotals['coupon_code'] }}</span>)</span>
                    <span>-{{ \App\Helpers\CurrencyHelper::format($cartTotals['discount_amount']) }}</span>
                </div>

                <div class="flex justify-between text-sm text-gray-600">
                    <span>{{ __('Tax') }} ({{ number_format($cartTotals['tax_rate'] * 100, 1) }}%)</span>
                    <span>{{ \App\Helpers\CurrencyHelper::format($cartTotals['tax']) }}</span>
                </div>

                <div class="flex justify-between font-bold text-gray-900 text-base pt-1 border-t border-gray-200">
                    <span>{{ __('Total') }}</span>
                    <span id="order-total-display">{{ \App\Helpers\CurrencyHelper::format($cartTotals['total']) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Coupon Code --}}
    <div class="mb-6">
        <h4 class="text-sm font-semibold text-gray-700 mb-2">{{ __('Have a coupon?') }}</h4>
        <div class="flex gap-2">
            <input type="text" id="coupon-input" placeholder="{{ __('Enter coupon code') }}"
                   class="flex-1 rounded-lg border border-gray-300 bg-white text-gray-900 px-3 py-2 text-sm focus:ring-pink-400 focus:border-pink-400 uppercase"
                   value="{{ $cartTotals['coupon_code'] ?? '' }}">
            <button type="button" id="apply-coupon-btn"
                    class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-semibold transition-colors">
                {{ __('Apply') }}
            </button>
            <button type="button" id="remove-coupon-btn"
                    class="{{ $cartTotals['coupon_code'] ? '' : 'hidden' }} px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg text-sm font-semibold transition-colors">
                ✕
            </button>
        </div>
        <p id="coupon-message" class="mt-1 text-xs {{ $cartTotals['coupon_code'] ? 'text-green-600' : 'text-red-500' }}">
            {{ $cartTotals['coupon_code'] ? __('Coupon applied!') : '' }}
        </p>
        <input type="hidden" name="coupon_code" id="coupon-hidden" value="{{ $cartTotals['coupon_code'] ?? '' }}">
    </div>

    {{-- ═══ PAYMENT METHODS ════════════════════════════════════════════ --}}
    <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-3">{{ __('Payment Method') }}</h4>

        <div class="space-y-3" x-data="{ selected: 'cash_on_delivery' }">

            {{-- ① COD — recommended for first-time / local customers --}}
            <label class="block cursor-pointer">
                <div class="flex items-start gap-3 p-4 rounded-xl border-2 transition-all"
                     :class="selected === 'cash_on_delivery' ? 'border-pink-500 bg-pink-50/40' : 'border-gray-200 bg-white hover:border-pink-300'">
                    <input type="radio" name="payment_method" value="cash_on_delivery"
                           x-model="selected" class="mt-1 text-pink-600 focus:ring-pink-400" required>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">💵</span>
                            <span class="font-bold text-gray-900">{{ __('Cash on Delivery') }}</span>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">{{ __('Recommended') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Pay in cash when the product arrives. No signup or upfront payment required.') }}</p>
                    </div>
                </div>
            </label>

            {{-- ② Bank Transfer --}}
            <label class="block cursor-pointer">
                <div class="rounded-xl border-2 transition-all"
                     :class="selected === 'bank_transfer' ? 'border-pink-500 bg-pink-50/40' : 'border-gray-200 bg-white hover:border-pink-300'">
                    <div class="flex items-start gap-3 p-4">
                        <input type="radio" name="payment_method" value="bank_transfer"
                               x-model="selected" class="mt-1 text-pink-600 focus:ring-pink-400">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">🏦</span>
                                <span class="font-bold text-gray-900">{{ __('Bank Transfer') }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ __('Transfer to our account and upload your receipt. Verified within 1–2 hours.') }}</p>
                        </div>
                    </div>

                    {{-- Bank details + receipt upload, shown when selected --}}
                    <div x-show="selected === 'bank_transfer'" x-cloak class="border-t border-pink-100 p-4 bg-white rounded-b-xl space-y-3">
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200 text-sm space-y-1">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Transfer to') }}:</p>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Bank') }}:</span>
                                <span class="font-bold text-gray-900">{{ setting('bank_name', 'ABA Bank') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Account Name') }}:</span>
                                <span class="font-bold text-gray-900">{{ setting('bank_account_name', 'ShopExpress Co Ltd') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ __('Account Number') }}:</span>
                                <span class="font-mono font-bold text-pink-600 text-base select-all">{{ setting('bank_account_number', '000 123 456 789') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200 mt-2">
                                <span class="text-gray-600">{{ __('Amount') }}:</span>
                                <span class="font-bold text-rose-600 text-base">{{ \App\Helpers\CurrencyHelper::format($cartTotals['total']) }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Transfer Reference / Note') }}</label>
                            <input type="text" name="payment_reference" placeholder="{{ __('e.g. ABA reference number or transaction ID') }}"
                                   class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:ring-pink-400 focus:border-pink-400">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">{{ __('Upload Receipt Screenshot') }} <span class="text-rose-500">*</span></label>
                            <input type="file" name="payment_proof" accept="image/*"
                                   class="block w-full text-sm text-gray-600
                                          file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                          file:text-sm file:font-bold file:bg-pink-50 file:text-pink-700
                                          hover:file:bg-pink-100 cursor-pointer">
                            <p class="text-[11px] text-gray-500 mt-1">{{ __('PNG, JPG up to 5MB. Required for verification.') }}</p>
                        </div>
                    </div>
                </div>
            </label>

            {{-- ③ Credit Card via Stripe (TEST mode) --}}
            <label class="block cursor-pointer">
                <div class="rounded-xl border-2 transition-all"
                     :class="selected === 'credit_card' ? 'border-pink-500 bg-pink-50/40' : 'border-gray-200 bg-white hover:border-pink-300'">
                    <div class="flex items-start gap-3 p-4">
                        <input type="radio" name="payment_method" value="credit_card"
                               x-model="selected" class="mt-1 text-pink-600 focus:ring-pink-400">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-2xl">💳</span>
                                <span class="font-bold text-gray-900">{{ __('Credit / Debit Card') }}</span>
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full">{{ __('Test Mode') }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ __('International cards via Stripe. Use test card 4242 4242 4242 4242.') }}</p>
                        </div>
                    </div>

                    {{-- Stripe Card Element --}}
                    <div id="stripe-card-element-container" x-show="selected === 'credit_card'" x-cloak class="border-t border-pink-100 p-4 bg-white rounded-b-xl">
                        <div id="stripe-card-element"
                             class="p-3 rounded-lg border border-gray-300 bg-white min-h-[42px]">
                            {{-- Stripe injects card fields here --}}
                        </div>
                        <div id="card-errors" class="mt-1 text-xs text-red-500" role="alert"></div>
                    </div>
                </div>
            </label>

        </div>
    </div>

    {{-- Stripe loading overlay --}}
    <div id="stripe-processing" style="display:none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl p-8 text-center shadow-2xl">
            <svg class="animate-spin h-10 w-10 text-pink-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <p class="text-gray-700 font-medium">{{ __('Processing payment…') }}</p>
        </div>
    </div>

    <div class="flex justify-between mt-6">
        <button type="button" id="prev-step-btn"
                class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
            {{ __('Back') }}
        </button>

        <button type="submit" id="place-order-btn"
                class="px-8 py-2 bg-gradient-to-r from-orange-500 to-rose-500 hover:from-orange-600 hover:to-rose-600 text-white rounded-full font-bold shadow-md transition-all">
            {{ __('Place Order') }}
        </button>
    </div>

    <p class="mt-4 text-xs text-gray-500 text-center">
        {{ __('Your information is secure and encrypted.') }}
    </p>
</div>
