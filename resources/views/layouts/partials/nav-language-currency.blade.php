@php
    $currencies      = config('currencies');
    $currentCurrency = session('currency', 'usd');
    $currentSymbol   = $currencies[$currentCurrency]['symbol']     ?? '$';
    $currentShort    = $currencies[$currentCurrency]['short_name'] ?? strtoupper($currentCurrency);
@endphp

{{-- ── Currency Switcher ────────────────────────────────────────────── --}}
<div x-data="{ open: false }" class="relative">

    {{-- Trigger pill --}}
    <button @click="open = !open"
            @click.away="open = false"
            class="flex items-center gap-1 px-3 py-1.5 rounded-lg
                   bg-white border border-gray-200 shadow-sm
                   text-gray-800 text-sm font-semibold
                   hover:border-pink-300 hover:bg-pink-50
                   transition-colors focus:outline-none"
            :class="{ 'border-pink-400 bg-pink-50': open }"
            aria-haspopup="true" :aria-expanded="open">
        <span>{{ $currentSymbol }}</span>
        <span>{{ $currentShort }}</span>
        <svg class="w-3.5 h-3.5 text-gray-500 transition-transform duration-200"
             :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Dropdown panel --}}
    <div x-show="open"
         x-cloak
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl
                border border-gray-100 z-50 overflow-hidden"
         style="display:none;">

        {{-- Header --}}
        <div class="px-4 py-2.5 bg-pink-50 border-b border-pink-100">
            <p class="text-[11px] font-bold text-pink-500 uppercase tracking-wider">Select Currency</p>
        </div>

        {{-- Currency list --}}
        <div class="py-1 max-h-64 overflow-y-auto">
            @foreach($currencies as $code => $cur)
                <a href="{{ route('currency.switch', $code) }}"
                   @click="open = false"
                   class="flex items-center gap-3 px-4 py-2.5 transition-colors
                          {{ $currentCurrency === $code
                              ? 'bg-pink-50 text-pink-700 font-semibold'
                              : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="w-6 text-base font-bold shrink-0 text-center">{{ $cur['symbol'] ?? '' }}</span>
                    <span class="flex-1 text-sm font-semibold">{{ $cur['short_name'] ?? strtoupper($code) }}</span>
                    <span class="text-xs text-gray-400 truncate">{{ $cur['name'] ?? '' }}</span>
                    @if($currentCurrency === $code)
                        <svg class="w-3.5 h-3.5 text-pink-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
