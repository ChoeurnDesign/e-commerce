<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    @method('PATCH')
    <button type="submit"
        class="inline-flex items-center text-red-600 dark:text-red-300 hover:text-red-900 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 px-2 py-1 rounded transition-colors duration-200"
        title="{{ $title ?? 'Reject' }}">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span>Reject</span>
    </button>
</form>
