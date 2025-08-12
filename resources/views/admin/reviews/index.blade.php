@extends('layouts.admin')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="reviews" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Reviews</h1>
    </div>
    <div class="bg-white dark:bg-[#23263a] rounded-xl shadow overflow-hidden border border-gray-200 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-300 dark:bg-[#232c47]">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Product</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Reviewer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Rating</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr class="hover:bg-indigo-50 dark:hover:bg-[#2a3350] transition">
                            <td class="px-6 py-4 border-b border-gray-100 dark:border-[#23263a] text-center text-gray-900 dark:text-gray-100 ">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-100 dark:border-[#23263a]">
                                <span class=" text-indigo-700 dark:text-indigo-300">
                                    {{ $review->product->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-100 dark:border-[#23263a] text-gray-700 dark:text-gray-200">
                                {{ $review->user->name ?? 'Guest' }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-100 dark:border-[#23263a]">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118l-3.385-2.46c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.967z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118l-3.385-2.46c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.967z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-gray-800 dark:text-gray-200 font-medium">{{ $review->rating }} / 5</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-100 dark:border-[#23263a] text-gray-800 dark:text-gray-100">
                                <span class="whitespace-pre-line">{{ $review->comment }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-8">
                                No reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
