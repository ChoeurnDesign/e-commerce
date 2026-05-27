<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-8">
    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Overview Metrics</h2>
    
    <form method="GET" action="{{ url()->current() }}" id="dashboardRangeForm" class="relative inline-block text-left" x-data="{ open: false }">
        @foreach(request()->except('range') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div>
            <button @click="open = !open" @click.away="open = false" type="button" class="inline-flex w-full justify-between items-center gap-x-1.5 rounded-md bg-white dark:bg-[#23263a] px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-[#2c3049] transition-colors" id="menu-button" aria-expanded="true" aria-haspopup="true">
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>
                        @switch(request('range', '1_week'))
                            @case('1_week') Last 1 Week @break
                            @case('1_month') Last 1 Month @break
                            @case('3_months') Last 3 Months @break
                            @case('6_months') Last 6 Months @break
                            @case('1_year') Last 1 Year @break
                            @default Last 1 Week
                        @endswitch
                    </span>
                </span>
                <svg class="-mr-1 h-5 w-5 text-gray-400 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-100" 
             x-transition:enter-start="transform opacity-0 scale-95" 
             x-transition:enter-end="transform opacity-100 scale-100" 
             x-transition:leave="transition ease-in duration-75" 
             x-transition:leave-start="transform opacity-100 scale-100" 
             x-transition:leave-end="transform opacity-0 scale-95" 
             class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-[#23263a] shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-gray-700 focus:outline-none" style="display: none;" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="py-1" role="none">
                <button type="submit" name="range" value="1_week" 
                    class="w-full text-left block px-4 py-2 text-sm transition-colors duration-150 
                    {{ request('range', '1_week') === '1_week' 
                        ? 'bg-indigo-50 text-indigo-600 dark:bg-[#1a1c2b] dark:text-indigo-400 font-semibold' 
                        : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-[#2c3049] hover:text-gray-900 dark:hover:text-white' 
                    }}" role="menuitem">
                    Last 1 Week
                </button>
                
                <button type="submit" name="range" value="1_month" 
                    class="w-full text-left block px-4 py-2 text-sm transition-colors duration-150 
                    {{ request('range') === '1_month' 
                        ? 'bg-indigo-50 text-indigo-600 dark:bg-[#1a1c2b] dark:text-indigo-400 font-semibold' 
                        : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-[#2c3049] hover:text-gray-900 dark:hover:text-white' 
                    }}" role="menuitem">
                    Last 1 Month
                </button>
                
                <button type="submit" name="range" value="3_months" 
                    class="w-full text-left block px-4 py-2 text-sm transition-colors duration-150 
                    {{ request('range') === '3_months' 
                        ? 'bg-indigo-50 text-indigo-600 dark:bg-[#1a1c2b] dark:text-indigo-400 font-semibold' 
                        : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-[#2c3049] hover:text-gray-900 dark:hover:text-white' 
                    }}" role="menuitem">
                    Last 3 Months
                </button>
                
                <button type="submit" name="range" value="6_months" 
                    class="w-full text-left block px-4 py-2 text-sm transition-colors duration-150 
                    {{ request('range') === '6_months' 
                        ? 'bg-indigo-50 text-indigo-600 dark:bg-[#1a1c2b] dark:text-indigo-400 font-semibold' 
                        : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-[#2c3049] hover:text-gray-900 dark:hover:text-white' 
                    }}" role="menuitem">
                    Last 6 Months
                </button>
                
                <button type="submit" name="range" value="1_year" 
                    class="w-full text-left block px-4 py-2 text-sm transition-colors duration-150 
                    {{ request('range') === '1_year' 
                        ? 'bg-indigo-50 text-indigo-600 dark:bg-[#1a1c2b] dark:text-indigo-400 font-semibold' 
                        : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-[#2c3049] hover:text-gray-900 dark:hover:text-white' 
                    }}" role="menuitem">
                    Last 1 Year
                </button>
            </div>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-200 dark:bg-green-900 text-green-600 dark:text-green-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Total Sales
                    <span class="text-xs text-gray-400 block">
                        (@switch(request('range', '1_week'))
                            @case('1_week') Last 7 days @break
                            @case('1_month') Last 30 days @break
                            @case('3_months') Last 3 months @break
                            @case('6_months') Last 6 months @break
                            @case('1_year') Last 1 year @break
                        @endswitch)
                    </span>
                </div>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    ${{ number_format($stats['total_sales'], 2) }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-200 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Total Orders
                    <span class="text-xs text-gray-400 block">
                        (@switch(request('range', '1_week'))
                            @case('1_week') Last 7 days @break
                            @case('1_month') Last 30 days @break
                            @case('3_months') Last 3 months @break
                            @case('6_months') Last 6 months @break
                            @case('1_year') Last 1 year @break
                        @endswitch)
                    </span>
                </div>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_orders']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-200 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Total Users
                    <span class="text-xs text-gray-400 block">
                        (@switch(request('range', '1_week'))
                            @case('1_week') Last 7 days @break
                            @case('1_month') Last 30 days @break
                            @case('3_months') Last 3 months @break
                            @case('6_months') Last 6 months @break
                            @case('1_year') Last 1 year @break
                        @endswitch)
                    </span>
                </div>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_users']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-200 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Products
                    <span class="text-xs text-gray-400 block">
                        (@switch(request('range', '1_week'))
                            @case('1_week') Last 7 days @break
                            @case('1_month') Last 30 days @break
                            @case('3_months') Last 3 months @break
                            @case('6_months') Last 6 months @break
                            @case('1_year') Last 1 year @break
                        @endswitch)
                    </span>
                </div>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_products']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-200 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Categories
                    <span class="text-xs text-gray-400 block">
                        (@switch(request('range', '1_week'))
                            @case('1_week') Last 7 days @break
                            @case('1_month') Last 30 days @break
                            @case('3_months') Last 3 months @break
                            @case('6_months') Last 6 months @break
                            @case('1_year') Last 1 year @break
                        @endswitch)
                    </span>
                </div>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_categories']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-200 dark:bg-red-900 text-red-600 dark:text-red-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Pending Orders
                    <span class="text-xs text-gray-400 block">All Time</span>
                </div>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['pending_orders']) }}</p>
            </div>
        </div>
    </div>
</div>