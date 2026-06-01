@php
    $rangeLabel = match(request('range', '1_week')) {
        '1_week'   => 'Last 7 days',
        '1_month'  => 'Last 30 days',
        '3_months' => 'Last 3 months',
        '6_months' => 'Last 6 months',
        '1_year'   => 'Last 1 year',
        default    => 'Last 7 days',
    };
@endphp

{{-- Time range selector --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-6">
    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Overview Metrics</h2>

    <form method="GET" action="{{ url()->current() }}" x-data="{ open: false }" class="relative">
        @foreach(request()->except('range') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <button @click="open = !open" @click.away="open = false" type="button"
                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-sm font-medium text-gray-700 hover:border-indigo-300 transition-all shadow-sm">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $rangeLabel }}
            <svg class="w-3.5 h-3.5 text-gray-400" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open" x-transition x-cloak
             class="absolute right-0 z-50 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 overflow-hidden">
            @foreach([
                '1_week'   => 'Last 1 Week',
                '1_month'  => 'Last 1 Month',
                '3_months' => 'Last 3 Months',
                '6_months' => 'Last 6 Months',
                '1_year'   => 'Last 1 Year',
            ] as $val => $label)
                <button type="submit" name="range" value="{{ $val }}"
                        class="w-full text-left px-4 py-2.5 text-sm transition-colors
                        {{ request('range', '1_week') === $val
                            ? 'bg-indigo-50 text-indigo-600 font-semibold'
                            : 'text-gray-700 hover:bg-gray-50' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </form>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
    @php
        $cards = [
            ['label' => 'Total Sales',     'value' => '$' . number_format($stats['total_sales'], 2), 'sub' => $rangeLabel, 'iconBg' => 'bg-green-100',  'iconColor' => 'text-green-600', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1'],
            ['label' => 'Total Orders',    'value' => number_format($stats['total_orders']),         'sub' => $rangeLabel, 'iconBg' => 'bg-blue-100',   'iconColor' => 'text-blue-600',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['label' => 'Total Users',     'value' => number_format($stats['total_users']),          'sub' => $rangeLabel, 'iconBg' => 'bg-purple-100', 'iconColor' => 'text-purple-600', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ['label' => 'Products',        'value' => number_format($stats['total_products']),       'sub' => $rangeLabel, 'iconBg' => 'bg-amber-100',  'iconColor' => 'text-amber-600',  'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'Categories',      'value' => number_format($stats['total_categories']),     'sub' => 'All time',  'iconBg' => 'bg-indigo-100', 'iconColor' => 'text-indigo-600', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            ['label' => 'Pending Orders',  'value' => number_format($stats['pending_orders']),       'sub' => 'All time',  'iconBg' => 'bg-red-100',    'iconColor' => 'text-red-600',    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    @endphp

    @foreach($cards as $card)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-indigo-100 transition-all">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl {{ $card['iconBg'] }} flex items-center justify-center">
                <svg class="w-5 h-5 {{ $card['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
            <span class="text-[10px] text-gray-400 font-medium">{{ $card['sub'] }}</span>
        </div>
        <p class="text-2xl font-extrabold text-gray-900">{{ $card['value'] }}</p>
        <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>
