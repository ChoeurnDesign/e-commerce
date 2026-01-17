<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    <input type="hidden" name="_method" value="">
    <button type="submit"
        class="inline-flex items-center text-red-600 dark:text-red-300 hover:text-red-900 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900 px-2 py-1 rounded transition-colors duration-200"
        title="{{ $title ?? 'Reject' }}">
        <x-icon-nav name="reject" />
        
        <span>Reject</span>
    </button>
</form>

