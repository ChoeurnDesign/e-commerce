<x-slot name="trigger">
    @auth
    <button class="flex items-center bg-transparent hover:bg-transparent ml-2 py-0 transition-colors focus:outline-none">
        @php
        $user = Auth::user();
        @endphp
        @if($user && $user->profile_image && file_exists(public_path('storage/' . $user->profile_image)))
        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Avatar"
            class="w-10 h-10 rounded-full object-cover border-indigo-500 shadow" />
        @else
        <span class="w-8 h-8 flex items-center justify-center rounded-full bg-[#8b5cf6] text-white text-base font-normal">
            {{ strtoupper($user->name[0] ?? 'U') }}
        </span>
        @endif
    </button>
    @else
    <button class="flex items-center bg-transparent hover:bg-transparent px-0 py-0 transition-colors focus:outline-none">
        <x-icon-nav name="user" class="w-8 h-8 text-gray-700 dark:text-gray-300" />
    </button>
    @endauth
</x-slot>
<x-slot name="content">
    <div
        class="bg-[#181f31] dark:bg-[#181b23] text-gray-300 border border-[#23283a] rounded shadow-md py-1">
        @auth
        <x-dropdown-link :href="route('profile.edit')"
            class="text-gray-300 hover:text-white flex items-center">
            <x-icon-nav name="profile" class="text-gray-300" />
            Profile
        </x-dropdown-link>

        {{-- Become a Seller link for users who are not yet sellers --}}
        @if(auth()->user()->role !== 'seller')
            <x-dropdown-link :href="route('seller.register.form')"
                class="text-gray-300 hover:text-white flex items-center">
                <x-icon-nav name="store" class="text-gray-300" />
                Become a Seller
            </x-dropdown-link>
        @endif

        @if(auth()->user()->role === 'seller')
            <x-dropdown-link :href="route('seller.dashboard')"
                class="text-gray-300 hover:text-white flex items-center">
                <x-icon-nav name="dashboard" class="text-gray-300" />
                Seller Dashboard
            </x-dropdown-link>
        @endif

        <button id="dark-mode-toggle" type="button"
            class="w-full flex items-center px-5 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded">
            <x-icon-nav name="dark-mode" class="text-gray-300" />
            <span>Dark Mode</span>
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                class="text-gray-300 hover:text-white flex items-center">
                <x-icon-nav name="signout" class="text-gray-300" />
                Sign Out
            </x-dropdown-link>
        </form>
        @else
        <x-dropdown-link :href="route('login')"
            class="text-gray-300 hover:text-white flex items-center">
            <x-icon-nav name="login" class="text-gray-300" />
            Login
        </x-dropdown-link>
        <x-dropdown-link :href="route('register')"
            class="text-gray-300 hover:text-white flex items-center">
            <x-icon-nav name="register" class="text-gray-300" />
            Register
        </x-dropdown-link>
        <button id="dark-mode-toggle" type="button"
            class="w-full flex items-center px-5 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded">
            <x-icon-nav name="dark-mode" class="text-gray-300" />
            <span>Dark Mode</span>
        </button>
        @endauth    
    </div>
</x-slot>
