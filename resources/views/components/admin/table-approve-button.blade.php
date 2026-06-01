<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    <input type="hidden" name="_method" value="">
    <button type="submit"
        class="inline-flex items-center text-green-600 hover:text-green-900 hover:bg-green-50 px-2 py-1 rounded transition-colors duration-200"
        title="{{ $title ?? 'Approve' }}">
        <x-icon-dashboard name="approve" />

        <span>Approve</span>
    </button>
</form>

