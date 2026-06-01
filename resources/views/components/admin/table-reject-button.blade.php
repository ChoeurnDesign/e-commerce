<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    <input type="hidden" name="_method" value="">
    <button type="submit"
        class="inline-flex items-center text-red-600 hover:text-red-900 hover:bg-red-50 px-2 py-1 rounded transition-colors duration-200"
        title="{{ $title ?? 'Reject' }}">
        <x-icon-dashboard name="reject" />
        
        <span>Reject</span>
    </button>
</form>

