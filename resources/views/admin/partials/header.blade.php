<header class="bg-white dark:bg-[#181b23] shadow-sm border-b border-gray-200 dark:border-gray-800 transition-colors flex-shrink-0">
    <div class="flex justify-between items-center px-6 py-4">
        <div class="flex items-center">
            <button @click.stop="sidebarOpen = !sidebarOpen" 
                class="text-gray-500 dark:text-gray-400 focus:outline-none hover:text-indigo-600 dark:hover:text-white mr-4 lg:hidden transition-colors p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">@yield('title', 'Admin Dashboard')</h1>
        </div>

        <div class="flex items-center space-x-4">

            @include('admin.partials.noti')

            <x-dark-mode-toggle class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition focus:outline-none" />

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="max-w-xs flex items-center text-sm rounded-full transition-colors group">
                    <img class="h-8 w-8 rounded-full object-cover border border-gray-200 dark:border-gray-700" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" 
                         alt="{{ auth()->user()->name }}">
                    <span class="hidden lg:block ml-2 text-gray-700 dark:text-gray-100 font-medium group-hover:text-indigo-600 transition-colors">{{ auth()->user()->name }}</span>
                    
                    @if(Auth::user()->role === 'admin')
                        <span class="hidden lg:block ml-2 bg-gray-700 dark:bg-gray-700 text-gray-200 dark:text-indigo-200 text-xs px-2 py-1 rounded-full font-semibold">Admin</span>
                    @endif
                    
                    <svg class="ml-1 h-4 w-4 text-gray-400 group-hover:text-indigo-600 transition-colors hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" 
                    @click.away="open = false" 
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#181b23] rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 border border-gray-100 dark:border-gray-800 transition-colors"
                    style="display: none;">
                    
                    <div class="py-1">
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-[#23263a] hover:text-indigo-600 dark:hover:text-white">
                            <x-icon-dashboard name="profile" class="w-4 h-4 mr-3 text-gray-400" />
                            Profile
                        </x-dropdown-link>
                        
                        <x-dropdown-link :href="route('home')" class="flex items-center text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-[#23263a] hover:text-indigo-600 dark:hover:text-white">
                            <x-icon-dashboard name="store" class="w-4 h-4 mr-3 text-gray-400" />
                            View Store
                        </x-dropdown-link>

                        <div class="border-t border-gray-100 dark:border-gray-800 my-1"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <x-icon-dashboard name="signout" class="w-4 h-4 mr-3 text-red-500" />
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>