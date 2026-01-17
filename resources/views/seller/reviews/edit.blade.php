@extends('layouts.seller')

@section('title', 'Edit Review')

@section('content')
<div class="container mx-auto">
    <a href="{{ route('seller.reviews.index') }}" class="text-sm text-gray-600 hover:underline mb-4 inline-block">← Back to reviews</a>

    <div class="bg-white dark:bg-gray-800 rounded p-6">
        <form action="{{ route('seller.reviews.update', $review) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                <select name="rating" class="mt-1 w-28 border rounded px-2 py-1">
                    @for($i=1;$i<=5;$i++)
                        <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('rating') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comment</label>
                <textarea name="comment" rows="5" class="w-full border rounded px-3 py-2">{{ old('comment', $review->comment) }}</textarea>
                @error('comment') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('seller.reviews.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection