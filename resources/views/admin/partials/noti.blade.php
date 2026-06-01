<div x-data="{ notifOpen: false }" class="relative">
    <button @click="notifOpen = !notifOpen"
            class="relative p-2 rounded-xl hover:bg-gray-100 transition-colors focus:outline-none"
            aria-label="View reports">
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if(isset($unreadCount) && $unreadCount > 0)
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        @endif
    </button>

    <div x-show="notifOpen" @click.away="notifOpen = false"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
         x-cloak>

        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900">Latest Reports</h3>
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="text-[10px] font-bold bg-red-100 text-red-600 px-2 py-0.5 rounded-full">{{ $unreadCount }} new</span>
            @endif
        </div>

        <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
            @forelse($reports as $report)
            <a href="{{ route('admin.reports.show', $report->id) }}"
               class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                @if(!$report->is_read)
                    <span class="w-2 h-2 rounded-full bg-indigo-500 mt-2 shrink-0"></span>
                @else
                    <span class="w-2 h-2 rounded-full bg-transparent mt-2 shrink-0"></span>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate {{ !$report->is_read ? 'font-semibold' : '' }}">{{ $report->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $report->created_at->diffForHumans() }}</p>
                </div>
            </a>
            @empty
            <div class="px-4 py-8 text-center text-gray-400">
                <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm">No reports yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
