<form action="{{ $action }}" method="POST" class="inline" onsubmit="return confirm('{{ $confirm ?? 'Are you sure?' }}');">
    @csrf
    <input type="hidden" name="_method" value="">
    <button type="submit"
            class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-[#23263a] px-2 py-1 rounded transition-colors duration-200"
            title="{{ $title ?? 'Delete' }}">
        <x-icon-nav name="delete" />
        
        <span>Delete</span>
    </button>
</form>

