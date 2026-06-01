@php
    $user = auth()->user();
    $seller = $user?->seller;
    $status = $seller?->status;
    $storeName = $seller?->store_name;

    $displayAvatar = null;
    if ($user?->profile_image && file_exists(public_path('storage/' . $user->profile_image))) {
        $displayAvatar = asset('storage/' . ltrim($user->profile_image, '/'));
    } elseif ($seller?->store_logo) {
        $displayAvatar = $seller->store_logo_url;
    }
    $initial = strtoupper(mb_substr($user?->name ?? 'U', 0, 1));
@endphp

<header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/60 flex items-center justify-between px-6 h-16 w-full z-20 relative sticky top-0">

    {{-- Left: Mobile toggle + Breadcrumb --}}
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen"
                class="md:hidden p-2 rounded-xl hover:bg-gray-100 transition focus:outline-none"
                aria-label="Toggle navigation">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden sm:flex items-center gap-2 text-sm">
            <span class="text-gray-400">Welcome,</span>
            <span class="font-semibold text-gray-800">{{ $storeName ?? $user->name }}</span>
            @if($seller && $status !== 'approved')
                @php
                    $statusBadge = match($status) {
                        'pending'  => 'bg-amber-50 text-amber-600 border-amber-200',
                        'rejected' => 'bg-red-50 text-red-600 border-red-200',
                        default    => 'bg-gray-50 text-gray-500 border-gray-200',
                    };
                @endphp
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full border {{ $statusBadge }}">
                    {{ ucfirst($status) }}
                </span>
            @endif
        </div>
    </div>

    {{-- Right: Actions --}}
    <div class="flex items-center gap-1.5">

        {{-- Chat --}}
        <x-chat.chat-icon :route="route('seller.chat.index')" label="Seller Chat" :badge="$unreadSellerChats ?? 0" />

        {{-- Divider --}}
        <div class="hidden sm:block w-px h-6 bg-gray-200 mx-1.5"></div>

        {{-- Profile dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    @keydown.escape.window="open = false"
                    class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-xl hover:bg-gray-100 transition-all focus:outline-none group">

                @if($displayAvatar)
                    <img src="{{ $displayAvatar }}"
                         alt="Avatar"
                         class="w-8 h-8 rounded-lg object-cover ring-1 ring-gray-200"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <span style="display:none;" class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 text-white items-center justify-center font-bold text-xs ring-1 ring-gray-200">
                        {{ $initial }}
                    </span>
                @else
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 text-white flex items-center justify-center font-bold text-xs ring-1 ring-gray-200">
                        {{ $initial }}
                    </span>
                @endif

                <div class="hidden xl:block text-left">
                    <p class="text-xs font-semibold text-gray-800 leading-none">{{ $storeName ?? $user->name }}</p>
                    <p class="text-[10px] text-gray-400 leading-none mt-0.5">{{ $user->email }}</p>
                </div>

                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-600 transition-transform duration-200"
                     :class="{ 'rotate-180': open }"
                     fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-cloak
                 x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="open = false"
                 class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl z-50 border border-gray-100 overflow-hidden">

                {{-- User card --}}
                <div class="px-4 pt-4 pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        @if($displayAvatar)
                            <img src="{{ $displayAvatar }}" alt="Avatar"
                                 class="w-10 h-10 rounded-xl object-cover ring-1 ring-gray-200 shrink-0"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <span style="display:none;" class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 text-white items-center justify-center font-bold ring-1 ring-gray-200 shrink-0">
                                {{ $initial }}
                            </span>
                        @else
                            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 text-white flex items-center justify-center font-bold ring-1 ring-gray-200 shrink-0">
                                {{ $initial }}
                            </span>
                        @endif
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $storeName ?? $user->name }}</p>
                            <p class="text-[11px] text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Links --}}
                <div class="py-1">
                    @foreach([
                        ['route' => 'seller.dashboard',      'label' => 'Dashboard',      'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'seller.settings.edit',  'label' => 'Store Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                        ['route' => 'home',                  'label' => 'Visit Store',    'icon' => 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'],
                    ] as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $link['icon'] }}"/>
                        </svg>
                        {{ $link['label'] }}
                    </a>
                    @endforeach
                </div>

                {{-- Logout --}}
                <div class="border-t border-gray-100 py-1">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
