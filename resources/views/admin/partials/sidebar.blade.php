<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
     class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-[#181f31] text-gray-900 dark:text-white p-4 flex flex-col h-screen border-r border-gray-200 dark:border-gray-800 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:sticky lg:top-0 lg:z-30 flex-shrink-0"
     @click.away="if (window.innerWidth < 1024) sidebarOpen = false">
     
    <div class="flex items-center justify-between mb-8 flex-shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-gray-300 transition duration-150 ease-in-out">
            Admin Panel
        </a>
        
        <button @click="sidebarOpen = false" 
                class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white focus:outline-none lg:hidden p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    @include('admin.partials.sidebar-nav')
</div>