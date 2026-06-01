{{-- Three promotional mini-banner cards --}}
<div class="bg-gray-50 py-5 sm:py-7">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">

            {{-- Free Shipping --}}
            <a href="{{ route('products.index') }}"
               class="relative flex items-center gap-4 overflow-hidden rounded-2xl
                      bg-gradient-to-br from-indigo-500 to-indigo-700
                      px-5 py-4 sm:py-5 group hover:shadow-lg hover:-translate-y-0.5
                      transition-all duration-300">
                {{-- Decorative circles --}}
                <div class="absolute -right-5 -top-5 w-20 h-20 bg-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute -right-2 -bottom-6 w-14 h-14 bg-white/10 rounded-full pointer-events-none"></div>

                <div class="w-11 h-11 flex-shrink-0 bg-white/20 rounded-xl flex items-center justify-center">
                    {{-- Truck icon --}}
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-white font-bold text-sm sm:text-base">{{ __('Free Shipping') }}</div>
                    <div class="text-pink-600 text-xs mt-0.5">{{ __('On orders over $50') }}</div>
                </div>
                <svg class="w-4 h-4 text-white/40 group-hover:text-white/80 group-hover:translate-x-1 transition-all flex-shrink-0"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            {{-- Flash Sale --}}
            <a href="{{ route('products.shops_on_sale') }}"
               class="relative flex items-center gap-4 overflow-hidden rounded-2xl
                      bg-gradient-to-br from-rose-500 to-orange-500
                      px-5 py-4 sm:py-5 group hover:shadow-lg hover:-translate-y-0.5
                      transition-all duration-300">
                <div class="absolute -right-5 -top-5 w-20 h-20 bg-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute -right-2 -bottom-6 w-14 h-14 bg-white/10 rounded-full pointer-events-none"></div>

                <div class="w-11 h-11 flex-shrink-0 bg-white/20 rounded-xl flex items-center justify-center">
                    {{-- Lightning bolt --}}
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-white font-bold text-sm sm:text-base">{{ __('Flash Deals') }}</div>
                    <div class="text-rose-100 text-xs mt-0.5">{{ __('Limited-time discounts') }}</div>
                </div>
                <svg class="w-4 h-4 text-white/40 group-hover:text-white/80 group-hover:translate-x-1 transition-all flex-shrink-0"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            {{-- Sell with us --}}
            <a href="{{ route('register') }}"
               class="relative flex items-center gap-4 overflow-hidden rounded-2xl
                      bg-gradient-to-br from-emerald-500 to-teal-600
                      px-5 py-4 sm:py-5 group hover:shadow-lg hover:-translate-y-0.5
                      transition-all duration-300">
                <div class="absolute -right-5 -top-5 w-20 h-20 bg-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute -right-2 -bottom-6 w-14 h-14 bg-white/10 rounded-full pointer-events-none"></div>

                <div class="w-11 h-11 flex-shrink-0 bg-white/20 rounded-xl flex items-center justify-center">
                    {{-- Store/shop icon --}}
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-white font-bold text-sm sm:text-base">{{ __('Sell With Us') }}</div>
                    <div class="text-emerald-100 text-xs mt-0.5">{{ __('Open your store today') }}</div>
                </div>
                <svg class="w-4 h-4 text-white/40 group-hover:text-white/80 group-hover:translate-x-1 transition-all flex-shrink-0"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        </div>
    </div>
</div>

