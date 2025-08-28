<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    @method('PATCH')
    <button type="submit"
        class="inline-flex items-center text-green-600 dark:text-green-300 hover:text-green-900 dark:hover:text-green-400 hover:bg-green-50 dark:hover:bg-green-900 px-2 py-1 rounded transition-colors duration-200"
        title="{{ $title ?? 'Approve' }}">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        <span>Approve</span>
    </button>
</form>
