@if (isset($currentChat) && $currentChat)
    <div x-data="chatComponent()" x-init="initChat({{ $currentChat->id }}, {{ json_encode($lastSentId ?? null) }}, {{ json_encode($lastSentMessageTs ?? null) }})" class="flex flex-col h-full">
        @php
            $chatName = $currentChat->getNameForUser(auth()->id());
            $otherUser = $currentChat->getOtherUserForUser(auth()->id());
            $isOnline = $otherUser && method_exists($otherUser, 'isOnline') && $otherUser->isOnline();

            $chatAvatar = null;
            if ($otherUser && !empty($otherUser->profile_image)) {
                $chatAvatar = Str::startsWith($otherUser->profile_image, ['http://', 'https://'])
                    ? $otherUser->profile_image
                    : asset('storage/' . ltrim($otherUser->profile_image, '/'));
            } elseif ($otherUser && $otherUser->seller && $otherUser->seller->store_logo) {
                $chatAvatar = $otherUser->seller->store_logo_url;
            }

            $userTimezone = auth()->user()->getTimezone();

            $lastSentMessage = $messages->last(function ($message) {
                return $message->sender_id === auth()->id();
            });
            $lastSentId = $lastSentMessage ? $lastSentMessage->id : null;
            $lastSentMessageTs = $lastSentMessage ? $lastSentMessage->created_at->toIso8601String() : null;
            $showStatusByDefault = $lastSentMessage && $lastSentMessage->created_at->greaterThan(now()->subMinutes(10));
        @endphp

        {{-- ═══ Chat Header ═══════════════════════════════════════════════ --}}
        <div class="flex-shrink-0 px-5 py-3.5 bg-white border-b border-pink-100 flex items-center justify-between shadow-sm">
            <div class="flex items-center flex-1 min-w-0">
                {{-- Back button (mobile) --}}
                <a href="{{ route('chat.index') }}"
                   class="mr-3 p-2 text-gray-500 hover:text-pink-500 rounded-lg hover:bg-pink-50 transition-colors md:hidden">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <div class="h-11 w-11 rounded-full overflow-hidden border-2 border-pink-200 bg-pink-50">
                        @if ($chatAvatar)
                            <img src="{{ $chatAvatar }}" alt="{{ $chatName }}" class="h-full w-full object-cover"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div style="display:none;" class="h-full w-full items-center justify-center bg-gradient-to-br from-pink-400 to-rose-500 text-white font-bold text-lg">
                                {{ $chatName ? Str::upper(Str::substr($chatName, 0, 1)) : 'U' }}
                            </div>
                        @else
                            @php
                                $initial = $chatName ? Str::upper(Str::substr($chatName, 0, 1)) : 'U';
                            @endphp
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-pink-400 to-rose-500 text-white font-bold text-lg">
                                {{ $initial }}
                            </div>
                        @endif
                    </div>
                    @if ($isOnline)
                        <div class="absolute bottom-0 right-0 h-3 w-3 bg-emerald-500 rounded-full border-2 border-white"></div>
                    @endif
                </div>

                <div class="ml-3 flex-1 min-w-0">
                    <h3 class="text-base font-extrabold text-gray-800 truncate">{{ $chatName }}</h3>
                    <div class="flex items-center text-xs">
                        <span class="{{ $isOnline ? 'text-emerald-600' : 'text-gray-400' }} font-medium">
                            @if ($otherUser)
                                {{ $otherUser->getChatActivityStatus($userTimezone) }}
                            @else
                                {{ __('Last seen recently') }}
                            @endif
                        </span>
                        <span x-show="typingUser"
                              x-text="typingUser ? `, ${typingUser} ${'{{ __('is typing...') }}'}` : ''"
                              class="text-pink-600 ml-1 font-medium" x-transition></span>
                    </div>
                </div>
            </div>

            {{-- Clock --}}
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-50 border border-pink-100"
                 x-data="{
                    time: '',
                    userTimezone: '{{ $userTimezone }}',
                    updateTime() {
                        const now = new Date();
                        this.time = now.toLocaleString('en-US', {
                            timeZone: this.userTimezone,
                            hour12: true,
                            hour: '2-digit',
                            minute: '2-digit'
                        }).replace(/am|pm/gi, match => match.toUpperCase());
                    }
                 }"
                 x-init="updateTime(); setInterval(() => updateTime(), 1000)">
                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs text-gray-700 font-semibold" x-text="time"></span>
            </div>
        </div>

        {{-- ═══ Messages Area ═════════════════════════════════════════════ --}}
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-1"
             id="chat-messages"
             x-ref="chatMessages"
             style="background:linear-gradient(180deg,#FFF5F9 0%,#FFFFFF 100%)"
             x-init="$nextTick(() => { (function tryScroll(attempt = 0){ const c = $refs.chatMessages; if(!c) return; const nodes = c.querySelectorAll('[data-message-id]'); const last = nodes && nodes.length ? nodes[nodes.length - 1] : null; if (last && last.scrollIntoView) { try { last.scrollIntoView({ block: 'end' }); } catch(e){} } c.scrollTop = Math.max(0, c.scrollHeight - c.clientHeight); if (attempt < 8) { setTimeout(() => tryScroll(attempt + 1), 80); } })(); });">

            @php
                $currentDate = null;
                $lastMessageTime = null;
                $lastSenderId = null;
            @endphp

            @foreach ($messages as $index => $message)
                @php
                    $messageInUserTimezone = auth()->user()->toUserTimezone($message->created_at);
                    $messageDate = $messageInUserTimezone->format('Y-m-d');
                    $currentMessageTime = $messageInUserTimezone->timestamp;

                    $senderAvatar = null;
                    if ($message->sender && !empty($message->sender->profile_image)) {
                        $senderAvatar = Str::startsWith($message->sender->profile_image, ['http://', 'https://'])
                            ? $message->sender->profile_image
                            : asset('storage/' . ltrim($message->sender->profile_image, '/'));
                    } elseif ($message->sender && $message->sender->seller && $message->sender->seller->store_logo) {
                        $senderAvatar = $message->sender->seller->store_logo_url;
                    }

                    $showGroupTime = false;
                    if (
                        $lastMessageTime === null ||
                        $currentMessageTime - $lastMessageTime > 600 ||
                        $lastSenderId !== $message->sender_id
                    ) {
                        $showGroupTime = true;
                    }
                    $lastMessageTime = $currentMessageTime;
                    $lastSenderId = $message->sender_id;
                @endphp

                {{-- Date divider --}}
                @if ($currentDate !== $messageDate)
                    @php $currentDate = $messageDate; @endphp
                    <div class="flex justify-center my-5">
                        <span class="px-4 py-1 text-[11px] font-semibold text-gray-500 bg-white border border-pink-100 rounded-full shadow-sm">
                            @if ($messageInUserTimezone->isToday())
                                {{ __('Today') }}
                            @elseif($messageInUserTimezone->isYesterday())
                                {{ __('Yesterday') }}
                            @else
                                {{ $messageInUserTimezone->format('M j, Y') }}
                            @endif
                        </span>
                    </div>
                @endif

                {{-- Time group label --}}
                @if ($showGroupTime)
                    <div class="flex justify-center my-2">
                        <span class="text-[10px] text-gray-400 font-medium">
                            {{ strtoupper($messageInUserTimezone->format('g:i A')) }}
                        </span>
                    </div>
                @endif

                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}"
                     data-message-id="{{ $message->id }}"
                     data-sender-id="{{ $message->sender_id }}"
                     data-is-read="{{ $message->is_read ? 1 : 0 }}"
                     data-group-time="{{ $showGroupTime ? 1 : 0 }}">

                    <div class="relative w-full">
                        @unless ($showGroupTime)
                            <div x-show="showMessageTime === {{ $message->id }}"
                                 class="absolute left-1/2 transform -translate-x-1/2 text-[10px] text-gray-400 font-medium"
                                 style="top: -0.85rem;"
                                 x-cloak>
                                {{ strtoupper($messageInUserTimezone->format('g:i A')) }}
                            </div>
                        @endunless

                        <div class="flex items-end w-full {{ $message->sender_id === auth()->id() ? 'justify-end' : '' }}">
                            @if ($message->sender_id !== auth()->id())
                                <div class="flex-shrink-0 mr-2">
                                    <div class="h-8 w-8 rounded-full bg-pink-50 border border-pink-200 flex items-center justify-center overflow-hidden">
                                        @if ($senderAvatar)
                                            <img src="{{ $senderAvatar }}" alt="{{ $message->sender ? $message->sender->name : 'Unknown' }}" class="h-full w-full object-cover"
                                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            @php $senderInitialFallback = Str::upper(Str::substr($message->sender->name ?? 'U', 0, 1)); @endphp
                                            <span style="display:none;" class="h-full w-full items-center justify-center bg-gradient-to-br from-pink-400 to-rose-500 text-white font-bold text-xs">
                                                {{ $senderInitialFallback }}
                                            </span>
                                        @else
                                            @php
                                                $senderName = $message->sender->name ?? 'U';
                                                $senderInitial = Str::upper(Str::substr($senderName, 0, 1));
                                            @endphp
                                            <span class="h-full w-full flex items-center justify-center bg-gradient-to-br from-pink-400 to-rose-500 text-white font-bold text-xs">
                                                {{ $senderInitial }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Bubble --}}
                            <div class="flex flex-col {{ $message->sender_id === auth()->id() ? 'items-end' : 'items-start' }}" style="max-width:75%;">
                                <div
                                    @click.stop.prevent="toggleMessage({{ $message->id }}, {{ $showGroupTime ? 'true' : 'false' }})"
                                    x-bind:class="{
                                        'shadow-sm cursor-pointer hover:shadow-md transition-all px-4 py-2.5 relative z-10 select-none': true,
                                        'mt-4 message-shift': (showMessageTime === {{ $message->id }} || showMessageStatus === {{ $message->id }})
                                    }"
                                    @class([
                                        'bg-gradient-to-br from-pink-500 to-rose-500 text-white rounded-2xl rounded-br-md' => $message->sender_id === auth()->id(),
                                        'bg-white text-gray-800 border border-pink-100 rounded-2xl rounded-bl-md' => $message->sender_id !== auth()->id(),
                                    ])>
                                    <div class="text-sm break-words leading-relaxed">
                                        {{ $message->body }}
                                    </div>
                                </div>

                                @if ($message->sender_id === auth()->id())
                                    <div class="mt-1 flex items-center gap-1">
                                        @php
                                            $showByDefault = ($message->id === $lastSentId && $showStatusByDefault);
                                        @endphp
                                        <div
                                            class="text-[10px] font-semibold flex items-center gap-0.5 message-status pointer-events-none {{ $message->is_read ? 'text-emerald-500' : 'text-gray-400' }}"
                                            data-message-id="{{ $message->id }}"
                                            data-is-read="{{ $message->is_read ? 1 : 0 }}"
                                            x-show="showMessageStatus === {{ $message->id }} || showMessageTime === {{ $message->id }} || {{ $showByDefault ? 'true' : 'false' }}"
                                            style="{{ $showByDefault ? '' : 'display: none;' }}"
                                            x-cloak>
                                            @if ($message->is_read)
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('Seen') }}
                                            @else
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('Sent') }}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Typing indicator --}}
            <div x-show="typingUser" class="flex items-end gap-2 mt-2" x-transition>
                <div class="h-8 w-8 rounded-full bg-pink-50 border border-pink-200 flex items-center justify-center flex-shrink-0">
                    <div class="flex gap-1">
                        <div class="w-1.5 h-1.5 bg-pink-500 rounded-full animate-bounce"></div>
                        <div class="w-1.5 h-1.5 bg-pink-500 rounded-full animate-bounce" style="animation-delay: 0.15s"></div>
                        <div class="w-1.5 h-1.5 bg-pink-500 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                    </div>
                </div>
                <div class="bg-white border border-pink-100 px-4 py-2.5 rounded-2xl rounded-bl-md shadow-sm">
                    <span class="text-xs italic text-gray-500"
                          x-text="typingUser ? `${typingUser} ${'{{ __('is typing...') }}'}` : '{{ __('typing...') }}'"></span>
                </div>
            </div>
        </div>

        {{-- ═══ Reply Form ════════════════════════════════════════════════ --}}
        <div class="flex-shrink-0 px-4 py-3 bg-white border-t border-pink-100">
            <div class="relative bg-rose-50/60 border border-pink-100 rounded-full flex items-center px-2 py-1
                        focus-within:border-pink-300 focus-within:bg-white focus-within:shadow-sm transition-all">

                {{-- Attachment --}}
                <button type="button"
                        class="flex-shrink-0 p-2 text-gray-400 hover:text-pink-500 rounded-full hover:bg-pink-50 transition-colors"
                        title="{{ __('Attach') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                </button>

                {{-- Emoji --}}
                <button type="button"
                        class="flex-shrink-0 p-2 text-gray-400 hover:text-pink-500 rounded-full hover:bg-pink-50 transition-colors"
                        title="{{ __('Emoji') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>

                {{-- Input --}}
                <input
                    x-model="messageText"
                    @keydown="handleKeydown($event)"
                    @input="handleInput()"
                    type="text"
                    placeholder="{{ __('Type your message...') }}"
                    class="flex-1 px-3 py-2 text-gray-800 placeholder-gray-400 bg-transparent
                           border-0 outline-none focus:outline-none focus:ring-0 text-sm"
                    :disabled="loading"
                    @keyup.enter="sendMessage()" />

                {{-- Send button --}}
                <button type="button"
                        @click="sendMessage()"
                        :disabled="!messageText.trim() || loading"
                        :class="{
                            'opacity-40 cursor-not-allowed bg-gray-300': !messageText.trim() || loading,
                            'bg-orange-500 hover:bg-orange-600 shadow-md': messageText.trim() && !loading
                        }"
                        class="flex-shrink-0 w-10 h-10 rounded-full text-white transition-all
                               flex items-center justify-center ml-1">
                    <template x-if="!loading">
                        <svg class="w-4 h-4 -mr-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </template>
                    <template x-if="loading">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                </button>
            </div>
        </div>
    </div>
    @push('scripts')
        @include('chat.chat-scripts')
    @endpush
@else
    {{-- Empty state when no conversation selected --}}
    <div class="hidden md:flex flex-col items-center justify-center h-full p-8 text-center">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center mb-5">
            <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </div>
        <h3 class="text-lg font-extrabold text-gray-800 mb-1">{{ __('Select a conversation') }}</h3>
        <p class="text-sm text-gray-500 max-w-xs">{{ __('Choose someone from your messages list to start chatting') }}</p>
    </div>
@endif
