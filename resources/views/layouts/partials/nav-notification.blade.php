<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="relative p-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-600 dark:hover:bg-[#2e1065] transition-colors focus:outline-none">
        <x-icon-nav name="notification" class="inline w-5 h-5 mr-1" />
        @php
        $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
        @endphp
        @if($unreadCount > 0)
        <span
            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none">
            {{ $unreadCount }}
        </span>
        @endif
    </button>
    <!-- Dropdown content -->
    <div x-show="open" x-cloak @click.away="open = false"
        class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white dark:bg-[#181b23] ring-1 ring-black ring-opacity-5 z-50"
        x-cloak>
        <div class="py-2 px-4 max-h-96 overflow-y-auto">
            @if(auth()->check())
            @forelse(auth()->user()->unreadNotifications->take(10) as $notification)
            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="mb-2">
                @csrf
                <button type="submit" class="w-full text-left bg-transparent px-2 py-1 rounded cursor-pointer">
                    {{ $notification->data['message'] }}
                </button>
            </form>
            @empty
            <div class="text-gray-500 py-4 text-center">No new notifications</div>
            @endforelse
            @else
            <div class="text-gray-500 py-4 text-center">Please log in to see your notifications.</div>
            @endif
        </div>
    </div>
</div>
