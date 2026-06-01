{{-- Quick actions --}}
<div class="mt-6">
    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Quick Actions</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach([
            ['route' => 'admin.categories.create',  'label' => 'Add Category',    'icon' => 'M12 4v16m8-8H4',           'color' => 'blue'],
            ['route' => 'admin.orders.index',        'label' => 'Manage Orders',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'purple'],
            ['route' => 'admin.sellers.index',       'label' => 'View Sellers',    'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => 'green'],
            ['route' => 'admin.settings.index',      'label' => 'Settings',        'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'gray'],
        ] as $action)
        <a href="{{ route($action['route']) }}"
           class="flex items-center gap-3 px-4 py-3.5 bg-white rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition-all group">
            <div class="w-9 h-9 rounded-xl bg-{{ $action['color'] }}-100 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-{{ $action['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $action['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>
