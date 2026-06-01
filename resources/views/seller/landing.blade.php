<x-app-layout>

    {{-- HERO --}}
    <div class="relative bg-gradient-to-br from-pink-700 via-pink-600 to-purple-700 overflow-hidden">
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
                    <p class="text-pink-100 text-base sm:text-lg leading-relaxed mb-8 max-w-lg">
                        Join our growing marketplace. Reach thousands of customers, manage your store easily, and grow your business — all in one place.
                    </p>
                    @auth
                    @php $userSeller = auth()->user()->seller; @endphp
                    @endauth
                    <div class="flex flex-col sm:flex-row gap-3">
                        @auth
                            @if($userSeller?->status === 'approved')
                                <a href="{{ route('seller.dashboard') }}"
                                   class="inline-flex items-center justify-center gap-2 bg-white text-pink-700 hover:bg-pink-50 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Go to My Dashboard
                                </a>
                            @elseif($userSeller?->status === 'pending')
                                <a href="{{ route('seller.register.form') }}"
                                   class="inline-flex items-center justify-center gap-2 bg-yellow-300 text-pink-900 hover:bg-yellow-200 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Application Under Review
                                </a>
                            @elseif($userSeller?->status === 'rejected')
                                <a href="{{ route('seller.register.form') }}"
                                   class="inline-flex items-center justify-center gap-2 bg-white text-red-600 hover:bg-red-50 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    View Application Status
                                </a>
                            @else
                                <a href="{{ route('seller.register.form') }}"
                                   class="inline-flex items-center justify-center gap-2 bg-white text-pink-700 hover:bg-pink-50 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Apply to Sell Now
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center gap-2 bg-white text-pink-700 hover:bg-pink-50 font-bold py-3 px-8 rounded-full text-sm sm:text-base transition-colors shadow-lg">
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

                {{-- Stats — real data from DB --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach($stats as $stat)
                    <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold {{ ($stat['highlight'] ?? false) ? 'text-yellow-300' : 'text-white' }} mb-1">
                            {{ $stat['value'] }}
                        </div>
                        <div class="text-pink-100 text-sm font-medium">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50">

        {{-- BENEFITS --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">Why Sell With Us?</h2>
                <p class="text-gray-500 max-w-xl mx-auto text-sm sm:text-base">Everything you need to run a successful online store — built in.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm group hover:border-pink-200 transition-colors">
                    <div class="w-12 h-12 bg-pink-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-pink-600 transition-colors duration-300">
                        <svg class="w-6 h-6 text-pink-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Zero Listing Fee</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">List unlimited products for free. We only earn when you earn — small commission per sale.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm group hover:border-pink-200 transition-colors">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-600 transition-colors duration-300">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Huge Customer Base</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Instantly reach thousands of active shoppers browsing our marketplace every day.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm group hover:border-pink-200 transition-colors">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors duration-300">
                        <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Powerful Dashboard</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Track sales, manage orders, view earnings, and chat with customers — all from one place.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm group hover:border-pink-200 transition-colors">
                    <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-yellow-500 transition-colors duration-300">
                        <svg class="w-6 h-6 text-yellow-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Secure & Trusted</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Secure payments, buyer protection, and a trusted brand that customers already love.</p>
                </div>
            </div>
        </div>

        {{-- HOW IT WORKS --}}
        <div id="how-it-works" class="border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">How It Works</h2>
                    <p class="text-gray-500 max-w-xl mx-auto text-sm sm:text-base">Get your store up and running in 3 simple steps.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 relative">
                    {{-- Connector line (desktop only) --}}
                    <div class="hidden sm:block absolute top-8 left-1/3 right-1/3 h-0.5 bg-pink-100 z-0"></div>

                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 bg-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-pink-200">
                            <span class="text-white text-xl font-extrabold">1</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Create Your Account</h3>
                        <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">Sign up for free and fill in your basic store information — takes less than 2 minutes.</p>
                    </div>
                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 bg-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-pink-200">
                            <span class="text-white text-xl font-extrabold">2</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Submit Application</h3>
                        <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">Tell us about your store. Our team will review and approve your application quickly.</p>
                    </div>
                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 bg-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-pink-200">
                            <span class="text-white text-xl font-extrabold">3</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Start Earning</h3>
                        <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">List your products, receive orders, and track your earnings — all from your dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SELLER TOOLS --}}
        <div class="border-t border-gray-100 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <span class="inline-block bg-pink-50 text-pink-600 text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">Seller Tools</span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-5">Everything You Need to Succeed</h2>
                        <div class="space-y-4">
                            @foreach([
                                ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'Sales Analytics', 'desc' => 'Track your revenue, top products, and order trends in real-time.'],
                                ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8.25-9 8.25a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8.25 9-8.25s9 3.582 9 8.25z', 'title' => 'Live Customer Chat', 'desc' => 'Chat directly with buyers to answer questions and close more sales.'],
                                ['icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12', 'title' => 'Bulk Product Import', 'desc' => 'Upload hundreds of products at once with our CSV import tool.'],
                                ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'title' => 'Wallet & Earnings', 'desc' => 'All your earnings in one wallet. Clear breakdown of commissions and payouts.'],
                            ] as $tool)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-pink-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tool['icon'] }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm mb-0.5">{{ $tool['title'] }}</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed">{{ $tool['desc'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Mini dashboard mockup --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-semibold text-gray-900">{{ __('Seller Dashboard') }}</span>
                            @if($dashboard['isLive'])
                                <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-medium">● {{ __('Live — Top Seller') }}</span>
                            @else
                                <span class="text-xs text-pink-600 bg-pink-50 px-2 py-0.5 rounded-full font-medium">{{ __('Preview') }}</span>
                            @endif
                        </div>
                        <p class="text-[11px] text-gray-400 mb-4">
                            {{ $dashboard['isLive']
                                ? __('Real numbers from one of our top performing sellers')
                                : __('What your dashboard could look like — start selling to make it yours') }}
                        </p>
                        <div class="grid grid-cols-2 gap-3 mb-5">
                        @if($dashboard['isLive'])
                            {{-- Real numbers from top-performing seller --}}
                            <div class="bg-white rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">{{ __('Total Sales') }}</p>
                                <p class="text-xl font-bold text-gray-900">{{ $dashboard['sales'] }}</p>
                                <p class="text-xs text-green-600 mt-1">↑ {{ __('All time') }}</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">{{ __('Orders') }}</p>
                                <p class="text-xl font-bold text-gray-900">{{ $dashboard['orders'] }}</p>
                                <p class="text-xs text-pink-600 mt-1">{{ $dashboard['pending'] }} {{ __('pending') }}</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">{{ __('Products') }}</p>
                                <p class="text-xl font-bold text-gray-900">{{ $dashboard['products'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ __('All active') }}</p>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">{{ __('Rating') }}</p>
                                <p class="text-xl font-bold text-yellow-500">{{ $dashboard['rating'] }} ★</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $dashboard['reviews'] }} {{ __('reviews') }}</p>
                            </div>
                        @else
                            {{-- Empty-state mockup — feature labels, NOT fake numbers --}}
                            @foreach([
                                ['title' => __('Track Revenue'),    'sub' => __('Real-time sales chart'),    'color' => 'pink',  'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
                                ['title' => __('Manage Orders'),    'sub' => __('One click to confirm'),     'color' => 'orange','icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['title' => __('Your Catalog'),     'sub' => __('Unlimited listings'),       'color' => 'violet','icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z'],
                                ['title' => __('Earn Reviews'),     'sub' => __('Build buyer trust'),        'color' => 'amber', 'icon' => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.32.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.32-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z'],
                            ] as $card)
                                <div class="bg-white rounded-xl p-4 border border-gray-100 flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-{{ $card['color'] }}-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ $card['title'] }}</p>
                                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">{{ $card['sub'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                        {{-- Notification types preview — illustrative, no real customer data --}}
                        <div class="space-y-2">
                            @foreach([
                                ['color' => 'bg-pink-500',    'icon' => '🛒', 'text' => __('New order notification')],
                                ['color' => 'bg-amber-500',   'icon' => '⚠',  'text' => __('Low stock alert')],
                                ['color' => 'bg-emerald-500', 'icon' => '💬', 'text' => __('New customer message')],
                            ] as $notif)
                            <div class="flex items-center gap-3 bg-white rounded-xl px-4 py-2.5 border border-gray-100">
                                <div class="w-2 h-2 rounded-full {{ $notif['color'] }} flex-shrink-0"></div>
                                <span class="text-xs text-gray-600">{{ $notif['text'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ --}}
        <div class="border-t border-gray-100">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
                <div class="text-center mb-10">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">Frequently Asked Questions</h2>
                </div>
                <div class="space-y-3" x-data="{ open: null }">
                    @foreach([
                        ['q' => 'How much does it cost to start selling?', 'a' => 'It is completely free to create an account and list products. We only charge a small commission when you make a sale — no upfront fees.'],
                        ['q' => 'How long does the approval process take?', 'a' => 'Our team reviews applications within 1–3 business days. You will be notified by email once your application is approved or if we need more information.'],
                        ['q' => 'How do I receive my earnings?', 'a' => 'Your earnings are credited to your seller wallet after each completed order. You can request a payout from your dashboard at any time.'],
                        ['q' => 'Can I sell in multiple categories?', 'a' => 'Yes! Once approved, you can list products across any category. There are no restrictions on how many categories you can sell in.'],
                        ['q' => 'What happens if a buyer wants a refund?', 'a' => 'We have a clear return policy. Disputes are handled through our support team. We work fairly with both buyers and sellers to resolve any issues.'],
                    ] as $i => $faq)
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                        <button
                            @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="w-full flex items-center justify-between px-6 py-4 text-left"
                        >
                            <span class="font-semibold text-sm sm:text-base text-gray-900 pr-4">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-200"
                                 :class="open === {{ $i }} ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open === {{ $i }}" x-cloak x-transition class="px-6 pb-4">
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-gradient-to-r from-pink-600 to-rose-500">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16 text-center">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">Ready to Start Your Store?</h2>
                <p class="text-pink-100 text-sm sm:text-base mb-8 max-w-xl mx-auto">Join hundreds of sellers already growing their business on {{ setting('store_name', 'ShopExpress') }}. It's free to get started.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @auth
                        @if(auth()->user()->role === 'seller')
                            <a href="{{ route('seller.dashboard') }}"
                               class="inline-flex items-center justify-center gap-2 bg-white text-pink-700 hover:bg-pink-50 font-bold py-3 px-8 rounded-full text-sm transition-colors shadow-lg">
                                Go to My Dashboard
                            </a>
                        @else
                            <a href="{{ route('seller.register.form') }}"
                               class="inline-flex items-center justify-center gap-2 bg-white text-pink-700 hover:bg-pink-50 font-bold py-3 px-8 rounded-full text-sm transition-colors shadow-lg">
                                Apply to Sell Now — It's Free
                            </a>
                        @endif
                    @else
                        <a href="{{ route('seller.register.form') }}"
                           class="inline-flex items-center justify-center gap-2 bg-white text-pink-700 hover:bg-pink-50 font-bold py-3 px-8 rounded-full text-sm transition-colors shadow-lg">
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
