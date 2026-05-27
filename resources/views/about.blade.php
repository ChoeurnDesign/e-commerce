<x-app-layout>

    {{-- Hero --}}
    <div class="relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-10 -left-10 w-72 h-72 bg-white rounded-full"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 text-center">
            <span class="inline-block bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase tracking-wider">Our Story</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                About {{ setting('store_name', 'ShopExpress') }}
            </h1>
            <p class="text-indigo-100 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Your trusted destination for seamless online shopping, quality products, and exceptional service.
            </p>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-950">

        {{-- Mission Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Who We Are
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                        {{ setting('store_name', 'ShopExpress') }} was created to make shopping enjoyable, accessible, and reliable for everyone. We carefully select our products for quality, value, and style — so you always find something you love.
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                        Our catalog covers fashion, electronics, home essentials, beauty, and more. We regularly update with new arrivals and exclusive deals, always focused on great customer care.
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                        At {{ setting('store_name', 'ShopExpress') }}, customers come first. We offer fast shipping, secure payments, responsive support, and easy returns — giving you a shopping experience you can truly trust.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center shadow-sm">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">1000+</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Products</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center shadow-sm">
                        <div class="w-12 h-12 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">500+</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Happy Customers</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center shadow-sm">
                        <div class="w-12 h-12 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">4.8★</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Avg. Rating</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center shadow-sm">
                        <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">50+</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Sellers</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Values Section --}}
        <div class="border-t border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <div class="text-center mb-10">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3">Why Shop With Us</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto text-sm sm:text-base">We're committed to making every purchase a great experience.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm group hover:border-indigo-200 dark:hover:border-indigo-700 transition-colors">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Fast Shipping</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Quick delivery straight to your door with real-time tracking on every order.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm group hover:border-indigo-200 dark:hover:border-indigo-700 transition-colors">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Secure Payments</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Your payment information is always protected with industry-standard encryption.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm group hover:border-indigo-200 dark:hover:border-indigo-700 transition-colors">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">24/7 Support</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Our dedicated support team is always here to help whenever you need us.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12 text-center">
                <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">Ready to start shopping?</h2>
                <p class="text-indigo-100 text-sm mb-6">Discover thousands of products from trusted sellers.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('products.index') }}"
                       class="inline-block bg-white text-indigo-600 hover:bg-indigo-50 font-semibold py-2.5 px-7 rounded-full text-sm transition-colors shadow-md">
                        Shop Now
                    </a>
                    <a href="{{ route('contact') }}"
                       class="inline-block border border-white/50 text-white hover:bg-white/10 font-semibold py-2.5 px-7 rounded-full text-sm transition-colors">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
