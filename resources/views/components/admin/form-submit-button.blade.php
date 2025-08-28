<form action="{{ $action }}" method="POST" class="inline-block">
    @csrf
    @method('PATCH')
    <button type="submit"
        class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white border border-gray-400 shadow-md hover:shadow-lg px-3 py-1.5 rounded-full transition-all duration-200"
        title="{{ $title ?? 'Update' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
        </svg>
        <span>Update</span>
    </button>
</form>
