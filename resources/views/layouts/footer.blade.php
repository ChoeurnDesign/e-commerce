{{-- resources/views/layouts/footer.blade.php --}}

<footer class="bg-slate-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Column 1 & 2: Store Info --}}
            <div class="col-span-1 sm:col-span-2">
                <h3 class="text-xl sm:text-2xl mb-3 font-bold text-gray-900 dark:text-white">{{ setting('store_name') }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-5 text-sm leading-relaxed max-w-sm">Your premier destination for quality products and exceptional service. Shop with confidence and convenience.</p>

                <div class="flex items-center gap-3 mb-6">
                    <a href="https://github.com/choeurndesign" target="_blank" rel="noopener"
                       class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white transition-all duration-200"
                       aria-label="GitHub">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.799 8.205 11.385.6.111.82-.261.82-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.085 1.84 1.24 1.84 1.24 1.07 1.836 2.809 1.306 3.495.998.108-.775.418-1.306.76-1.606-2.665-.304-5.466-1.332-5.466-5.93 0-1.31.469-2.381 1.236-3.222-.123-.304-.535-1.527.117-3.183 0 0 1.008-.323 3.301 1.23.96-.267 1.989-.4 3.012-.405 1.023.005 2.052.138 3.013.405 2.291-1.553 3.297-1.23 3.297-1.23.653 1.656.241 2.879.118 3.183.77.841 1.235 1.912 1.235 3.222 0 4.609-2.804 5.624-5.475 5.921.43.371.814 1.102.814 2.222v3.293c0 .319.218.694.825.576C20.565 21.796 24 17.297 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/in/chun-choeurn-b19b1730a/" target="_blank" rel="noopener"
                       class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white transition-all duration-200"
                       aria-label="LinkedIn">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.268c-.966 0-1.75-.789-1.75-1.757 0-.967.784-1.755 1.75-1.755s1.75.788 1.75 1.755c0 .968-.784 1.757-1.75 1.757zm13.5 10.268h-3v-4.604c0-1.096-.021-2.507-1.528-2.507-1.528 0-1.763 1.194-1.763 2.426v4.685h-3v-9h2.881v1.229h.041c.401-.761 1.38-1.563 2.841-1.563 3.041 0 3.602 2.004 3.602 4.612v4.722z"/></svg>
                    </a>
                    <a href="https://t.me/chunchoeurn" target="_blank" rel="noopener"
                       class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white transition-all duration-200"
                       aria-label="Telegram">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9.97 15.73l-.39 3.81c.56 0 .81-.24 1.1-.53l2.64-2.53 5.48 4.01c1.01.56 1.72.27 1.97-.93l3.57-16.65c.32-1.45-.52-2.02-1.47-1.65L1.67 9.57c-1.41.54-1.39 1.3-.24 1.64l4.26 1.33 9.88-6.23c.46-.29.88-.13.54.18"/></svg>
                    </a>
                </div>

                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    @if(setting('store_phone'))
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:{{ setting('store_phone') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ setting('store_phone') }}</a>
                    </li>
                    @endif
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ setting('store_email', 'support@shopexpress.com') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ setting('store_email', 'support@shopexpress.com') }}</a>
                    </li>
                    @if(setting('store_address'))
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-indigo-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ setting('store_address') }}</span>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Column 3: Quick Links --}}
            <div>
                <h4 class="text-sm font-semibold mb-4 text-gray-900 dark:text-white uppercase tracking-wider">Quick Links</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('home') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Products</a></li>
                    <li><a href="{{ route('categories.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Categories</a></li>
                    <li><a href="{{ route('stores.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Stores</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Shopping Cart</a></li>
                    @auth
                        <li><a href="{{ route('orders.history') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">My Orders</a></li>
                    @endauth
                    <li><a href="{{ route('about') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Contact</a></li>
                    <li>
                        <a href="{{ route('seller.landing') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Sell on {{ setting('store_name', 'ShopExpress') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Column 4: Customer Service & Modal --}}
            <div x-data="{ open: '', content: '' }">
                <h4 class="text-sm font-semibold mb-4 text-gray-900 dark:text-white uppercase tracking-wider">Customer Service</h4>
                <ul class="space-y-2.5">
                    <li><a href="#" @click.prevent="open = 'Return Policy'; content = `{!! addslashes(nl2br(e(setting('return_policy', '...')))) !!}`;" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Return Policy</a></li>
                    <li><a href="#" @click.prevent="open = 'Privacy Policy'; content = `{!! addslashes(nl2br(e(setting('privacy_policy', '...')))) !!}`;" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Privacy Policy</a></li>
                    <li><a href="#" @click.prevent="open = 'Terms of Service'; content = `{!! addslashes(nl2br(e(setting('terms_of_service', '...')))) !!}`;" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Terms of Service</a></li>
                    <li><a href="#" @click.prevent="open = 'Shipping Policy'; content = `{!! addslashes(nl2br(e(setting('shipping_policy', '...')))) !!}`;" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Shipping Policy</a></li>
                    <li><a href="#" @click.prevent="open = 'Support'; content = `{!! addslashes(nl2br(e($settings['support_info'] ?? '...')))}}`;" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Support</a></li>
                </ul>

                <div x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 relative" x-transition>
                        <button @click="open = ''" class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition text-xl leading-none">&times;</button>
                        <h4 class="text-lg font-bold mb-3 text-gray-900 dark:text-white pr-8" x-text="open"></h4>
                        <div class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed" x-html="content"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            @include('layouts.user-report')
        </div>

        <div class="border-t border-gray-200 dark:border-gray-800 mt-6 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-gray-400 text-xs sm:text-sm">&copy; {{ date('Y') }} <span class="text-gray-600 dark:text-gray-300 font-medium">{{ setting('store_name', 'ShopExpress') }}</span>. All rights reserved.</p>
            <span class="text-gray-400 text-xs sm:text-sm">Developed by <strong class="text-indigo-600 dark:text-indigo-400">Choeurn & Chung</strong></span>
        </div>
    </div>
</footer>
