<x-app-layout>

    {{-- HERO --}}
    <div class="relative bg-gradient-to-br from-indigo-700 via-indigo-600 to-purple-700 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-20 -left-20 w-96 h-96 bg-white rounded-full"></div>
            <div class="absolute -bottom-20 -right-20 w-[500px] h-[500px] bg-white rounded-full"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white rounded-full"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="inline-block bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-5 uppercase tracking-wider">
                        Seller Program
                    </span>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white leading-tight mb-5">
                        Start Selling on<br>
                        <span class="text-yellow-300">{{ setting('store_name', 'ShopExpress') }}</span> Today
                    </h1>
                    <p class="text-indigo-100 text-base sm:text-lg leading-relaxed mb-8 max-w-lg">
                        Join our growing marketplace. Reach thousands of customers, manage your store easily, and grow your business — all in one place.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        @auth
                            @if(auth()->user()->role === 'seller')
                                <a href="{{ route('seller.dashboard') }}"
                                   class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Go to My Dashboard
                                </a>
                            @else
                                <a href="{{ route('seller.register.form') }}"
                                   class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Apply to Sell Now
                                </a>
                            @endif
                        @else
                            <a href="{{ route('seller.register.form') }}"
                               class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Start Selling Today
                            </a>
                            <a href="#how-it-works"
                               class="inline-flex items-center justify-center gap-2 border border-white/50 text-white hover:bg-white/10 font-semibold py-3 px-8 rounded-full text-sm sm:text-base transition-colors">
                                Learn More
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1">500+</div>
                        <div class="text-indigo-100 text-sm font-medium">Active Sellers</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1">10K+</div>
                        <div class="text-indigo-100 text-sm font-medium">Products Listed</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1">50K+</div>
                        <div class="text-indigo-100 text-sm font-medium">Happy Customers</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-yellow-300 mb-1">0%</div>
                        <div class="text-indigo-100 text-sm font-medium">Listing Fee</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-950">

        {{-- BENEFITS --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3">Why Sell With Us?</h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto text-sm sm:text-base">Everything you need to run a successful online store — built in.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm group hover:border-indigo-200 dark:hover:border-indigo-700 transition-colors">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 transition-colors duration-300">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Zero Listing Fee</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">List unlimited products for free. We only earn when you earn — small commission per sale.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm group hover:border-indigo-200 dark:hover:border-indigo-700 transition-colors">
                    <div class="w-12 h-12 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-600 transition-colors duration-300">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Huge Customer Base</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Instantly reach thousands of active shoppers browsing our marketplace every day.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm group hover:border-indigo-200 dark:hover:border-indigo-700 transition-colors">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors duration-300">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Powerful Dashboard</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Track sales, manage orders, view earnings, and chat with customers — all from one place.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm group hover:border-indigo-200 dark:hover:border-indigo-700 transition-colors">
                    <div class="w-12 h-12 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:bg-yellow-500 transition-colors duration-300">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Secure & Trusted</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Secure payments, buyer protection, and a trusted brand that customers already love.</p>
                </div>
            </div>
        </div>

        {{-- HOW IT WORKS --}}
        <div id="how-it-works" class="border-t border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3">How It Works</h2>
                    <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto text-sm sm:text-base">Get your store up and running in 3 simple steps.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 relative">
                    {{-- Connector line (desktop only) --}}
                    <div class="hidden sm:block absolute top-8 left-1/3 right-1/3 h-0.5 bg-indigo-100 dark:bg-indigo-900/40 z-0"></div>

                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-indigo-200 dark:shadow-indigo-900">
                            <span class="text-white text-xl font-extrabold">1</span>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Create Your Account</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed max-w-xs mx-auto">Sign up for free and fill in your basic store information — takes less than 2 minutes.</p>
                    </div>
                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-indigo-200 dark:shadow-indigo-900">
                            <span class="text-white text-xl font-extrabold">2</span>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Submit Application</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed max-w-xs mx-auto">Tell us about your store. Our team will review and approve your application quickly.</p>
                    </div>
                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-indigo-200 dark:shadow-indigo-900">
                            <span class="text-white text-xl font-extrabold">3</span>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Start Earning</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed max-w-xs mx-auto">List your products, receive orders, and track your earnings — all from your dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SELLER TOOLS --}}
        <div class="border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <span class="inline-block bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">Seller Tools</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-5">Everything You Need to Succeed</h2>
                        <div class="space-y-4">
                            @foreach([
                                ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'Sales Analytics', 'desc' => 'Track your revenue, top products, and order trends in real-time.'],
                                ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8.25-9 8.25a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8.25 9-8.25s9 3.582 9 8.25z', 'title' => 'Live Customer Chat', 'desc' => 'Chat directly with buyers to answer questions and close more sales.'],
                                ['icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12', 'title' => 'Bulk Product Import', 'desc' => 'Upload hundreds of products at once with our CSV import tool.'],
                                ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'title' => 'Wallet & Earnings', 'desc' => 'All your earnings in one wallet. Clear breakdown of commissions and payouts.'],
                            ] as $tool)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tool['icon'] }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-0.5">{{ $tool['title'] }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $tool['desc'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Mini dashboard mockup --}}
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-5">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Seller Dashboard</span>
                            <span class="text-xs text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2 py-0.5 rounded-full font-medium">● Live</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-100 dark:border-gray-600">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Sales</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">$2,840</p>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1">↑ 12% this month</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-100 dark:border-gray-600">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Orders</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">48</p>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1">5 pending</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-100 dark:border-gray-600">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Products</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">24</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">All active</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-100 dark:border-gray-600">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Rating</p>
                                <p class="text-xl font-bold text-yellow-500">4.8 ★</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">32 reviews</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            @foreach(['New order #1042 received', 'Product "Blue Shirt" low stock', 'Customer message received'] as $notif)
                            <div class="flex items-center gap-3 bg-white dark:bg-gray-700 rounded-xl px-4 py-2.5 border border-gray-100 dark:border-gray-600">
                                <div class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-300">{{ $notif }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ --}}
        <div class="border-t border-gray-100 dark:border-gray-800">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
                <div class="text-center mb-10">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3">Frequently Asked Questions</h2>
                </div>
                <div class="space-y-3" x-data="{ open: null }">
                    @foreach([
                        ['q' => 'How much does it cost to start selling?', 'a' => 'It is completely free to create an account and list products. We only charge a small commission when you make a sale — no upfront fees.'],
                        ['q' => 'How long does the approval process take?', 'a' => 'Our team reviews applications within 1–3 business days. You will be notified by email once your application is approved or if we need more information.'],
                        ['q' => 'How do I receive my earnings?', 'a' => 'Your earnings are credited to your seller wallet after each completed order. You can request a payout from your dashboard at any time.'],
                        ['q' => 'Can I sell in multiple categories?', 'a' => 'Yes! Once approved, you can list products across any category. There are no restrictions on how many categories you can sell in.'],
                        ['q' => 'What happens if a buyer wants a refund?', 'a' => 'We have a clear return policy. Disputes are handled through our support team. We work fairly with both buyers and sellers to resolve any issues.'],
                    ] as $i => $faq)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <button
                            @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="w-full flex items-center justify-between px-6 py-4 text-left"
                        >
                            <span class="font-semibold text-sm sm:text-base text-gray-900 dark:text-white pr-4">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-200"
                                 :class="open === {{ $i }} ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open === {{ $i }}" x-cloak x-transition class="px-6 pb-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16 text-center">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">Ready to Start Your Store?</h2>
                <p class="text-indigo-100 text-sm sm:text-base mb-8 max-w-xl mx-auto">Join hundreds of sellers already growing their business on {{ setting('store_name', 'ShopExpress') }}. It's free to get started.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @auth
                        @if(auth()->user()->role === 'seller')
                            <a href="{{ route('seller.dashboard') }}"
                               class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full text-sm transition-colors shadow-lg">
                                Go to My Dashboard
                            </a>
                        @else
                            <a href="{{ route('seller.register.form') }}"
                               class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full text-sm transition-colors shadow-lg">
                                Apply to Sell Now — It's Free
                            </a>
                        @endif
                    @else
                        <a href="{{ route('seller.register.form') }}"
                           class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-bold py-3 px-8 rounded-full text-sm transition-colors shadow-lg">
                            Start Selling Today — It's Free
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center gap-2 border border-white/50 text-white hover:bg-white/10 font-semibold py-3 px-8 rounded-full text-sm transition-colors">
                            Already have an account? Sign in
                        </a>
                    @endauth
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
