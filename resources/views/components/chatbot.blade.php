{{-- ============================================================
     ShopExpress Customer Support Chatbot
     Rule-based, no API key required, dark-mode aware
     ============================================================ --}}

{{-- ── Floating trigger button ───────────────────────────────── --}}
<button id="chatbot-trigger"
    onclick="window.chatbot.toggle()"
    aria-label="Open support chat"
    class="fixed bottom-5 right-4 sm:bottom-6 sm:right-6 z-50 w-13 h-13 sm:w-14 sm:h-14 rounded-full shadow-xl flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-300"
    style="width:52px;height:52px">
    <span id="chatbot-icon-open">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z"/>
        </svg>
    </span>
    <span id="chatbot-icon-close" class="hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </span>
    {{-- unread badge --}}
    <span id="chatbot-badge"
          class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold hidden">1</span>
</button>

{{-- ── Chat window ───────────────────────────────────────────── --}}
<div id="chatbot-window"
     class="fixed z-50 rounded-2xl shadow-2xl flex flex-col overflow-hidden
            bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
            transition-all duration-300 origin-bottom-right scale-0 opacity-0 pointer-events-none
            bottom-20 right-2 left-2 sm:left-auto sm:right-6 sm:w-96 sm:bottom-24"
     style="max-height: min(560px, calc(100svh - 8rem))">

    {{-- Header --}}
    <div class="flex items-center gap-3 px-4 py-3 bg-indigo-600 dark:bg-indigo-700">
        <div class="relative flex-shrink-0">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-xl">🤖</div>
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-indigo-600 rounded-full"></span>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-white font-semibold text-sm leading-tight">ShopExpress Assistant</p>
            <p class="text-indigo-200 text-xs">Always here to help 😊</p>
        </div>
        <button onclick="window.chatbot.toggle()" class="text-white/70 hover:text-white transition-colors p-1 rounded-full hover:bg-white/10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Messages area --}}
    <div id="chatbot-messages"
         class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 dark:bg-gray-800"
         style="min-height:260px; max-height:320px;">
        {{-- Messages injected by JS --}}
    </div>

    {{-- Quick replies --}}
    <div id="chatbot-quick-replies" class="px-3 py-2 flex flex-wrap gap-1.5 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        {{-- Injected by JS --}}
    </div>

    {{-- Input --}}
    <div class="flex items-center gap-2 px-3 py-3 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <input id="chatbot-input"
               type="text"
               placeholder="Type your question…"
               maxlength="200"
               autocomplete="off"
               class="flex-1 text-sm rounded-full border border-gray-300 dark:border-gray-600
                      bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                      placeholder-gray-400 dark:placeholder-gray-500
                      px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
               onkeydown="if(event.key==='Enter') window.chatbot.send()">
        <button onclick="window.chatbot.send()"
                class="w-9 h-9 flex-shrink-0 rounded-full bg-indigo-600 hover:bg-indigo-700
                       text-white flex items-center justify-center transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <svg class="w-4 h-4 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
        </button>
    </div>
</div>

