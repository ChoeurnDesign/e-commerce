<x-app-layout>
    <div class="min-h-screen w-full bg-gray-50 dark:bg-gray-950 py-12 px-4 transition-colors">
        <div class="max-w-3xl mx-auto" x-data="{ activeQuestion: null }">
            
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Frequently Asked Questions
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Find quick answers to common questions about our services.
                </p>
            </div>

            <div class="space-y-4">
                
                {{-- FAQ Item 1 --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="activeQuestion === 1 ? activeQuestion = null : activeQuestion = 1" 
                            class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">What countries do you ship to?</span>
                        <svg class="w-6 h-6 text-gray-400 transition-transform duration-300" :class="activeQuestion === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeQuestion === 1" x-cloak class="px-6 pb-6 text-gray-600 dark:text-gray-400">
                        We ship worldwide! Our E-Commerce store delivers to over 180 countries. Shipping costs and times may vary depending on your location.
                    </div>
                </div>

                {{-- FAQ Item 2 --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="activeQuestion === 2 ? activeQuestion = null : activeQuestion = 2" 
                            class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">How can I track my order?</span>
                        <svg class="w-6 h-6 text-gray-400 transition-transform duration-300" :class="activeQuestion === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeQuestion === 2" x-cloak class="px-6 pb-6 text-gray-600 dark:text-gray-400">
                        Once your order is shipped, you will receive an email with a tracking number. You can also track your orders under <b>My Account > Orders</b>.
                    </div>
                </div>

                {{-- FAQ Item 3 --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="activeQuestion === 3 ? activeQuestion = null : activeQuestion = 3" 
                            class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">What payment methods do you accept?</span>
                        <svg class="w-6 h-6 text-gray-400 transition-transform duration-300" :class="activeQuestion === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeQuestion === 3" x-cloak class="px-6 pb-6 text-gray-600 dark:text-gray-400">
                        We accept all major credit cards, PayPal, Apple Pay, Google Pay, and local payment options in select countries.
                    </div>
                </div>

                {{-- FAQ Item 4 --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="activeQuestion === 4 ? activeQuestion = null : activeQuestion = 4" 
                            class="w-full text-left p-6 flex justify-between items-center focus:outline-none">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">How do I return an item?</span>
                        <svg class="w-6 h-6 text-gray-400 transition-transform duration-300" :class="activeQuestion === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeQuestion === 4" x-cloak class="px-6 pb-6 text-gray-600 dark:text-gray-400">
                        Returns are easy! Visit our <a href="{{ route('help') }}" class="text-indigo-500 hover:underline font-medium">Help Center</a> for step-by-step instructions.
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>