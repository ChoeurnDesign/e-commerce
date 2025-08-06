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
        <x-icon-nav name="user" class="w-8 h-8 text-gray-400 dark:text-gray-300" />
    </button>
    @endauth
</x-slot>
<x-slot name="content">
    <div
        class="bg-white dark:bg-[#181b23] text-gray-700 dark:text-white border border-[#a1a1aa] rounded shadow-md py-1">
        @auth
        <x-dropdown-link :href="route('profile.edit')"
            class="text-gray-700 dark:text-white hover:text-indigo-600 flex items-center">
            <x-icon-nav name="profile" class="w-5 h-5 mr-2" />
            Profile
        </x-dropdown-link>
        <button id="dark-mode-toggle" type="button"
            class="w-full flex items-center px-5 py-2 text-sm text-gray-700 dark:text-white hover:text-indigo-600 hover:bg-gray-300 dark:hover:bg-[#2e1065] rounded">
            <x-icon-nav name="dark-mode" class="w-5 h-5 mr-2" />
            <span>Dark Mode</span>
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                class="text-red-500 dark:text-red-400 hover:text-red-600 flex items-center">
                <x-icon-nav name="signout" class="w-5 h-5 mr-2" />
                Sign Out
            </x-dropdown-link>
        </form>
        @else
        <x-dropdown-link :href="route('login')"
            class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-700 flex items-center">
            <x-icon-nav name="login" class="w-5 h-5 mr-2" />
            Login
        </x-dropdown-link>
        <x-dropdown-link :href="route('register')"
            class="text-purple-600 dark:text-purple-300 hover:text-purple-700 flex items-center">
            <x-icon-nav name="register" class="w-5 h-5 mr-2" />
            Register
        </x-dropdown-link>
        <button id="dark-mode-toggle" type="button"
            class="w-full flex items-center px-5 py-2 text-sm text-gray-700 dark:text-white hover:text-indigo-600 hover:bg-gray-300 dark:hover:bg-[#2e1065] rounded">
            <x-icon-nav name="dark-mode" class="w-5 h-5 mr-2" />
            <span>Dark Mode</span>
        </button>
        @endauth
    </div>
</x-slot>