<script>
window.chatbot = (function () {
    let isOpen = false;
    let badgeShown = true;

    // ── Knowledge base ─────────────────────────────────────────────────────
    const KB = [
        {
            keys: ['hi','hello','hey','good morning','good afternoon','good evening','start','begin','help me','what can you do'],
            reply: `👋 <strong>Hello! Welcome to ShopExpress!</strong><br><br>I'm your virtual assistant. I can help you with:<br>
• 🔥 Top selling products<br>
• 🛒 How to place an order<br>
• 🏪 How to become a seller<br>
• 🚚 Shipping & delivery info<br>
• 💳 Payment methods<br>
• ↩️ Returns & refunds<br><br>
Just type your question or tap a button below! 😊`,
        },
        {
            keys: ['top','best','popular','trending','hot deal','most sold','on sale','discount','recommend','featured'],
            reply: `🔥 <strong>Top & Featured Products</strong><br><br>
Our best-selling products are updated daily! Browse them here:<br><br>
👉 <a href="/products" class="text-indigo-600 dark:text-indigo-400 underline font-medium">View All Products</a><br>
👉 <a href="/shops-on-sale" class="text-indigo-600 dark:text-indigo-400 underline font-medium">Shop on Sale</a><br><br>
Use the filters (price, category, rating) to find exactly what you need!`,
        },
        {
            keys: ['buy','order','how to buy','how to order','purchase','add to cart','checkout','place order','shop'],
            reply: `🛒 <strong>How to Place an Order</strong><br><br>
It's easy! Follow these steps:<br><br>
<strong>1.</strong> Browse <a href="/products" class="text-indigo-600 dark:text-indigo-400 underline">products</a> and click <strong>"Add to Cart"</strong><br>
<strong>2.</strong> Go to your cart and review your items<br>
<strong>3.</strong> Click <strong>"Proceed to Checkout"</strong><br>
<strong>4.</strong> Enter your shipping address<br>
<strong>5.</strong> Choose a payment method<br>
<strong>6.</strong> Confirm and your order is placed! ✅<br><br>
You'll receive a confirmation email right away.`,
        },
        {
            keys: ['seller','sell','vendor','open store','become seller','register seller','join as seller','create store','my shop'],
            reply: `🏪 <strong>How to Become a Seller</strong><br><br>
Start selling on ShopExpress in a few steps:<br><br>
<strong>1.</strong> Create a customer account (or log in)<br>
<strong>2.</strong> Click <strong>"Become a Seller"</strong> from your dashboard<br>
<strong>3.</strong> Fill in your store name, description & contact<br>
<strong>4.</strong> Upload your business document<br>
<strong>5.</strong> Submit and wait for admin approval (1–2 days)<br><br>
👉 <a href="/become-seller" class="text-indigo-600 dark:text-indigo-400 underline font-medium">Apply Now</a> — it's free!`,
        },
        {
            keys: ['ship','deliver','delivery','shipping','track','arrive','how long','when will','dispatch'],
            reply: `🚚 <strong>Shipping & Delivery</strong><br><br>
• <strong>Standard:</strong> 3–7 business days<br>
• <strong>Express:</strong> 1–3 business days<br>
• <strong>Free shipping</strong> on orders over $50 🎉<br><br>
After your order ships, you'll get a tracking number by email. You can also check tracking under <strong>My Orders</strong> in your account.`,
        },
        {
            keys: ['return','refund','exchange','money back','cancel order','cancel','wrong item','damaged'],
            reply: `↩️ <strong>Returns & Refunds</strong><br><br>
We want you to be happy with your purchase!<br><br>
• Returns accepted within <strong>30 days</strong> of delivery<br>
• Item must be unused & in original packaging<br>
• Refunds processed in <strong>5–7 business days</strong><br><br>
To start a return: go to <strong>My Orders</strong> → select the order → click <strong>"Return Item"</strong>.<br><br>
Still need help? <a href="/contact" class="text-indigo-600 dark:text-indigo-400 underline">Contact our team</a>`,
        },
        {
            keys: ['pay','payment','credit card','debit card','paypal','cash','method','how to pay','visa','mastercard','cod'],
            reply: `💳 <strong>Payment Methods</strong><br><br>
We accept:<br><br>
✅ <strong>Credit / Debit Card</strong> (Visa, Mastercard)<br>
✅ <strong>PayPal</strong><br>
✅ <strong>Cash on Delivery (COD)</strong><br><br>
All online transactions are protected with <strong>SSL encryption</strong>. We never store your card details.`,
        },
        {
            keys: ['account','login','sign in','sign up','register','profile','password','forgot','reset password'],
            reply: `👤 <strong>Account Help</strong><br><br>
• <strong>Register:</strong> Click <a href="/register" class="text-indigo-600 dark:text-indigo-400 underline">Sign Up</a> in the top menu<br>
• <strong>Login:</strong> Click <a href="/login" class="text-indigo-600 dark:text-indigo-400 underline">Login</a> and enter your email & password<br>
• <strong>Google Sign-in:</strong> Use the Google button for one-click access<br>
• <strong>Forgot password:</strong> Click "Forgot Password" on the login page<br><br>
Your account lets you track orders, manage wishlists, and chat with sellers!`,
        },
        {
            keys: ['wishlist','save','favorite','liked','bookmark','saved item','heart'],
            reply: `❤️ <strong>Wishlist</strong><br><br>
You can save any product by clicking the <strong>heart icon ❤️</strong> on the product card or detail page.<br><br>
To view your saved items:<br>
👉 Log in → go to <strong>My Wishlist</strong> from your profile menu.<br><br>
<em>Note: you must be logged in to save items.</em>`,
        },
        {
            keys: ['category','categories','type of product','what do you sell','product type'],
            reply: `📂 <strong>Product Categories</strong><br><br>
We carry a wide range of products! Browse all our categories:<br><br>
👉 <a href="/categories" class="text-indigo-600 dark:text-indigo-400 underline font-medium">View All Categories</a><br><br>
Use the search bar or filters to quickly find exactly what you're looking for.`,
        },
        {
            keys: ['contact','support','help','email us','phone','reach you','talk to human','live agent','customer service'],
            reply: `📞 <strong>Contact & Support</strong><br><br>
We're here to help!<br><br>
📧 <a href="/contact" class="text-indigo-600 dark:text-indigo-400 underline">Send us a message</a><br>
❓ <a href="/faq" class="text-indigo-600 dark:text-indigo-400 underline">Browse our FAQ</a><br>
💬 <a href="/help" class="text-indigo-600 dark:text-indigo-400 underline">Help Center</a><br><br>
Support hours: <strong>Mon–Fri, 9AM–6PM</strong><br>
We usually reply within <strong>24 hours</strong>. 😊`,
        },
        {
            keys: ['about','who are you','what is shopexpress','company','about us','mission'],
            reply: `ℹ️ <strong>About ShopExpress</strong><br><br>
ShopExpress is a <strong>multi-vendor marketplace</strong> where verified sellers offer quality products — all in one place.<br><br>
✅ Verified & trusted sellers<br>
✅ Secure payment processing<br>
✅ Easy 30-day returns<br>
✅ Fast nationwide delivery<br><br>
Happy shopping! 🛍️`,
        },
    ];

    // ── Quick reply definitions ─────────────────────────────────────────────
    const QUICK_REPLIES = [
        { label: '🔥 Top Products',    trigger: 'top products'    },
        { label: '🛒 How to Order',    trigger: 'how to order'    },
        { label: '🏪 Become a Seller', trigger: 'become a seller' },
        { label: '🚚 Shipping',        trigger: 'shipping'        },
        { label: '💳 Payment',         trigger: 'payment methods' },
        { label: '📞 Contact',         trigger: 'contact support' },
    ];

    // ── DOM helpers ────────────────────────────────────────────────────────
    function $(id) { return document.getElementById(id); }

    function isDark() {
        return document.documentElement.classList.contains('dark');
    }

    function timeStr() {
        return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function appendMessage(html, type) {
        const container = $('chatbot-messages');
        const wrap = document.createElement('div');
        wrap.className = 'flex ' + (type === 'user' ? 'justify-end' : 'justify-start') + ' items-end gap-2';

        if (type === 'bot') {
            wrap.innerHTML = `
                <div class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-sm flex-shrink-0">🤖</div>
                <div class="max-w-[85%]">
                    <div class="text-xs rounded-2xl rounded-bl-sm px-3.5 py-2.5 shadow-sm
                                bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                                border border-gray-200 dark:border-gray-600 leading-relaxed">
                        ${html}
                    </div>
                    <p class="text-gray-400 text-[10px] mt-0.5 ml-1">${timeStr()}</p>
                </div>`;
        } else {
            wrap.innerHTML = `
                <div class="max-w-[85%] flex flex-col items-end">
                    <div class="text-xs rounded-2xl rounded-br-sm px-3.5 py-2.5 shadow-sm
                                bg-indigo-600 text-white leading-relaxed">
                        ${html}
                    </div>
                    <p class="text-gray-400 text-[10px] mt-0.5 mr-1">${timeStr()}</p>
                </div>`;
        }

        container.appendChild(wrap);
        container.scrollTop = container.scrollHeight;
    }

    function showTyping() {
        const container = $('chatbot-messages');
        const el = document.createElement('div');
        el.id = 'chatbot-typing';
        el.className = 'flex justify-start items-end gap-2';
        el.innerHTML = `
            <div class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-sm">🤖</div>
            <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600
                        rounded-2xl rounded-bl-sm px-4 py-3 shadow-sm flex items-center gap-1">
                <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
            </div>`;
        container.appendChild(el);
        container.scrollTop = container.scrollHeight;
    }

    function hideTyping() {
        const el = $('chatbot-typing');
        if (el) el.remove();
    }

    function renderQuickReplies() {
        const box = $('chatbot-quick-replies');
        box.innerHTML = '';
        QUICK_REPLIES.forEach(qr => {
            const btn = document.createElement('button');
            btn.className = `text-xs px-2.5 py-1 rounded-full border border-indigo-300 dark:border-indigo-600
                             text-indigo-700 dark:text-indigo-300 bg-white dark:bg-gray-800
                             hover:bg-indigo-50 dark:hover:bg-indigo-900 transition-colors whitespace-nowrap`;
            btn.textContent = qr.label;
            btn.onclick = () => processInput(qr.trigger);
            box.appendChild(btn);
        });
    }

    // ── Response engine ────────────────────────────────────────────────────
    function findReply(text) {
        const lower = text.toLowerCase().trim();
        for (const entry of KB) {
            if (entry.keys.some(k => lower.includes(k))) {
                return entry.reply;
            }
        }
        return `🤔 I'm not sure about that, but I'd love to help!<br><br>
Try asking about:<br>
• <strong>Top products</strong><br>
• <strong>How to order</strong><br>
• <strong>Become a seller</strong><br>
• <strong>Shipping / returns</strong><br><br>
Or <a href="/contact" class="text-indigo-600 dark:text-indigo-400 underline">contact our support team</a> for personalised help. 😊`;
    }

    function processInput(text) {
        if (!text.trim()) return;
        const input = $('chatbot-input');
        if (input) input.value = '';

        appendMessage(text.replace(/</g,'&lt;').replace(/>/g,'&gt;'), 'user');
        showTyping();

        setTimeout(() => {
            hideTyping();
            appendMessage(findReply(text), 'bot');
        }, 900 + Math.random() * 600);
    }

    // ── Public API ─────────────────────────────────────────────────────────
    return {
        toggle() {
            const win  = $('chatbot-window');
            const icoO = $('chatbot-icon-open');
            const icoC = $('chatbot-icon-close');
            const badge = $('chatbot-badge');

            isOpen = !isOpen;
            if (isOpen) {
                win.classList.remove('scale-0','opacity-0','pointer-events-none');
                win.classList.add('scale-100','opacity-100');
                icoO.classList.add('hidden');
                icoC.classList.remove('hidden');
                if (badge) badge.classList.add('hidden');
                badgeShown = false;
                setTimeout(() => $('chatbot-input')?.focus(), 300);
            } else {
                win.classList.add('scale-0','opacity-0','pointer-events-none');
                win.classList.remove('scale-100','opacity-100');
                icoO.classList.remove('hidden');
                icoC.classList.add('hidden');
            }
        },

        send() {
            const input = $('chatbot-input');
            if (input && input.value.trim()) processInput(input.value.trim());
        },

        init() {
            renderQuickReplies();
            // Welcome message after short delay
            setTimeout(() => {
                appendMessage(`👋 <strong>Hi there!</strong> I'm the ShopExpress Assistant.<br>How can I help you today?`, 'bot');
            }, 400);
            // Show badge after 3 seconds to draw attention
            setTimeout(() => {
                if (!isOpen && badgeShown) {
                    const badge = $('chatbot-badge');
                    if (badge) badge.classList.remove('hidden');
                }
            }, 3000);
        }
    };
})();

document.addEventListener('DOMContentLoaded', () => window.chatbot.init());
</script>
