<x-app-layout>
    <div class="min-h-screen w-full bg-gray-300 dark:bg-gray-900 flex flex-col items-center py-12 transition-colors">
        <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10 border border-gray-200 dark:border-gray-700 transition-colors">
            <div class="flex items-center mb-8">
                <svg class="inline w-10 h-10 mr-2 text-green-400" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                    <path d="M12 18a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5zm0-11c2.2 0 4 1.79 4 4 0 1.53-1.03 2.43-2.01 3.24-.86.68-1.49 1.18-1.49 2.01h-2c0-1.79 1.17-2.68 2.17-3.48.69-.55 1.33-1.08 1.33-1.77 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4z" fill="currentColor"/>
                </svg>
                <h1 class="text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-400">FAQ</h1>
            </div>
            <div class="flex flex-col gap-6">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">What countries do you ship to?</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">We ship worldwide! Our E-Commerce store delivers to over 180 countries. Shipping costs and times may vary depending on your location.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">How can I track my order?</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">Once your order is shipped, you will receive an email with a tracking number. You can also track your orders under <b>My Account &gt; Orders</b>.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">What payment methods do you accept?</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">We accept all major credit cards, PayPal, Apple Pay, Google Pay, and local payment options in select countries.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">How do I return an item?</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">Returns are easy! Visit our <a href="{{ route('help') }}" class="text-blue-400 underline dark:text-blue-300">Help Center</a> for step-by-step instructions or start a return from your account dashboard.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">Is my data secure?</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">Yes, we use industry-standard SSL encryption and comply with GDPR and other global privacy regulations.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">How do I contact customer support?</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">You can reach us 24/7 via live chat, email, or by submitting a request in our <a href="{{ route('help') }}" class="text-blue-400 underline dark:text-blue-300">Help Center</a>.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
