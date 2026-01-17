@props([
    'chats' => [],
    'currentChat' => null,
    'isSellerDashboard' => false, 
])

<div class="max-w-full h-[calc(92vh-64px)] border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800">
    <div class="flex rounded-xl overflow-hidden bg-white dark:bg-gray-800 h-full">
        
        <div class="w-full md:w-80 bg-white dark:bg-gray-800 flex flex-col border-r border-gray-300 dark:border-gray-700 {{ isset($currentChat) && $currentChat ? 'hidden md:flex' : 'flex' }} h-full">
            <div class="px-4 py-3 bg-white dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Messages</h1>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ is_array($chats) ? count($chats) : $chats->count() }} conversations
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="p-3 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="relative">
                    <input type="text" placeholder="Search conversations..." class="w-full pl-10 pr-4 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                @forelse($chats as $chat)
                    @php
                        $chatName = $chat->getNameForUser(auth()->id());
                        $lastMessage = $chat->lastMessage;
                        $isActive = isset($currentChat) && $currentChat && $currentChat->id === $chat->id;
                        $otherUser = $chat->getOtherUserForUser(auth()->id());
                        $isOtherUserOnline = $otherUser && method_exists($otherUser, 'isOnline') ? $otherUser->isOnline() : false;

                        // Prefer model method name that exists; fall back if you have legacy name
                        if (method_exists($chat, 'getUnreadCountForUser')) {
                            $unreadCount = $chat->getUnreadCountForUser(auth()->id());
                        } elseif (method_exists($chat, 'getUnreadCount')) {
                            $unreadCount = $chat->getUnreadCount(auth()->id());
                        } else {
                            $unreadCount = 0;
                        }

                        $sidebarAvatar = asset('images/default-store.png');
                        if ($otherUser && $otherUser->seller && !empty($otherUser->seller->store_logo_url)) {
                            $sidebarAvatar = $otherUser->seller->store_logo_url;
                        } elseif ($otherUser && !empty($otherUser->profile_image)) {
                            $sidebarAvatar = Str::startsWith($otherUser->profile_image, ['http://', 'https://'])
                                ? $otherUser->profile_image
                                : asset('storage/' . ltrim($otherUser->profile_image, '/'));
                        } else {
                            // no avatar image -> we'll render an initial letter below
                            $sidebarAvatar = null;
                        }
                        $lastMessageTime = '';
                        if ($lastMessage) {
                            $userTimezone = auth()->user()->getTimezone();
                            $messageTime = $lastMessage->created_at->setTimezone($userTimezone);
                            $lastMessageTime = $messageTime->format('g:i a');
                        }

                        // Compute initial for fallback avatar (store name > user name > chat name)
                        $initialSource = null;
                        if ($otherUser) {
                            $initialSource = $otherUser->seller->store_name ?? $otherUser->name ?? $chatName;
                        } else {
                            $initialSource = $chatName;
                        }
                        $sidebarInitial = strtoupper(mb_substr(trim((string)$initialSource), 0, 1));
                    @endphp
                    <a href="{{ $isSellerDashboard 
                        ? route('seller.chat.index', ['chat_id' => $chat->id]) 
                        : route('chat.conversation', $chat) }}"
                        class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/20 border-r-2 border-blue-500 shadow-sm' : '' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 relative">
                                <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-300 dark:bg-gray-600 shadow-sm flex items-center justify-center">
                                    @if($sidebarAvatar)
                                        <img src="{{ $sidebarAvatar }}" alt="{{ $chatName }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-blue-500 dark:bg-blue-700 text-white text-2xl">
                                            {{ $sidebarInitial }}
                                        </div>
                                    @endif
                                </div>
                                @if($isOtherUserOnline)
                                    <div class="absolute bottom-0 right-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                                @endif
                            </div>

                            <div class="ml-3 flex-1 min-w-0">  
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $chatName }}
                                    </h3>
                                    <div class="flex items-center">
                                        {{-- Per-chat unread badge: always render (hidden when zero) and include class + data attribute for JS --}}
                                        <span
                                            class="mr-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full shadow-sm chat-item-unread {{ $unreadCount <= 0 ? 'hidden' : '' }}"
                                            data-chat-id="{{ $chat->id }}"
                                            data-unread="{{ (int) $unreadCount }}"
                                            aria-hidden="{{ $unreadCount <= 0 ? 'true' : 'false' }}">
                                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                        </span>

                                        @if($lastMessage)
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $lastMessageTime }}</span>
                                        @endif                                        
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        @if($lastMessage)
                                            @if($lastMessage->sender_id == auth()->id())
                                                <span class="font-medium">You: </span>
                                            @endif
                                            {{ Str::limit($lastMessage->body, 35) }}
                                        @else
                                            <span class="italic">No messages yet</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center h-full py-12 text-gray-400 dark:text-gray-500">
                        <svg class="h-12 w-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span class="text-base">No conversations yet</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="w-full md:flex-1 bg-gray-50 dark:bg-gray-800 flex flex-col {{ isset($currentChat) && $currentChat ? 'flex' : 'hidden md:flex' }} h-full">
            {{ $slot }}
        </div>
    </div>
</div>