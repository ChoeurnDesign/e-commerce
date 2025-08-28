<header class="bg-gray-800 dark:bg-[#23263a] shadow-sm border-b border-gray-300 dark:border-[#23263a] transition-colors">
    <div class="flex justify-between items-center px-6 py-4">
        <div class="flex items-center">
            {{-- <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-300 focus:outline-none focus:text-gray-600 mr-4 lg:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button> --}}

            <h1 class="text-2xl text-gray-300 dark:text-gray-100">@yield('title', 'Admin Dashboard')</h1>
        </div>

        <div class="flex items-center space-x-4">
            <div class="relative hidden sm:block">
                <input type="text"
                    placeholder="Search..."
                    class="pl-10 pr-4 py-2 border border-gray-400 dark:border-gray-500 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm bg-gray-800 dark:bg-[#23263a] text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 transition-colors">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            @include('admin.partials.noti')

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="max-w-xs flex items-center text-sm rounded-full transition-colors">
                    <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" alt="{{ auth()->user()->name }}">
                    <span class="hidden lg:block ml-2 text-gray-300 dark:text-gray-100 font-medium">{{ auth()->user()->name }}</span>
                    @if(Auth::user()->role === 'admin')
                        <span class="hidden lg:block ml-2 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 text-xs px-2 py-1 rounded-full">Admin</span>
                    @endif
                    <svg class="ml-1 h-4 w-4 text-gray-500 dark:text-gray-300 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-gray-800 dark:bg-[#23263a] rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 transition-colors"
                    style="display: none;">
                    <div class="py-1">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center text-gray-300 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-[#262c47]">
                            <x-icon-nav name="profile" class="w-5 h-5 mr-2" />
                            Profile
                        </x-dropdown-link>
                        <button id="dark-mode-toggle" type="button"
                            class="w-full flex items-center px-5 py-2 text-sm text-gray-300 dark:text-gray-100 hover:bg-gray-500 dark:hover:bg-[#2e1065]">
                            <x-icon-nav name="dark-mode" class="w-5 h-5 mr-2" />
                            <span>Dark Mode</span>
                        </button>
                        <x-dropdown-link :href="route('home')" class="flex items-center text-gray-300 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-[#262c47]">
                            <x-icon-nav name="store" class="w-5 h-5 mr-2" />
                            View Store
                        </x-dropdown-link>
                        <div class="border-t border-gray-100 dark:border-[#23263a]"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center text-red-600 dark:text-red-400 hover:text-orange-600 dark:hover:text-orange-400">
                                <x-icon-nav name="signout" class="w-5 h-5 mr-2" />
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
