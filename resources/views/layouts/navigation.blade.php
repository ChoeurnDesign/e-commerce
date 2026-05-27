<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50" 
     x-data="{ mobileMenuOpen: false, openSearch: false }">
    <div class="w-full">
        @include('layouts.partials.desktop-nav')
    </div>
    @include('layouts.partials.mobile-nav')
</nav>