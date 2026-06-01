@auth
@php
    $allUnread = auth()->user()->unreadNotifications;
    $notifItems = $allUnread->filter(fn($n) => ($n->data['type'] ?? '') !== 'chat_message');
    $unreadCount = $notifItems->count();
@endphp

<div x-data="{ open: false }" class="relative">
    <button type="button" @click="open = !open"
        class="relative p-2 text-gray-500 hover:text-pink-600 rounded-lg hover:bg-gray-100 transition-colors"
        title="Notifications">
        <x-icon-dashboard name="notification" class="w-5 h-5" />
        @if($unreadCount > 0)
        <span class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold leading-none">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
    </button>

    <div x-show="open"
        x-cloak
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute top-full right-0 mt-2 w-80 rounded-xl shadow-xl bg-white ring-1 ring-black/10 z-[100]">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800">Notifications</span>
                @if($unreadCount > 0)
                <span class="bg-pink-100 text-pink-600 text-xs font-bold px-1.5 py-0.5 rounded-full">
                    {{ $unreadCount }}
                </span>
                @endif
            </div>
            @if($unreadCount > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-pink-500 hover:text-pink-700 font-medium transition-colors">
                    Mark all read
                </button>
            </form>
            @endif
        </div>

        {{-- List --}}
        <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
            @forelse($notifItems->take(8) as $notification)
            @php
                $nData = $notification->data;
                $type  = $nData['type'] ?? 'default';
                $label = $nData['message'] ?? 'New notification';

                $iconConfig = match($type) {
                    'new_seller_application' => ['bg' => 'bg-pink-100', 'icon' => 'store',        'color' => 'text-pink-500'],
                    'order_status'           => ['bg' => 'bg-blue-100',    'icon' => 'orders',       'color' => 'text-blue-500'],
                    'new_product'            => ['bg' => 'bg-green-100',  'icon' => 'products',     'color' => 'text-green-500'],
                    default                  => ['bg' => 'bg-amber-100',  'icon' => 'notification', 'color' => 'text-amber-500'],
                };
            @endphp
            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-50 transition-colors flex items-start gap-3 group">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-8 h-8 rounded-full {{ $iconConfig['bg'] }} flex items-center justify-center">
                            <x-icon-dashboard :name="$iconConfig['icon']" class="w-4 h-4 {{ $iconConfig['color'] }}" />
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800 leading-snug group-hover:text-pink-600 transition-colors line-clamp-2">{{ $label }}</p>
                        <p class="text-[11px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-pink-500 flex-shrink-0 mt-2"></div>
                </button>
            </form>
            @empty
            <div class="flex flex-col items-center py-8">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                    <x-icon-dashboard name="notification" class="w-5 h-5 text-gray-400" />
                </div>
                <p class="text-sm font-medium text-gray-600">All caught up!</p>
                <p class="text-xs text-gray-400 mt-0.5">No new notifications</p>
            </div>
            @endforelse
        </div>

        {{-- Footer --}}
        <div class="px-4 py-2.5 border-t border-gray-100">
            <a href="{{ route('notifications.index') }}"
               class="text-xs text-pink-500 hover:text-pink-700 font-medium transition-colors">
                View all notifications →
            </a>
        </div>
    </div>
</div>
@endauth

