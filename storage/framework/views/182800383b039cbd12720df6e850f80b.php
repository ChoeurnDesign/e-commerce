<script>
window.chatComponent = function() {
    return {
        chatId: null,
        messageText: '',
        messages: [],
        loading: false,
        error: null,
        typing: false,
        typingTimer: null,
        typingUser: null,
        currentUserId: <?php echo e(json_encode(auth()->id())); ?>,
        showMessageTime: null,
        showMessageStatus: null,
        lastSentMessageId: null,
        lastSentMessageTs: null,
        _messageToggleTimer: null,

        initChat(chatId, lastSentId = null, lastSentTs = null) {
            this.chatId = chatId;
            this.lastSentMessageId = lastSentId;
            this.lastSentMessageTs = lastSentTs;
            this.populateMessagesFromDOM();

            // Wait one tick and a small delay to let layout/images/fonts settle,
            // then force-scroll to the bottom so the latest message is visible.
            this.$nextTick(() => {
                setTimeout(() => this.scrollToBottom(true), 60);
            });

            this.setupEchoListeners();
            setTimeout(() => this.markChatAsRead(), 200);

            // Refresh activity labels if client helper exists
            if (window.refreshAllActivityLabels) {
                try { window.refreshAllActivityLabels(); } catch (e) { /* noop */ }
            }
        },

        // Toggle handler used by Blade @click and by dynamically inserted nodes
        toggleMessage(messageId, groupTime) {
            // toggle the message time
            if (!groupTime) {
                this.showMessageTime = (this.showMessageTime === messageId) ? null : messageId;
            }

            // toggle status only for sender's messages
            const wrapper = document.querySelector(`[data-message-id="${messageId}"]`);
            const senderId = wrapper ? Number(wrapper.getAttribute('data-sender-id')) : null;

            if (senderId === this.currentUserId) {
                this.showMessageStatus = (this.showMessageStatus === messageId) ? null : messageId;

                // If the .message-status element was created dynamically (no Alpine binding),
                // toggle its display manually so dynamically-inserted messages behave the same.
                const statusEl = wrapper ? wrapper.querySelector('.message-status') : null;
                if (statusEl) {
                    const computed = window.getComputedStyle(statusEl).display;
                    statusEl.style.display = (computed === 'none') ? '' : 'none';
                }
            }

            // auto-hide after a short interval
            clearTimeout(this._messageToggleTimer);
            this._messageToggleTimer = setTimeout(() => {
                if (this.showMessageTime === messageId) this.showMessageTime = null;
                if (this.showMessageStatus === messageId) this.showMessageStatus = null;

                // ensure manual DOM toggles are reset (hide status element)
                const w = document.querySelector(`[data-message-id="${messageId}"]`);
                const s = w ? w.querySelector('.message-status') : null;
                if (s) s.style.display = 'none';
            }, 3500);
        },

        populateMessagesFromDOM() {
            try {
                const nodes = document.querySelectorAll('[data-message-id]');
                nodes.forEach(node => {
                    const id = Number(node.getAttribute('data-message-id'));
                    const senderId = Number(node.getAttribute('data-sender-id'));
                    const isReadAttr = node.getAttribute('data-is-read');
                    const is_read = (isReadAttr === '1' || isReadAttr === 'true');
                    if (!this.messages.find(m => m.id === id)) {
                        this.messages.push({ id, sender_id: senderId, is_read });
                    }
                    // Attach click handlers (defensive). If Blade provided data-group-time attribute,
                    // it will be respected in toggleMessage calls from other code paths.
                    if (node.addEventListener) {
                        // remove previously attached handler if present
                        if (node.__chatClickHandler__) node.removeEventListener('click', node.__chatClickHandler__);
                        const handler = (ev) => { try { this.toggleMessage(id, node.getAttribute('data-group-time') === '1'); } catch (e) { /* noop */ } };
                        node.__chatClickHandler__ = handler;
                        node.addEventListener('click', handler, { passive: true });
                    }
                });
            } catch (err) {
                console.error('populateMessagesFromDOM error', err);
            }
        },

        setupEchoListeners() {
            if (!window.Echo) return;
            window.Echo.channel(`chat.${this.chatId}`)
                .listen('NewChatMessage', (e) => {
                    if (e.sender_id !== this.currentUserId) {
                        this.addMessage(e);
                        this.markChatAsRead();
                    } else {
                        this.addMessage(e);
                    }
                })
                .listen('MessageRead', (e) => {
                    // Only update UI if the other user marked messages read
                    if (e.user_id !== this.currentUserId) {
                        this.markMessagesAsReadInUI();
                        this.updateMessageStatusInDOM();
                    }
                })
                .listen('UserTyping', (e) => { if (e.user_id !== this.currentUserId) this.showTypingIndicator(e.user_name); })
                .listen('UserStoppedTyping', (e) => { if (e.user_id !== this.currentUserId) this.hideTypingIndicator(); });
        },

        addMessage(message) {
            // keep internal array in sync
            let exists = this.messages.find(m => m.id === message.id);
            if (!exists) {
                if (typeof message.is_read === 'undefined') message.is_read = false;
                this.messages.push(message);
            } else {
                Object.assign(exists, message);
            }

            // ensure sender sees message immediately
            this.insertMessageToDOM(message);

            // Scroll to bottom after a short delay so layout can settle
            setTimeout(() => this.scrollToBottom(), 20);

            if (message.sender_id !== this.currentUserId) this.playNotificationSound();
        },

        insertMessageToDOM(message) {
            try {
                // Avoid duplicate DOM nodes
                if (document.querySelector(`[data-message-id="${message.id}"]`)) {
                    // update flags if element already exists
                    const existing = document.querySelector(`[data-message-id="${message.id}"]`);
                    existing.setAttribute('data-is-read', message.is_read ? '1' : '0');
                    const statusEl = existing.querySelector('.message-status');
                    if (statusEl) statusEl.setAttribute('data-is-read', message.is_read ? '1' : '0');
                    return;
                }

                // Build DOM structure (simplified for dynamic messages) and append
                const wrapper = document.createElement('div');
                wrapper.className = 'mb-1 flex';
                wrapper.classList.add(message.sender_id === this.currentUserId ? 'justify-end' : 'justify-start');
                wrapper.setAttribute('data-message-id', message.id);
                wrapper.setAttribute('data-sender-id', message.sender_id);
                wrapper.setAttribute('data-is-read', message.is_read ? '1' : '0');
                // dynamic messages are not group headers by default
                wrapper.setAttribute('data-group-time', '0');

                const bubbleClasses = message.sender_id === this.currentUserId
                    ? 'shadow-sm cursor-pointer hover:shadow-md transition-all px-3 py-2 bg-blue-500 text-white rounded-2xl rounded-br-lg'
                    : 'shadow-sm cursor-pointer hover:shadow-md transition-all px-3 py-2 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-600 rounded-2xl rounded-bl-lg';

                const senderBlock = message.sender_id !== this.currentUserId ? `
                    <div class="flex-shrink-0 mr-2">
                        <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center overflow-hidden"></div>
                    </div>` : '';

                const shouldShowStatus = (message.sender_id === this.currentUserId) && (String(message.id) === String(this.lastSentMessageId));
                const statusHtml = message.sender_id === this.currentUserId ? `
                    <div class="mt-1">
                        <div class="text-xs message-status" data-message-id="${message.id}" data-is-read="${message.is_read ? 1 : 0}" style="${shouldShowStatus ? '' : 'display: none;'}">
                            ${message.is_read ? 'Seen' : 'Sent'}
                        </div>
                    </div>` : '';

                wrapper.innerHTML = `
                    <div class="flex items-start w-full ${message.sender_id === this.currentUserId ? 'justify-end' : ''}">
                        ${senderBlock}
                        <div class="flex flex-col ${message.sender_id === this.currentUserId ? 'items-end' : 'items-start'}" style="max-width:75%;">
                            <div class="${bubbleClasses}">
                                <div class="text-sm break-words leading-tight">${this.escapeHtml(message.body ?? '')}</div>
                            </div>
                            ${statusHtml}
                        </div>
                    </div>
                `;

                const container = document.getElementById('chat-messages');
                if (container) {
                    container.appendChild(wrapper);

                    // Attach click handler so dynamic messages behave like Blade-rendered ones
                    wrapper.addEventListener('click', (ev) => {
                        try { this.toggleMessage(message.id, false); } catch (e) { console.error(e); }
                    }, { passive: true });
                } else console.warn('chat-messages container not found');
            } catch (err) {
                console.error('insertMessageToDOM error', err);
            }
        },

        // small XSS protection
        escapeHtml(unsafe) {
            if (unsafe === null || typeof unsafe === 'undefined') return '';
            return String(unsafe).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        },

        async sendMessage() {
            if (!this.messageText.trim() || this.loading) return;
            this.loading = true;
            const messageBody = this.messageText.trim();
            this.messageText = '';
            this.stopTyping();

            try {
                const response = await fetch(`/chat/${this.chatId}/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ body: messageBody, type: 'text' })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (typeof data.is_read === 'undefined') data.is_read = false;

                // Render locally so sender sees the message immediately
                this.addMessage(data);
                this.lastSentMessageId = data.id;
                this.lastSentMessageTs = data.created_at;
            } catch (error) {
                this.messageText = messageBody;
                this.error = error.message || 'Failed to send message. Please try again.';
                setTimeout(() => this.error = null, 5000);
            } finally {
                this.loading = false;
            }
        },

        async markChatAsRead() {
            if (!this.chatId) return;
            const url = `/chat/${this.chatId}/mark-as-read`;
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            try {
                let payload = null;

                if (window.axios) {
                    const res = await window.axios.post(url);
                    payload = res && res.data ? res.data : null;
                } else {
                    const resp = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf || '',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin'
                    });
                    if (resp.ok) payload = await resp.json().catch(() => null);
                }

                // Update conversation UI
                this.markMessagesAsReadInUI();
                this.updateMessageStatusInDOM();

                // Hide per-chat sidebar badge
                try {
                    const badge = document.querySelector(`.chat-item-unread[data-chat-id="${this.chatId}"]`);
                    if (badge) {
                        badge.dataset.unread = '0';
                        badge.setAttribute('aria-hidden', 'true');
                        badge.classList.add('hidden');
                        const inner = badge.querySelector('.chat-unread-visible');
                        if (inner) inner.textContent = '';
                    }
                } catch (e) { console.debug('sidebar badge update failed', e); }

                // Update header badge using returned total_unread or call helper to fetch
                const total = payload && typeof payload.total_unread !== 'undefined' ? Number(payload.total_unread) : null;
                try {
                    if (window.__chatUnread && typeof window.__chatUnread.refreshAll === 'function') {
                        window.__chatUnread.refreshAll();
                    } else if (total !== null) {
                        updateHeaderBadge(total);
                    } else {
                        // fallback: get fresh total from lightweight endpoint
                        fetch('/chat/unread-count', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
                            .then(r => r.ok ? r.json() : null)
                            .then(json => { if (json && typeof json.total_unread !== 'undefined') updateHeaderBadge(Number(json.total_unread)); })
                            .catch(() => {/* noop */});
                    }
                } catch (e) {
                    console.debug('header update failed', e);
                }

            } catch (err) {
                console.error('Error marking chat as read:', err);
            }
        },

        markMessagesAsReadInUI() {
            this.messages = this.messages.map(m => { if (m.sender_id !== this.currentUserId) m.is_read = true; return m; });
        },

        // Update all .message-status elements in DOM to match internal messages state
        updateMessageStatusInDOM() {
            document.querySelectorAll('.message-status').forEach(el => {
                const messageId = el.getAttribute('data-message-id');
                const wrapper = el.closest('[data-message-id]');
                const senderId = wrapper ? Number(wrapper.getAttribute('data-sender-id')) : null;

                if (!messageId) return;

                const message = this.messages.find(m => m.id == messageId);
                if (!message) return;

                // Only update status for messages sent by current user
                if (senderId === this.currentUserId) {
                    el.textContent = message.is_read ? 'Seen' : 'Sent';

                    if (message.is_read) {
                        el.classList.add('text-green-500', 'dark:text-green-400');
                        el.classList.remove('text-gray-500', 'dark:text-gray-400');
                    } else {
                        el.classList.remove('text-green-500', 'dark:text-green-400');
                        el.classList.add('text-gray-500', 'dark:text-gray-400');
                    }

                    // If this element was hidden because it was dynamically inserted, make it briefly visible if appropriate
                    if (window.getComputedStyle(el).display === 'none' && (this.showMessageStatus === Number(messageId) || this.showMessageTime === Number(messageId))) {
                        el.style.display = '';
                    }
                }

                // For messages from other users, keep as-is (you may want to update other UI)
                if (senderId !== this.currentUserId && wrapper) {
                    wrapper.setAttribute('data-is-read', message.is_read ? '1' : '0');
                }
            });
        },

        playNotificationSound() { try { const a = new (window.AudioContext || window.webkitAudioContext)(); const o = a.createOscillator(); const g = a.createGain(); o.connect(g); g.connect(a.destination); o.frequency.value = 800; o.type = 'sine'; g.gain.value = 0.1; o.start(); o.stop(a.currentTime + 0.1); } catch(e){} },

        // Robust scrollToBottom using the last message element (preferred)
        scrollToBottom(force = false) {
            this.$nextTick(() => {
                const container = document.getElementById('chat-messages');
                if (!container) return;

                // If not force and user has scrolled away, don't yank them
                if (!force) {
                    const threshold = 140; // px from bottom to still auto-scroll
                    if ((container.scrollHeight - container.scrollTop - container.clientHeight) > threshold) {
                        return;
                    }
                }

                // Try to scroll the last message into view
                const last = container.querySelector('[data-message-id]:last-child, [data-message-id]:last-of-type');
                if (last && last.scrollIntoView) {
                    try {
                        last.scrollIntoView({ behavior: 'auto', block: 'end', inline: 'nearest' });
                        return;
                    } catch (e) {
                        // fallback to numeric scroll
                    }
                }

                container.scrollTop = container.scrollHeight;
            });
        },

        showTypingIndicator(userName) { this.typingUser = userName; setTimeout(()=>this.hideTypingIndicator(),3000); },
        hideTypingIndicator() { this.typingUser = null; },
        handleKeydown(event){ if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); this.sendMessage(); } else this.handleTyping(); },
        handleInput(){ this.handleTyping(); },
        handleTyping() { if(!this.chatId) return; clearTimeout(this.typingTimer); if(!this.typing){ this.typing = true; this.sendTypingIndicator(); } this.typingTimer = setTimeout(()=>this.stopTyping(),2000); },
        async sendTypingIndicator(){ if(!this.chatId) return; const url=`/chat/${this.chatId}/typing`; const csrf=document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'); try { if(window.axios){ await window.axios.post(url); return; } await fetch(url,{method:'POST',headers:{'X-CSRF-TOKEN':csrf||'','Accept':'application/json','Content-Type':'application/json'},credentials:'same-origin'}); } catch(e){ console.error(e); } },
        async stopTyping(){ if(this.typing){ this.typing=false; const url=`/chat/${this.chatId}/stop-typing`; const csrf=document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'); try{ if(window.axios){ await window.axios.post(url); return; } await fetch(url,{method:'POST',headers:{'X-CSRF-TOKEN':csrf||'','Accept':'application/json','Content-Type':'application/json'},credentials:'same-origin'}); } catch(e){ console.error(e); } } clearTimeout(this.typingTimer); },
        destroy(){ this.stopTyping(); clearTimeout(this.typingTimer); clearTimeout(this._messageToggleTimer); if(window.Echo && this.chatId){ try{ window.Echo.leave(`chat.${this.chatId}`); } catch(e){ console.error(e); } } }
    };
}
</script><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/chat/chat-scripts.blade.php ENDPATH**/ ?>