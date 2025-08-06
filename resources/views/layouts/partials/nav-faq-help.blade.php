<x-nav-link :href="route('faq')" :active="request()->routeIs('faq')" class="text-green-400 font-medium flex items-center">
        <svg class="inline w-5 h-5 mr-2 text-green-400" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
            <path d="M12 18a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5zm0-11c2.2 0 4 1.79 4 4 0 1.53-1.03 2.43-2.01 3.24-.86.68-1.49 1.18-1.49 2.01h-2c0-1.79 1.17-2.68 2.17-3.48.69-.55 1.33-1.08 1.33-1.77 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4z" fill="currentColor"/>
        </svg>
        FAQ
    </x-nav-link>
    <x-nav-link :href="route('help')" :active="request()->routeIs('help')" class="text-blue-500 font-medium flex items-center">
        <svg class="inline w-5 h-5 mr-1 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" stroke="currentColor"/>
            <path d="M12 7v5l3 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Help
</x-nav-link>
