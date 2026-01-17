
<?php if(isset($currentChat) && $currentChat): ?>
    <div x-data="chatComponent()" x-init="initChat(<?php echo e($currentChat->id); ?>, <?php echo e(json_encode($lastSentId ?? null)); ?>, <?php echo e(json_encode($lastSentMessageTs ?? null)); ?>)" class="flex flex-col h-full">
        <?php
            $chatName = $currentChat->getNameForUser(auth()->id());
            $otherUser = $currentChat->getOtherUserForUser(auth()->id());
            $isOnline = $otherUser && method_exists($otherUser, 'isOnline') && $otherUser->isOnline();

            $chatAvatar = null;
            if ($otherUser && $otherUser->seller && !empty($otherUser->seller->store_logo_url)) {
                $chatAvatar = $otherUser->seller->store_logo_url;
            } elseif ($otherUser && !empty($otherUser->profile_image)) {
                $chatAvatar = Str::startsWith($otherUser->profile_image, ['http://', 'https://'])
                    ? $otherUser->profile_image
                    : asset('storage/' . ltrim($otherUser->profile_image, '/'));
            }

            $userTimezone = auth()->user()->getTimezone();

            $lastSentMessage = $messages->last(function ($message) {
                return $message->sender_id === auth()->id();
            });
            $lastSentId = $lastSentMessage ? $lastSentMessage->id : null;
            $lastSentMessageTs = $lastSentMessage ? $lastSentMessage->created_at->toIso8601String() : null;
            $showStatusByDefault = $lastSentMessage && $lastSentMessage->created_at->greaterThan(now()->subMinutes(10));
        ?>

        <!-- Chat Header -->
        <div class="flex-shrink-0 px-4 py-3.5 bg-gray-100 dark:bg-gray-800 flex items-center justify-between border-b border-gray-300 dark:border-gray-700">
            <div class="flex items-center flex-1">
                <a href="<?php echo e(route('chat.index')); ?>"
                    class="mr-3 p-1 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white rounded-lg hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors md:hidden">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-500 flex items-center justify-center overflow-hidden">
                    <?php if($chatAvatar): ?>
                        <img src="<?php echo e($chatAvatar); ?>" alt="<?php echo e($chatName); ?>" class="h-full w-full object-cover">
                    <?php else: ?>
                        <?php
                            $initial = $chatName ? Str::upper(Str::substr($chatName, 0, 1)) : 'U';
                        ?>
                        <div class="h-full w-full flex items-center justify-center">
                            <span class="inline-block h-10 w-10 rounded-full flex items-center justify-center text-white font-semibold
                                        bg-indigo-500 dark:bg-indigo-600 text-lg">
                                <?php echo e($initial); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="ml-3 flex-1">
                    <h3 class="text-base font-medium text-gray-900 dark:text-white"><?php echo e($chatName); ?></h3>
                    <div class="flex items-center">
                        <span class="text-xs <?php echo e($isOnline ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'); ?>">
                            <?php if($otherUser): ?>
                                <?php echo e($otherUser->getChatActivityStatus($userTimezone)); ?>

                            <?php else: ?>
                                Last seen recently
                            <?php endif; ?>
                        </span>
                        <span x-show="typingUser" x-text="typingUser ? `, ${typingUser} is typing...` : ''"
                            class="text-xs text-blue-600 dark:text-blue-400 ml-1" x-transition></span>
                    </div>
                </div>
            </div>

            <div class="text-sm text-gray-600 dark:text-gray-300 font-medium" x-data="{
                time: '',
                userTimezone: '<?php echo e($userTimezone); ?>',
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
            x-init="updateTime(); setInterval(() => updateTime(), 1000)" x-text="time"></div>
        </div>

        <!-- Chat Messages -->
    <div class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-800 p-4 space-y-1 pb-2"
        id="chat-messages"
        x-ref="chatMessages"
        x-init="$nextTick(() => { (function tryScroll(attempt = 0){ const c = $refs.chatMessages; if(!c) return; const nodes = c.querySelectorAll('[data-message-id]'); const last = nodes && nodes.length ? nodes[nodes.length - 1] : null; if (last && last.scrollIntoView) { try { last.scrollIntoView({ block: 'end' }); } catch(e){} } c.scrollTop = Math.max(0, c.scrollHeight - c.clientHeight); if (attempt < 8) { setTimeout(() => tryScroll(attempt + 1), 80); } })(); });">
    <?php
        $currentDate = null;
        $lastMessageTime = null;
        $lastSenderId = null;
    ?>
 
    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $messageInUserTimezone = auth()->user()->toUserTimezone($message->created_at);
            $messageDate = $messageInUserTimezone->format('Y-m-d');
            $currentMessageTime = $messageInUserTimezone->timestamp;

            $senderAvatar = null;
            if ($message->sender && $message->sender->seller && !empty($message->sender->seller->store_logo_url)) {
                $senderAvatar = $message->sender->seller->store_logo_url;
            } elseif ($message->sender && !empty($message->sender->profile_image)) {
                $senderAvatar = Str::startsWith($message->sender->profile_image, ['http://', 'https://'])
                    ? $message->sender->profile_image
                    : asset('storage/' . ltrim($message->sender->profile_image, '/'));
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
        ?>

        <?php if($currentDate !== $messageDate): ?>
            <?php $currentDate = $messageDate; ?>
            <div class="flex justify-center my-4">
                <span class="px-3 py-1 text-xs text-gray-600 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 rounded-full">
                    <?php if($messageInUserTimezone->isToday()): ?>
                        Today
                    <?php elseif($messageInUserTimezone->isYesterday()): ?>
                        Yesterday
                    <?php else: ?>
                        <?php echo e($messageInUserTimezone->format('M j, Y')); ?>

                    <?php endif; ?>
                </span>
            </div>
        <?php endif; ?>

        <?php if($showGroupTime): ?>
            <div class="flex justify-center my-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    <?php echo e(strtoupper($messageInUserTimezone->format('g:i A'))); ?>

                </span>
            </div>
        <?php endif; ?> 

        <div class="flex <?php echo e($message->sender_id === auth()->id() ? 'justify-end' : 'justify-start'); ?>"
            data-message-id="<?php echo e($message->id); ?>"
            data-sender-id="<?php echo e($message->sender_id); ?>"
            data-is-read="<?php echo e($message->is_read ? 1 : 0); ?>"
            data-group-time="<?php echo e($showGroupTime ? 1 : 0); ?>">

            <!-- Full-width relative wrapper so the time can be absolutely centered across the column -->
            <div class="relative w-full">
                <!-- Absolutely centered time across the entire column -->
                <?php if (! ($showGroupTime)): ?>
                    <div x-show="showMessageTime === <?php echo e($message->id); ?>"
                        class="absolute left-1/2 transform -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400"
                        style="top: -0.85rem;"
                        x-cloak>
                        <?php echo e(strtoupper($messageInUserTimezone->format('g:i A'))); ?>

                    </div>
                <?php endif; ?>

                <div class="flex items-start w-full <?php echo e($message->sender_id === auth()->id() ? 'justify-end' : ''); ?>">
                    <?php if($message->sender_id !== auth()->id()): ?>
                        <div class="flex-shrink-0 mr-2">
                            <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center overflow-hidden">
                                <?php if($senderAvatar): ?>
                                    <img src="<?php echo e($senderAvatar); ?>" alt="<?php echo e($message->sender ? $message->sender->name : 'Unknown'); ?>" class="h-full w-full object-cover">
                                <?php else: ?>
                                    <?php
                                        $senderName = $message->sender->name ?? 'U';
                                        $senderInitial = Str::upper(Str::substr($senderName, 0, 1));
                                    ?>
                                    <span class="inline-block h-8 w-8 rounded-full flex items-center justify-center text-white font-medium
                                                bg-gray-500 dark:bg-gray-700 text-sm">
                                        <?php echo e($senderInitial); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <div class="w-full flex flex-col <?php echo e($message->sender_id === auth()->id() ? 'items-end' : 'items-start'); ?>" style="max-width:75%;">
                        <div
                            @click.stop.prevent="toggleMessage(<?php echo e($message->id); ?>, <?php echo e($showGroupTime ? 'true' : 'false'); ?>)"
                            x-bind:class="{
                                'shadow-sm cursor-pointer hover:shadow-md transition-all px-3 py-2 relative z-10 select-none': true,
                                'mt-4 message-shift': (showMessageTime === <?php echo e($message->id); ?> || showMessageStatus === <?php echo e($message->id); ?>)
                            }"
                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                // we keep bg classes via Blade for coloring
                                'bg-blue-500 text-white rounded-2xl rounded-br-lg' => $message->sender_id === auth()->id(),
                                'bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-600 rounded-2xl rounded-bl-lg' => $message->sender_id !== auth()->id(),
                            ]); ?>">
                            <div class="text-sm break-words leading-tight text-center">
                                <?php echo e($message->body); ?>

                            </div>
                        </div>

                        <?php if($message->sender_id === auth()->id()): ?>
                            <div class="mt-1 text-sm relative flex items-center space-x-1">
                                <?php
                                    $showByDefault = ($message->id === $lastSentId && $showStatusByDefault);
                                ?>
                                <div
                                    class="text-xs relative message-status pointer-events-none <?php echo e($message->is_read ? 'text-green-500 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'); ?>"
                                    data-message-id="<?php echo e($message->id); ?>"
                                    data-is-read="<?php echo e($message->is_read ? 1 : 0); ?>"
                                    x-show="showMessageStatus === <?php echo e($message->id); ?> || showMessageTime === <?php echo e($message->id); ?> || <?php echo e($showByDefault ? 'true' : 'false'); ?>"
                                    style="<?php echo e($showByDefault ? '' : 'display: none;'); ?>"
                                    x-cloak>
                                    <?php echo e($message->is_read ? 'Seen' : 'Sent'); ?>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div x-show="typingUser" class="flex items-center space-x-2" x-transition>
        <div class="flex-shrink-0">
            <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                <div class="flex space-x-1">
                    <div class="w-1.5 h-1.5 bg-gray-500 dark:bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-1.5 h-1.5 bg-gray-500 dark:bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-1.5 h-1.5 bg-gray-500 dark:bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-600 px-4 py-3 rounded-2xl rounded-bl-lg shadow-sm">
            <span class="text-sm italic" x-text="typingUser ? `${typingUser} is typing...` : 'typing...'"></span>
        </div>
    </div>

    </div>
        <!-- Reply Form -->
        <div class="flex-shrink-0 px-6 py-2 mt-2 bg-gray-100 dark:bg-gray-800 border-t border-gray-300 dark:border-gray-800">
            <div class="relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full flex items-center px-2 py-1.5 shadow-sm">
                <!-- Optional: Attachment button -->
                <button type="button"
                    class="flex-shrink-0 p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 rounded-full hover:bg-gray-100 dark:hover:bg-gray-500 transition-colors"
                    title="Attach">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                </button>
                <div class="flex-1 flex items-center">
                    <!-- Form input text -->
                    <input
                        x-model="messageText"
                        @keydown="handleKeydown($event)"
                        @input="handleInput()"
                        type="text"
                        placeholder="Type your message..."
                        class="flex-1 px-3 py-2 text-gray-800 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 rounded-full text-sm border-0 outline-0 focus:outline-0 focus:ring-0"
                        :disabled="loading"
                        @keyup.enter="sendMessage()"
                    />
                    <!-- Send button (paper plane icon) -->
                    <button type="button"
                        @click="sendMessage()"
                        :disabled="!messageText.trim() || loading"
                        :class="{
                            'opacity-50 cursor-not-allowed': !messageText.trim() || loading,
                            'bg-blue-500 hover:bg-blue-600': messageText.trim() && !loading,
                            'bg-gray-400 dark:bg-gray-500': !messageText.trim() || loading
                        }"
                        class="flex-shrink-0 p-2 rounded-full text-white transition-colors ml-2 flex items-center justify-center">
                        <template x-if="!loading">
                            <!-- Paper plane icon only -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </template>
                        <template x-if="loading">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <?php echo $__env->make('chat.chat-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/chat/_conversation.blade.php ENDPATH**/ ?>