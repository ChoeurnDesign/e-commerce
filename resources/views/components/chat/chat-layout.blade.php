@props([
    'chats' => [],
    'currentChat' => null,
    'isSellerDashboard' => false,
])

<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-10 py-4" style="height: calc(100svh - 3.5rem)">
    <div class="flex bg-white rounded-2xl border border-pink-100 shadow-md overflow-hidden h-full">

        {{-- ═══ SIDEBAR: Conversation list ════════════════════════════════ --}}
        <div class="w-full md:w-80 xl:w-96 bg-white flex flex-col border-r border-pink-100
                    {{ isset($currentChat) && $currentChat ? 'hidden md:flex' : 'flex' }} h-full">

            {{-- Header --}}
            <div class="px-5 py-4 bg-gradient-to-r from-pink-50 to-rose-50 border-b border-pink-100 flex items-center justify-between flex-shrink-0">
                <div>
                    <h1 class="text-lg font-extrabold text-gray-900">{{ __('Messages') }}</h1>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs text-gray-500 font-medium">
                            {{ is_array($chats) ? count($chats) : $chats->count() }} {{ __('conversations') }}
                        </span>
                    </div>
                </div>
                <div class="w-9 h-9 rounded-full bg-white border border-pink-200 flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
            </div>

            {{-- Search --}}
            <div class="p-3 bg-white border-b border-pink-100 flex-shrink-0">
                <div class="relative">
                    <input type="text"
                           placeholder="{{ __('Search conversations...') }}"
                           class="w-full pl-10 pr-4 py-2.5 bg-rose-50/60 border border-pink-100
                                  rounded-xl text-sm placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-300
                                  transition-all">
                    <svg class="absolute left-3 top-3 h-4 w-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Conversation list --}}
            <div class="flex-1 overflow-y-auto bg-white">
                @forelse($chats as $chat)
                    @php
                        $chatName = $chat->getNameForUser(auth()->id());
                        $lastMessage = $chat->lastMessage;
                        $isActive = isset($currentChat) && $currentChat && $currentChat->id === $chat->id;
                        $otherUser = $chat->getOtherUserForUser(auth()->id());
                        $isOtherUserOnline = $otherUser && method_exists($otherUser, 'isOnline') ? $otherUser->isOnline() : false;

                        if (method_exists($chat, 'getUnreadCountForUser')) {
                            $unreadCount = $chat->getUnreadCountForUser(auth()->id());
                        } elseif (method_exists($chat, 'getUnreadCount')) {
                            $unreadCount = $chat->getUnreadCount(auth()->id());
                        } else {
                            $unreadCount = 0;
                        }

                        $sidebarAvatar = null;
                        if ($otherUser && !empty($otherUser->profile_image)) {
                            $sidebarAvatar = Str::startsWith($otherUser->profile_image, ['http://', 'https://'])
                                ? $otherUser->profile_image
                                : asset('storage/' . ltrim($otherUser->profile_image, '/'));
                        } elseif ($otherUser && $otherUser->seller && $otherUser->seller->store_logo) {
                            $sidebarAvatar = $otherUser->seller->store_logo_url;
                        }

                        $lastMessageTime = '';
                        if ($lastMessage) {
                            $userTimezone = auth()->user()->getTimezone();
                            $messageTime = $lastMessage->created_at->setTimezone($userTimezone);
                            $lastMessageTime = $messageTime->format('g:i a');
                        }

                        $initialSource = $otherUser
                            ? ($otherUser->seller->store_name ?? $otherUser->name ?? $chatName)
                            : $chatName;
                        $sidebarInitial = strtoupper(mb_substr(trim((string)$initialSource), 0, 1));
                    @endphp
                    <a href="{{ $isSellerDashboard
                        ? route('seller.chat.index', ['chat_id' => $chat->id])
                        : route('chat.conversation', $chat) }}"
                       class="block px-4 py-3 border-b border-pink-50 transition-colors
                              {{ $isActive
                                  ? 'bg-gradient-to-r from-pink-50 to-rose-50 border-l-4 border-l-pink-500'
                                  : 'hover:bg-rose-50/50 border-l-4 border-l-transparent' }}">
                        <div class="flex items-center">
                            {{-- Avatar --}}
                            <div class="flex-shrink-0 relative">
                                <div class="h-12 w-12 rounded-full overflow-hidden border-2 {{ $isActive ? 'border-pink-300' : 'border-pink-100' }} flex items-center justify-center bg-pink-50">
                                    @if($sidebarAvatar)
                                        <img src="{{ $sidebarAvatar }}" alt="{{ $chatName }}" class="h-full w-full object-cover"
                                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                        <div style="display:none;" class="h-full w-full items-center justify-center bg-gradient-to-br from-pink-400 to-rose-500 text-white text-lg font-bold">
                                            {{ $sidebarInitial }}
                                        </div>
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-pink-400 to-rose-500 text-white text-lg font-bold">
                                            {{ $sidebarInitial }}
                                        </div>
                                    @endif
                                </div>
                                @if($isOtherUserOnline)
                                    <div class="absolute bottom-0 right-0 h-3 w-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="ml-3 flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-bold text-gray-800 truncate">
                                        {{ $chatName }}
                                    </h3>
                                    <div class="flex items-center gap-1.5 flex-shrink-0 ml-2">
                                        @if($lastMessage)
                                            <span class="text-[10px] text-gray-400 font-medium">{{ $lastMessageTime }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-0.5 flex items-center justify-between gap-2">
                                    <p class="text-xs text-gray-500 truncate flex-1">
                                        @if($lastMessage)
                                            @if($lastMessage->sender_id == auth()->id())
                                                <span class="font-medium text-gray-600">{{ __('You') }}: </span>
                                            @endif
                                            {{ Str::limit($lastMessage->body, 32) }}
                                        @else
                                            <span class="italic text-gray-400">{{ __('No messages yet') }}</span>
                                        @endif
                                    </p>
                                    <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1.5 text-[10px] font-bold leading-none text-white bg-rose-500 rounded-full chat-item-unread {{ $unreadCount <= 0 ? 'hidden' : '' }}"
                                          data-chat-id="{{ $chat->id }}"
                                          data-unread="{{ (int) $unreadCount }}"
                                          aria-hidden="{{ $unreadCount <= 0 ? 'true' : 'false' }}">
                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center h-full py-16 px-6 text-center">
                        <div class="w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">{{ __('No conversations yet') }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ __('Start chatting with sellers and stores') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ═══ MAIN: Active conversation ═══════════════════════════════════ --}}
        <div class="w-full md:flex-1 bg-rose-50/30 flex flex-col {{ isset($currentChat) && $currentChat ? 'flex' : 'hidden md:flex' }} h-full">
            {{ $slot }}
        </div>
    </div>
</div>
