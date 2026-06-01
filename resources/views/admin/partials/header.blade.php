@php
    $adminUser = auth()->user();
    $initial = strtoupper(mb_substr($adminUser->name ?? 'A', 0, 1));
@endphp

<header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/60 flex items-center justify-between px-6 h-16 w-full z-20 relative sticky top-0 shrink-0">

    {{-- Left --}}
    <div class="flex items-center gap-4">
        <button @click.stop="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition focus:outline-none">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <h1 class="text-lg font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
    </div>

    {{-- Right --}}
    <div class="flex items-center gap-2">

        {{-- Notifications --}}
        @include('admin.partials.noti')

        <div class="hidden sm:block w-px h-6 bg-gray-200 mx-1"></div>

        {{-- Profile dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-xl hover:bg-gray-100 transition-all focus:outline-none group">
                <img class="w-8 h-8 rounded-lg object-cover ring-1 ring-gray-200"
                     src="https://ui-avatars.com/api/?name={{ urlencode($adminUser->name) }}&background=6366f1&color=fff&size=64"
                     alt="{{ $adminUser->name }}">
                <div class="hidden xl:block text-left">
                    <p class="text-xs font-semibold text-gray-800 leading-none">{{ $adminUser->name }}</p>
                    <p class="text-[10px] text-gray-400 leading-none mt-0.5">Administrator</p>
                </div>
                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-600 transition-transform duration-200"
                     :class="{ 'rotate-180': open }"
                     fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-cloak x-show="open"
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
                        <img class="w-10 h-10 rounded-xl object-cover ring-1 ring-gray-200 shrink-0"
                             src="https://ui-avatars.com/api/?name={{ urlencode($adminUser->name) }}&background=6366f1&color=fff&size=80"
                             alt="{{ $adminUser->name }}">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $adminUser->name }}</p>
                            <p class="text-[11px] text-gray-400 truncate">{{ $adminUser->email }}</p>
                            <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-100 text-indigo-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Admin
                            </span>
                        </div>
                    </div>
                </div>

                <div class="py-1">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile
                    </a>
                    <a href="{{ route('home') }}"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Store
                    </a>
                </div>

                <div class="border-t border-gray-100 py-1">
                    <form method="POST" action="{{ route('logout') }}">
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
