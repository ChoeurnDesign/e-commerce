<footer class="bg-gray-800 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-2xl mb-4">{{ setting('store_name') }}</h3>
                <p class="text-gray-300 mb-4">Your premier destination for quality products and exceptional service. Shop with confidence and convenience.</p>
                <div class="flex space-x-4">
                    <!-- GitHub -->
                    <a href="https://github.com/choeurndesign" target="_blank" rel="noopener" class="text-gray-300 hover:text-white transition duration-150 ease-in-out" aria-label="GitHub">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.799 8.205 11.385.6.111.82-.261.82-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.085 1.84 1.24 1.84 1.24 1.07 1.836 2.809 1.306 3.495.998.108-.775.418-1.306.76-1.606-2.665-.304-5.466-1.332-5.466-5.93 0-1.31.469-2.381 1.236-3.222-.123-.304-.535-1.527.117-3.183 0 0 1.008-.323 3.301 1.23.96-.267 1.989-.4 3.012-.405 1.023.005 2.052.138 3.013.405 2.291-1.553 3.297-1.23 3.297-1.23.653 1.656.241 2.879.118 3.183.77.841 1.235 1.912 1.235 3.222 0 4.609-2.804 5.624-5.475 5.921.43.371.814 1.102.814 2.222v3.293c0 .319.218.694.825.576C20.565 21.796 24 17.297 24 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                    </a>
                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/in/chun-choeurn-b19b1730a/" target="_blank" rel="noopener" class="text-gray-300 hover:text-white transition duration-150 ease-in-out" aria-label="LinkedIn">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.268c-.966 0-1.75-.789-1.75-1.757 0-.967.784-1.755 1.75-1.755s1.75.788 1.75 1.755c0 .968-.784 1.757-1.75 1.757zm13.5 10.268h-3v-4.604c0-1.096-.021-2.507-1.528-2.507-1.528 0-1.763 1.194-1.763 2.426v4.685h-3v-9h2.881v1.229h.041c.401-.761 1.38-1.563 2.841-1.563 3.041 0 3.602 2.004 3.602 4.612v4.722z"/>
                        </svg>
                    </a>
                    <!-- Telegram -->
                    <a href="https://t.me/chunchoeurn" target="_blank" rel="noopener" class="text-gray-300 hover:text-white transition duration-150 ease-in-out" aria-label="Telegram">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.97 15.73l-.39 3.81c.56 0 .81-.24 1.1-.53l2.64-2.53 5.48 4.01c1.01.56 1.72.27 1.97-.93l3.57-16.65c.32-1.45-.52-2.02-1.47-1.65L1.67 9.57c-1.41.54-1.39 1.3-.24 1.64l4.26 1.33 9.88-6.23c.46-.29.88-.13.54.18"/>
                        </svg>
                    </a>
                </div>
                <div class="mt-6 text-gray-300">
                    <ul class="space-y-2">
                        @if(setting('store_phone'))
                        <li>
                            <a href="tel:{{ setting('store_phone') }}" class="underline text-white hover:text-indigo-300">
                                {{ setting('store_phone') }}
                            </a>
                            <span class="mx-2">|</span>
                            <span class="text-gray-100 font-medium">
                                {{ setting('store_address', '123 Main Street, City, Country') }}
                            </span>
                        </li>
                        @else
                        <li>
                            <span class="text-gray-100 font-medium">
                                {{ setting('store_address', '123 Main Street, City, Country') }}
                            </span>
                        </li>
                        @endif
                        <li class="mt-2">
                            Contact our store directly by
                            <a href="mailto:{{ setting('store_email', 'support@shopexpress.com') }}"
                            class="underline text-indigo-300 hover:text-indigo-400 font-medium">
                                {{ setting('store_email', 'support@shopexpress.com') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div>
                <h4 class="text-lg  mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">Products</a></li>
                    <li><a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">Categories</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">Shopping Cart</a></li>
                    @auth
                        <li><a href="{{ route('orders.history') }}" class="text-gray-300 hover:text-white transition duration-150 ease-in-out">My Orders</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Customer Service Section with Modals --}}
            <div x-data="{ open: '', content: '' }">
                <h4 class="text-lg  mb-4 text-gray-900 dark:text-gray-100">Customer Service</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="#"
                        @click.prevent="open = 'Return Policy'; content = `{!! addslashes(nl2br(e(setting('return_policy', 'You can return items within 30 days of purchase. Please contact support for instructions.'))) ) !!}`;"
                        class="text-gray-300 hover:text-white dark:text-gray-400 dark:hover:text-white transition duration-150 ease-in-out">
                            Return Policy
                        </a>
                    </li>
                    <li>
                        <a href="#"
                        @click.prevent="open = 'Privacy Policy'; content = `{!! addslashes(nl2br(e(setting('privacy_policy', 'We respect your privacy and protect your personal data. Read our full policy for more info.'))) ) !!}`;"
                        class="text-gray-300 hover:text-white dark:text-gray-400 dark:hover:text-white transition duration-150 ease-in-out">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#"
                        @click.prevent="open = 'Terms of Service'; content = `{!! addslashes(nl2br(e(setting('terms_of_service', 'By using our site, you agree to our terms of service. Please review all terms before making a purchase.'))) ) !!}`;"
                        class="text-gray-300 hover:text-white dark:text-gray-400 dark:hover:text-white transition duration-150 ease-in-out">
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="#"
                        @click.prevent="open = 'Shipping Policy'; content = `{!! addslashes(nl2br(e(setting('shipping_policy', 'No shipping policy set.'))) ) !!}`;"
                        class="text-gray-300 hover:text-white dark:text-gray-400 dark:hover:text-white transition duration-150 ease-in-out">
                            Shipping Policy
                        </a>
                    </li>
                    <li>
                        <a href="#"
                        @click.prevent="open = 'Support'; content = `{!! addslashes(nl2br(e($settings['support_info'] ?? 'Contact us for support.'))) !!}`;"
                        class="text-gray-300 hover:text-white dark:text-gray-400 dark:hover:text-white transition duration-150 ease-in-out">
                            Support
                        </a>
                    </li>
                </ul>
                <!-- Modal -->
                <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 dark:bg-opacity-70">
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl max-w-md w-full p-6 relative"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                    >
                        <button @click="open = ''"
                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 text-2xl leading-none">&times;</button>
                        <h4 class="text-lg mb-3 text-gray-800 dark:text-gray-100" x-text="open"></h4>
                        <div class="text-gray-700 dark:text-gray-300" x-text="content"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            @include('layouts.user-report')
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
            <p class="text-gray-300">&copy; {{ date('Y') }} ShopExpress. All rights reserved.</p>
            <span>Developed by <strong>Choeurn</strong></span>
        </div>
    </div>
</footer>

<script src="//unpkg.com/alpinejs" defer></script>
