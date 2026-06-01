<x-slot name="trigger">
    {{-- Trigger button --}}
    @auth
        @php $navUser = Auth::user(); @endphp
        <button class="flex items-center gap-2 px-2 py-1.5 rounded-xl
                       hover:bg-white/60 transition-colors focus:outline-none group">
            {{-- Avatar --}}
            @if($navUser->profile_image && file_exists(public_path('storage/' . $navUser->profile_image)))
                <img src="{{ asset('storage/' . $navUser->profile_image) }}"
                     class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm flex-shrink-0" />
            @else
                <span class="w-8 h-8 flex items-center justify-center rounded-full
                             bg-gradient-to-br from-pink-500 to-rose-500
                             text-white text-sm font-bold ring-2 ring-white shadow-sm flex-shrink-0">
                    {{ strtoupper(substr($navUser->name ?? 'U', 0, 1)) }}
                </span>
            @endif
            {{-- Name + label (xl only) --}}
            <div class="text-left hidden xl:block">
                <p class="text-[10px] text-gray-500 leading-none">Hello,</p>
                <p class="text-xs font-bold text-gray-800 leading-none mt-0.5 flex items-center gap-1">
                    {{ explode(' ', $navUser->name)[0] }}
                    <svg class="w-3 h-3 text-gray-400 group-hover:text-pink-500 transition-colors"
                         fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </p>
            </div>
        </button>
    @else
        <button class="flex items-center gap-2 px-2 py-1.5 rounded-xl
                       hover:bg-white/60 transition-colors focus:outline-none group">
            <span class="w-8 h-8 flex items-center justify-center rounded-full
                         bg-gray-200 text-gray-500 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            <div class="text-left hidden xl:block">
                <p class="text-[10px] text-gray-500 leading-none">Hello,</p>
                <p class="text-xs font-bold text-gray-700 leading-none mt-0.5 flex items-center gap-1">
                    Guest
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </p>
            </div>
        </button>
    @endauth
</x-slot>

<x-slot name="content">
@auth
    @php
        $navUser   = Auth::user();
        $navSeller = $navUser->seller;
    @endphp

    {{-- ── User header ─────────────────────────────────────────────── --}}
    <div class="px-4 pt-4 pb-3 bg-gradient-to-br from-pink-50 to-rose-50 border-b border-pink-100">
        <div class="flex items-center gap-3">
            {{-- Avatar --}}
            @if($navUser->profile_image && file_exists(public_path('storage/' . $navUser->profile_image)))
                <img src="{{ asset('storage/' . $navUser->profile_image) }}"
                     class="w-11 h-11 rounded-full object-cover ring-2 ring-pink-200 shrink-0" />
            @else
                <span class="w-11 h-11 flex items-center justify-center rounded-full shrink-0
                             bg-gradient-to-br from-pink-500 to-rose-500
                             text-white text-lg font-bold ring-2 ring-pink-200">
                    {{ strtoupper(substr($navUser->name ?? 'U', 0, 1)) }}
                </span>
            @endif
            {{-- Info --}}
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold text-gray-900 truncate">{{ $navUser->name }}</p>
                <p class="text-[11px] text-gray-500 truncate">{{ $navUser->email }}</p>
                {{-- Role badge --}}
                @if($navSeller?->status === 'approved')
                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-100 text-green-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Seller
                    </span>
                @elseif($navUser->isAdmin())
                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-purple-100 text-purple-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Admin
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Member
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Account links ───────────────────────────────────────────── --}}
    <div class="py-1.5">

        {{-- Profile --}}
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors group">
            <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-pink-100 flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4 text-gray-500 group-hover:text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            <div>
                <p class="font-medium leading-none">Profile</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Edit your info & password</p>
            </div>
        </a>

        {{-- Orders --}}
        <a href="{{ route('orders.history') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors group">
            <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-pink-100 flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4 text-gray-500 group-hover:text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </span>
            <div>
                <p class="font-medium leading-none">My Orders</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Track & manage orders</p>
            </div>
        </a>

        {{-- Messages --}}
        <a href="{{ route('chat.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 transition-colors group">
            <span class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-pink-100 flex items-center justify-center transition-colors shrink-0">
                <svg class="w-4 h-4 text-gray-500 group-hover:text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </span>
            <div>
                <p class="font-medium leading-none">Messages</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Chat with sellers</p>
            </div>
        </a>

    </div>

    {{-- ── Seller section ───────────────────────────────────────────── --}}
    <div class="border-t border-gray-100 py-1.5">
        @if($navSeller?->status === 'approved')
            <a href="{{ route('seller.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-green-50 transition-colors group">
                <span class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </span>
                <div>
                    <p class="font-semibold text-green-700 leading-none">Seller Dashboard</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Manage your store</p>
                </div>
                <svg class="w-4 h-4 text-green-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        @elseif($navSeller?->status === 'pending')
            <a href="{{ route('seller.register.form') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-amber-50 transition-colors group">
                <span class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <div>
                    <p class="font-semibold text-amber-700 leading-none">Application Pending</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Under review</p>
                </div>
            </a>

        @else
            <a href="{{ route('seller.landing') }}"
               class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-pink-50 transition-colors group">
                <span class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </span>
                <div>
                    <p class="font-semibold text-pink-600 leading-none">Start Selling</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Open your store today</p>
                </div>
                <svg class="w-4 h-4 text-pink-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @endif
    </div>

    {{-- ── Sign out ─────────────────────────────────────────────────── --}}
    <div class="border-t border-gray-100 py-1.5">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm
                           text-red-600 hover:bg-red-50 transition-colors group">
                <span class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors shrink-0">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <p class="font-medium">Sign Out</p>
            </button>
        </form>
    </div>

@else
    {{-- ── Guest ───────────────────────────────────────────────────── --}}
    <div class="px-4 py-4 text-center border-b border-gray-100 bg-gradient-to-br from-pink-50 to-rose-50">
        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-2">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-gray-700">Welcome!</p>
        <p class="text-xs text-gray-400 mt-0.5">Sign in to your account</p>
    </div>
    <div class="p-3 space-y-2">
        <a href="{{ route('login') }}"
           class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl
                  bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold transition-colors">
            Sign In
        </a>
        <a href="{{ route('register') }}"
           class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl
                  border border-pink-200 text-pink-700 text-sm font-medium
                  hover:bg-pink-50 transition-colors">
            Create Account
        </a>
    </div>
@endauth
</x-slot>
