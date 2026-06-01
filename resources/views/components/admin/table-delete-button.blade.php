@props(['action', 'method' => 'DELETE', 'confirm' => 'This item will be permanently deleted.', 'title' => 'Delete'])

<form action="{{ $action }}" method="POST" class="inline">
    @csrf
    @method($method)

    <button type="button"
            onclick="confirmDelete(event, this)"
            data-confirm="{{ $confirm }}"
            class="inline-flex items-center text-red-600 hover:text-red-900 hover:bg-red-50#23263a] px-2 py-1 rounded transition-colors duration-200"
            title="{{ $title }}">
        <x-icon-dashboard name="delete" />
        <span>{{ $title }}</span>
    </button>
</form>