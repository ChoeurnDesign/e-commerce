<div class="flex items-center space-x-4">
    @auth
        @php $faqSeller = auth()->user()->seller; @endphp
        @if($faqSeller?->status === 'approved')
            {{-- Already a seller: show dashboard shortcut --}}
            <a href="{{ route('seller.dashboard') }}"
               class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3.5 py-1.5 rounded-full transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                My Store
            </a>
        @elseif($faqSeller?->status === 'pending')
            {{-- Application in review --}}
            <a href="{{ route('seller.register.form') }}"
               class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-3.5 py-1.5 rounded-full transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Pending Review
            </a>
        @elseif(!auth()->user()->isAdmin())
            {{-- Not a seller yet --}}
            <a href="{{ route('seller.landing') }}"
               class="inline-flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-semibold px-3.5 py-1.5 rounded-full transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Start Selling
            </a>
        @endif
    @else
        <a href="{{ route('register') }}"
           class="inline-flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-semibold px-3.5 py-1.5 rounded-full transition-colors shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Start Selling
        </a>
    @endauth
    <x-nav-link :href="route('faq')" :active="request()->routeIs('faq')" 
        class="text-gray-500 hover:text-gray-700 font-medium flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
            <path d="M12 18a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5zm0-11c2.2 0 4 1.79 4 4 0 1.53-1.03 2.43-2.01 3.24-.86.68-1.49 1.18-1.49 2.01h-2c0-1.79 1.17-2.68 2.17-3.48.69-.55 1.33-1.08 1.33-1.77 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4z" fill="currentColor"/>
        </svg>
        <span>FAQ</span>
    </x-nav-link>

    <x-nav-link :href="route('help')" :active="request()->routeIs('help')" 
        class="text-gray-500 hover:text-red-700 font-medium flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" stroke="currentColor"/>
            <path d="M12 7v5l3 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Help</span>
    </x-nav-link>
</div>
