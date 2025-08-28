<!-- Modal: Approve or Reject Seller -->
<div x-data="{ open: false }" x-cloak>
    <button
        @click="open = true"
        class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs transition"
        type="button"
    >
        Approve/Reject Seller
    </button>
    <div
        x-show="open"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black/40"
        x-transition
    >
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Change Seller Status</h2>
            <form method="POST" action="{{ route('admin.sellers.updateStatus', [$seller->id, 'status']) }}">
                @csrf
                @method('PATCH')
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Add a comment (optional):
                    <textarea name="admin_comment" rows="2" class="mt-1 block w-full rounded border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200"></textarea>
                </label>
                <div class="flex justify-end gap-2 mt-4">
                    <button @click="open = false" type="button" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded hover:bg-gray-400 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button name="action" value="approved" type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Approve</button>
                    <button name="action" value="rejected" type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Requires Alpine.js for x-data/x-show transitions -->
