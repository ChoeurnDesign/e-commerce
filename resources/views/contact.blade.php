<x-app-layout>

    {{-- Hero --}}
    <div class="relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-white rounded-full"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 text-center">
            <span class="inline-block bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase tracking-wider">Get In Touch</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Contact Us</h1>
            <p class="text-indigo-100 text-sm sm:text-base max-w-xl mx-auto">
                We're here to help. Send us a message and we'll get back to you as soon as possible.
            </p>
        </div>
    </div>

    <div class="bg-gray-50 dark:bg-gray-950 py-10 sm:py-14">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- Left: Contact Info --}}
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Email</p>
                                <a href="mailto:{{ setting('support_email', 'support@shopexpress.com') }}"
                                   class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline break-all">
                                    {{ setting('support_email', 'support@shopexpress.com') }}
                                </a>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">We reply within 24 hours</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Phone</p>
                                <a href="tel:{{ setting('support_phone', '+85570229710') }}"
                                   class="text-sm font-medium text-green-600 dark:text-green-400 hover:underline">
                                    {{ setting('support_phone', '+855 70 229 710') }}
                                </a>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Mon – Fri, 8am – 6pm</p>
                            </div>
                        </div>
                    </div>

                    @if(setting('store_address'))
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Address</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ setting('store_address') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800/40 p-6">
                        <h3 class="text-sm font-semibold text-indigo-700 dark:text-indigo-300 mb-2">Need faster help?</h3>
                        <p class="text-xs text-indigo-600/80 dark:text-indigo-400/80 mb-3 leading-relaxed">
                            Chat directly with sellers or use our live support for immediate assistance.
                        </p>
                        @auth
                        <a href="{{ route('chat.index') }}"
                           class="inline-flex items-center gap-2 text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-full transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Open Chat
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-full transition-colors">
                            Sign in to Chat
                        </a>
                        @endauth
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 sm:p-8">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Send a Message</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Fill in the form below and we'll get back to you shortly.</p>

                        @if(session('success'))
                            <div class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 uppercase tracking-wide">
                                        Your Name
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           placeholder="John Doe"
                                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                           required>
                                    @error('name')
                                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 uppercase tracking-wide">
                                        Email Address
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           placeholder="you@example.com"
                                           class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                           required>
                                    @error('email')
                                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 uppercase tracking-wide">
                                    Subject
                                </label>
                                <input type="text" name="subject" value="{{ old('subject') }}"
                                       placeholder="How can we help you?"
                                       class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('subject')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5 uppercase tracking-wide">
                                    Message
                                </label>
                                <textarea name="message" rows="5"
                                          placeholder="Tell us what's on your mind..."
                                          class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl text-sm transition-colors shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
