@php
    $user = auth()->user();
    $seller = $user?->seller;
    $status = $seller?->status;
    $storeName = $seller?->store_name; 
    
    // Avatar logic: prefer user profile image, fallback to store logo, then initial
    $userAvatar = $user?->profile_image ? asset('storage/' . ltrim($user->profile_image,'/')) : null;
    $storeLogo = $seller?->store_logo_url;
    $displayAvatar = $userAvatar ?? $storeLogo;
    $initial = strtoupper(mb_substr($user?->name ?? 'U', 0, 1));
    
    // Logic for store name initials (e.g., "MyPhone Shop" -> "MPS")
    $storeInitials = 'S'; 
    if ($storeName) {
        $words = explode(' ', $storeName);
        $initialsArray = array_map(function($word) {
            return mb_substr($word, 0, 1);
        }, $words);
        $storeInitials = strtoupper(implode('', $initialsArray));
    }

    $hasStorefront = $seller
        && $seller->slug
        && $status === 'approved'
        && Route::has('store.show');
@endphp


{{-- UPDATED: Added bg-white and text-gray-900 for light mode, dark: variants for dark mode --}}
<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between px-6 h-16 w-full z-20 relative transition-colors duration-200">

    {{-- Left: Mobile toggle + welcome --}}
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen"
                class="md:hidden p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none"
                aria-label="Toggle navigation">
            <svg class="w-6 h-6 text-gray-600 dark:text-gray-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16"/>
            </svg>
        </button>

        <div class="flex items-center gap-3">
            {{-- UPDATED: Text color is now dynamic --}}
            <span class="text-lg font-medium text-gray-800 dark:text-gray-100">
                Welcome, 
                @if($seller?->store_name)
                    {{ $seller->store_name }}
                @else
                    {{ $user->name }}
                @endif
                
                @if($seller && $status !== 'approved')
                    <span class="ml-2 text-xs px-2 py-0.5 rounded
                        @class([
                            'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400' => $status==='pending',
                            'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400'     => $status==='rejected',
                            'bg-gray-100 text-gray-600 dark:bg-gray-500/20 dark:text-gray-300'   => !in_array($status,['pending','rejected','approved']),
                        ])">
                        {{ ucfirst($status) }}
                    </span>
                @endif
            </span>
        </div>
    </div>

    {{-- Right: Dark mode & seller-only dropdown --}}
    <div class="flex items-center gap-4">
        <x-chat.chat-icon :route="route('seller.chat.index')" label="Seller Chat" :badge="$unreadSellerChats ?? 0" />
        
        {{-- UPDATED: Theme Toggle Button styling --}}
        <button type="button"
                class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                onclick="window.toggleTheme()">
             <x-dark-mode-toggle class="p-0" />
        </button>

        <div x-data="{ open:false }" class="relative">
            <button @click="open=!open"
                    @keydown.escape.window="open=false"
                    class="flex items-center gap-2 focus:outline-none group">

                <div class="relative w-10 h-10">
                    @if($displayAvatar)
                        <img src="{{ $displayAvatar }}"
                             alt="Seller Avatar"
                             class="w-10 h-10 rounded-full border-2 border-indigo-400 object-cover shadow-sm"
                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white hidden flex items-center justify-center font-semibold border-2 border-indigo-400">
                            {{ $initial }}
                        </div>
                    @else
                        <span class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold border-2 border-indigo-400">
                            {{ $initial }}
                        </span>
                    @endif
                </div>

                <svg class="w-4 h-4 text-gray-500 dark:text-gray-200 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- UPDATED: Dropdown colors for light mode --}}
            <div x-cloak
                 x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="open=false"
                 class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-900 rounded-lg shadow-xl py-2 z-50 border border-gray-200 dark:border-gray-700">

                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                    Seller Account<br>
                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $user->email }}</span>
                </div>

                <div class="py-1">
                    {{-- Note: Ensure your x-dropdown-link components handle dark mode internally or add classes here --}}
                    @if(Route::has('seller.dashboard'))
                        <x-dropdown-link :href="route('seller.dashboard')" class="flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <x-icon-dashboard name="dashboard" class="w-5 h-5" />
                            Dashboard
                        </x-dropdown-link>
                    @endif
                    
                    {{-- ... apply similar text color classes to other links ... --}}
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-800/40 flex items-center gap-2">
                        <x-icon-dashboard name="signout" class="w-5 h-5" />
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>