<x-app-layout>
    <div class="min-h-screen w-full bg-gray-300 dark:bg-gray-900 flex flex-col items-center py-12 transition-colors">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10 border border-gray-200 dark:border-gray-700 transition-colors">
            <div class="flex items-center mb-8">
                <svg class="inline w-10 h-10 mr-2 text-blue-300 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke="currentColor"/>
                    <path d="M12 7v5l3 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h1 class="text-2xl sm:text-3xl font-bold text-blue-500 dark:text-blue-300">Help Center</h1>
            </div>
            <div class="flex flex-col gap-8">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">Contact Support</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">For any issues, please contact our global support team:</p>
                    <ul class="list-disc ml-6 text-gray-700 dark:text-gray-300">
                        <li>Email: <a href="mailto:support@shopexpress.com" class="text-blue-400 dark:text-blue-300 underline break-words">support@shopexpress.com</a></li>
                        <li>Live Chat: Available 24/7 in the bottom right corner</li>
                        <li>Phone: +855 70 229 710</li>
                    </ul>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">Order & Shipping Help</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">Track orders, change shipping addresses, and view estimated delivery times in your <b>Account &gt; Orders</b> section.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">Returns & Refunds</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">Start a return, check return status, and learn about our refund policy. Most items can be returned within 30 days of delivery.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-100 dark:border-gray-700 p-5 transition-colors">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100">Account Security</h2>
                    <p class="text-base break-words text-gray-700 dark:text-gray-300">Learn how to keep your account secure: use strong passwords, enable 2-step verification, and beware of phishing emails.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
