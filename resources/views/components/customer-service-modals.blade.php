<div x-data="{ open: '', content: '' }" class="text-left">

    <h3 class="font-bold text-lg text-white mb-2">Customer Service</h3>
    <ul class="space-y-1">
        <li>
            <a href="#" @click.prevent="open = 'return'; content = 'Our return policy: You can return items within 30 days of purchase. Contact support for details.'"
               class="text-gray-200 hover:text-white transition-colors duration-150 block">
                Return Policy
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="open = 'privacy'; content = 'Our privacy policy: We value your privacy and never share your data without consent.'"
               class="text-gray-200 hover:text-white transition-colors duration-150 block">
                Privacy Policy
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="open = 'terms'; content = 'Terms of Service: Use this website with respect and follow all laws. See full terms on our website.'"
               class="text-gray-200 hover:text-white transition-colors duration-150 block">
                Terms of Service
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="open = 'support'; content = 'Support: If you need help, please email support@shop.com or use our contact form.'"
               class="text-gray-200 hover:text-white transition-colors duration-150 block">
                Support
            </a>
        </li>
    </ul>

    <!-- Modal -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 relative"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
        >
            <button @click="open = ''"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            <h4 class="text-lg font-bold mb-3 text-gray-800" x-text="open.charAt(0).toUpperCase() + open.slice(1).replace('_', ' ')"></h4>
            <div class="text-gray-700" x-text="content"></div>
        </div>
    </div>
</div>
