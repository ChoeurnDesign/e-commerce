<div class="bg-gray-800 dark:bg-[#181f31] text-white w-64 min-h-screen p-4 transition-colors">
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white hover:text-gray-300 transition duration-150 ease-in-out">
            Admin Panel
        </a>
    </div>
    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="dashboard" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="{{ request()->routeIs('admin.products.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="products" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Products
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="{{ request()->routeIs('admin.categories.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="categories" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Categories
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="{{ request()->routeIs('admin.orders.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="orders" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Orders
        </a>
        <a href="{{ route('admin.customers.index') }}"
           class="{{ request()->routeIs('admin.customers.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="customers" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Customers
        </a>
        <a href="{{ route('admin.sellers.index') }}"
           class="{{ request()->routeIs('admin.sellers.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="sellers" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Sellers
        </a>
        <a href="{{ route('admin.reports-dash.index') }}"
           class="{{ request()->routeIs('admin.reports-dash.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="reports" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Reports
        </a>
        <a href="{{ route('admin.reviews.index') }}"
           class="{{ request()->routeIs('admin.reviews.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="reviews" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Reviews
        </a>
        <a href="{{ route('admin.onsale.index') }}"
           class="{{ request()->routeIs('admin.onsale.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="onsale" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            On Sale
        </a>
        <a href="{{ route('admin.settings.index') }}"
           class="{{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 dark:bg-[#23263a] text-white' : 'text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors">
            <x-icon-dashboard name="settings" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Settings
        </a>
        <a href="{{ route('home') }}"
           class="text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white flex items-center px-4 py-2 text-sm font-medium rounded-md mt-8 transition-colors">
            <x-icon-dashboard name="back" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Back to Store
        </a>
    </nav>
</div>
