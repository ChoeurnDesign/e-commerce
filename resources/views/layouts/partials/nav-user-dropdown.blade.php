<x-slot name="trigger">
    <div class="flex items-center ml-2 cursor-pointer">
        @auth
            @php $user = Auth::user(); @endphp
            @if($user && $user->profile_image && file_exists(public_path('storage/' . $user->profile_image)))
                <img src="{{ asset('storage/' . $user->profile_image) }}" 
                     class="w-9 h-9 rounded-full object-cover border-2 border-indigo-500 shadow-sm" alt="Profile" />
            @else
                <span class="w-9 h-9 flex items-center justify-center rounded-full bg-[#8b5cf6] text-white text-base font-medium shadow-sm">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </span>
            @endif
        @else
            <x-icon-dashboard name="user" class="w-8 h-8 text-gray-400 dark:text-gray-500 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors" />
        @endauth
    </div>
</x-slot>

<x-slot name="content">
    @auth
        {{-- Authenticated User Options --}}
         <x-dropdown-link :href="route('profile.edit')">
            <div class="flex items-center">
                <x-icon-dashboard name="profile" class="w-5 h-5 mr-3 text-gray-400 dark:text-gray-500" />
                <span>Profile</span>
            </div>
        </x-dropdown-link>

        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

        <x-dropdown-link :href="route('chat.index')">
            <div class="flex items-center">
                <x-icon-dashboard name="chat" class="w-5 h-5 mr-3 text-gray-400 dark:text-gray-500" />
                <span>Chat</span>
            </div>
        </x-dropdown-link>

        @if(auth()->user()->role !== 'seller')
            <x-dropdown-link :href="route('seller.landing')">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Sell on {{ setting('store_name', 'ShopExpress') }}</span>
                </div>
            </x-dropdown-link>
        @endif

        <x-dropdown-link :href="route('about')">
            <div class="flex items-center">
                <x-icon-dashboard name="about" class="w-5 h-5 mr-3 text-gray-400 dark:text-gray-500" />
                <span>About Us</span>
            </div>
        </x-dropdown-link>

        <x-dropdown-link :href="route('contact')">
            <div class="flex items-center">
                <x-icon-dashboard name="contact" class="w-5 h-5 mr-3 text-gray-400 dark:text-gray-500" />
                <span>Contact</span>
            </div>
        </x-dropdown-link>

        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                <div class="flex items-center">
                    <x-icon-dashboard name="signout" class="w-5 h-5 mr-3 text-red-500 dark:text-red-400" />
                    <span>Sign Out</span>
                </div>
            </x-dropdown-link>
        </form>

    @else
        {{-- Guest Options --}}
        <x-dropdown-link :href="route('login')">
            <div class="flex items-center text-indigo-600 dark:text-indigo-400 font-medium">
                <x-icon-dashboard name="login" class="w-5 h-5 mr-3" />
                <span>Login</span>
            </div>
        </x-dropdown-link>

        <x-dropdown-link :href="route('register')">
            <div class="flex items-center text-gray-700 dark:text-gray-200">
                <x-icon-dashboard name="register" class="w-5 h-5 mr-3 text-gray-400 dark:text-gray-500" />
                <span>Create Account</span>
            </div>
        </x-dropdown-link>
    @endauth
</x-slot>