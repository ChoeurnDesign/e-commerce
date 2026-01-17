@extends('layouts.admin')

@section('content')
<div class="max-w-full mx-auto bg-white dark:bg-[#23263a] rounded-xl shadow p-8 mt-4 border border-gray-200 dark:border-[#23263a]">
    <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Review</h2>
    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="">

        <div class="mb-4">
            <x-input-label value="Product" />
            <x-text-input
                type="text"
                :value="$review->product->name ?? '-'"
                class="w-full border border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-[#23263a] text-gray-900 dark:text-gray-200"
                disabled
            />
        </div>
        <div class="mb-4">
            <x-input-label value="Reviewer" />
            <x-text-input
                type="text"
                :value="$review->user->name ?? 'Guest'"
                class="w-full border border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-[#23263a] text-gray-900 dark:text-gray-200"
                disabled
            />
        </div>
        <div class="mb-4">
            <x-input-label for="rating" value="Rating" />
            <select name="rating" id="rating"
                class="w-full border border-gray-400 dark:border-gray-500 text-gray-900 dark:text-gray-200 bg-white dark:bg-[#23263a]">
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" @if(old('rating', $review->rating) == $i) selected @endif>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="mb-4">
            <x-input-label for="comment" value="Comment" />
            <textarea name="comment" id="comment" rows="4"
                class="w-full border border-gray-400 dark:border-gray-500 text-gray-900 dark:text-gray-200 bg-white dark:bg-[#23263a]">{{ old('comment', $review->comment) }}</textarea>
        </div>
        <div class="flex justify-end space-x-2">
            <x-admin.form-submit-button :action="route('admin.reviews.update', $review->id)">Update Review</x-admin.form-submit-button>
            <x-admin.form-cancel-button :href="route('admin.reviews.index')">Cancel</x-admin.form-cancel-button>
        </div>
    </form>
</div>
@endsection

