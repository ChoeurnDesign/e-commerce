<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                    @if($unreadCount > 0)
                        <p class="text-sm text-gray-500 mt-0.5">{{ $unreadCount }} unread</p>
                    @endif
                </div>
                @if($unreadCount > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-pink-600 bg-pink-50 hover:bg-pink-100 rounded-lg transition-colors border border-pink-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Mark all as read
                    </button>
                </form>
                @endif
            </div>

            {{-- Flash status --}}
            @if(session('status'))
                <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Notifications list --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                @forelse($notifications as $notification)
                @php
                    $nData   = $notification->data;
                    $type    = $nData['type'] ?? 'default';
                    $label   = $nData['message'] ?? 'New notification';
                    $url     = $nData['url'] ?? null;
                    $isRead  = !is_null($notification->read_at);

                    $iconConfig = match($type) {
                        'new_seller_application' => [
                            'bg'    => 'bg-pink-100',
                            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                            'color' => 'text-pink-500',
                        ],
                        'order_status' => [
                            'bg'    => 'bg-blue-100',
                            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
                            'color' => 'text-blue-500',
                        ],
                        'new_product' => [
                            'bg'    => 'bg-green-100',
                            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>',
                            'color' => 'text-green-500',
                        ],
                        'discount' => [
                            'bg'    => 'bg-rose-100',
                            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M17 17h.01M7 17h.01M17 7h.01M3 12l9-9 9 9-9 9-9-9z"/>',
                            'color' => 'text-rose-500',
                        ],
                        default => [
                            'bg'    => 'bg-amber-100',
                            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
                            'color' => 'text-amber-500',
                        ],
                    };
                @endphp
                <div class="flex items-start gap-4 px-5 py-4 {{ !$isRead ? 'bg-pink-50/50' : '' }} hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">

                    {{-- Icon --}}
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-10 h-10 rounded-full {{ $iconConfig['bg'] }} flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $iconConfig['color'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                {!! $iconConfig['icon'] !!}
                            </svg>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm {{ !$isRead ? 'font-semibold text-gray-900' : 'text-gray-700' }} leading-snug">
                            {{ $label }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                            @if($isRead)
                                &middot; <span class="text-gray-400">Read</span>
                            @endif
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if(!$isRead)
                            <span class="w-2 h-2 rounded-full bg-pink-500 mt-1"></span>
                        @endif

                        @if($url || !$isRead)
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-xs px-3 py-1.5 rounded-lg font-medium transition-colors
                                    {{ $url
                                        ? 'bg-pink-500 hover:bg-pink-600 text-white'
                                        : 'text-gray-500 hover:bg-gray-100' }}">
                                @if($url)
                                    View
                                @else
                                    Dismiss
                                @endif
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center py-16 px-4 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <p class="text-base font-semibold text-gray-700">No notifications yet</p>
                    <p class="text-sm text-gray-400 mt-1">You'll see order updates, seller news, and more here.</p>
                    <a href="{{ route('home') }}" class="mt-4 text-sm text-pink-600 hover:underline font-medium">
                        Continue shopping
                    </a>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>

