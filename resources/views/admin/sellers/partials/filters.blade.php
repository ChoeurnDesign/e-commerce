<form method="GET" action="{{ route('admin.sellers.index') }}" class="flex flex-wrap items-center gap-3 mb-6">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search seller, email, or store…"
        class="px-4 py-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#23263a] text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400"
    />

    <select
        name="status"
        class="px-8 py-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#23263a] text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400"
    >
        <option value="">All Statuses</option>
        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
        <option value="approved" @selected(request('status') === 'approved')>Approved</option>
        <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
    </select>

    <button
        type="submit"
        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 rounded text-white font-semibold transition"
    >
        Filter
    </button>

    @if(request('search') || request('status'))
        <a href="{{ route('admin.sellers.index') }}"
           class="px-5 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-200 font-semibold transition">
            Reset
        </a>
    @endif
</form>
