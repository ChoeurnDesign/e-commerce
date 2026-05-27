<button aria-haspopup="true" aria-expanded="false" aria-label="View latest reports"
    class="relative p-1 text-gray-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-100 hover:text-gray-700 dark:hover:text-white rounded-full transition-colors"
    @click="notifOpen = !notifOpen" x-data="{ notifOpen: false }" :aria-expanded="notifOpen.toString()">

    <x-icon-dashboard name="notification" class="w-6 h-6 text-gray-900 dark:text-gray-400  transition focus:outline-none" />

    @if(isset($unreadCount) && $unreadCount > 0)
    <span class="absolute top-0 right-0 translate-x-1/3 -translate-y-1/3
             bg-red-500 dark:bg-red-600 text-white text-[10px] font-bold rounded-full
             h-5 w-5 flex items-center justify-center shadow">
        {{ $unreadCount }}
    </span>
    @endif

    <div x-show="notifOpen" @click.away="notifOpen = false" x-transition
        class="absolute right-0 mt-2 w-72 bg-white dark:bg-[#23263a] rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 transition-colors"
        style="display: none;">
        <div class="py-2 px-4 border-b border-gray-100 dark:border-gray-700 font-semibold text-gray-900 dark:text-gray-100">
            Latest Reports
        </div>
        <div class="max-h-60 overflow-y-auto">
            @forelse($reports as $report)
            <a href="{{ route('admin.reports.show', $report->id) }}"
                class="block px-4 py-2 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#262c47] transition-colors">
                <div class="flex items-center">
                    <span class="font-medium truncate">{{ $report->title }}</span>
                    @if(!$report->is_read)
                    <span class="ml-2 h-2 w-2 rounded-full bg-red-500 dark:bg-red-600 inline-block"></span>
                    @endif
                    <span class="ml-auto text-xs text-gray-400 dark:text-gray-500">{{ $report->created_at->diffForHumans() }}</span>
                </div>
            </a>
            @empty
            <div class="px-4 py-2 text-gray-400 dark:text-gray-500">No reports found.</div>
            @endforelse
        </div>
    </div>
</button>