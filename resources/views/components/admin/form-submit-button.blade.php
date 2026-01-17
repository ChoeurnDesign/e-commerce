<form action="{{ $action }}" method="POST" class="inline-block">
    @csrf
    <input type="hidden" name="_method" value="PUT"> <!-- Set to PUT -->
    <button type="submit"
        class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white border border-gray-400 shadow-md hover:shadow-lg px-3 py-1.5 rounded-full transition-all duration-200"
        title="{{ $title ?? 'Update' }}">
        <x-heroicon-o-check class="h-5 w-5 mr-1" />
        <span>Update</span>
    </button>
</form>