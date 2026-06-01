@extends('layouts.seller')

@section('title', 'Reviews')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
            <x-icon-nav name="reviews" class="w-5 h-5 text-pink-600"/>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">My Reviews</h1>
            <p class="text-xs text-gray-500">Customer reviews of your products</p>
        </div>
    </div>

    {{-- Simple Search --}}
    <x-admin.simple-search
        :action="route('seller.reviews.index')"
        name="q"
        placeholder="Search my reviews by id / reviewer / rating / comment"
        hint="Search by id, reviewer, rating, comment"
        width="w-96"
        :autofocus="true"
    />

    <div class="bg-white shadow-sm overflow-hidden border border-pink-100 rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-100">
                <thead>
                    <tr class="bg-pink-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reviewer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-pink-100">
                    @forelse ($reviews as $review)
                        <tr class="hover:bg-pink-50 transition">
                            <td class="px-6 py-4 text-center text-gray-900">
                                {{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $review->user->name ?? 'Guest' }}
                                @if($review->user && $review->user->email)
                                    <div class="text-xs text-gray-500">{{ $review->user->email }}</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <x-icon-nav name="star-empty" class="w-4 h-4 inline-block text-yellow-400" />
                                        @else
                                            <x-icon-nav name="star-filled" class="w-4 h-4 inline-block text-gray-300" />
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-gray-800 font-medium">
                                        {{ $review->rating }} / 5
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-800">
                                <div class="whitespace-pre-line">{{ $review->comment }}</div>

                                {{-- created_at timestamp below the comment --}}
                                <div class="text-xs text-gray-500 mt-2">
                                    @if($review->created_at)
                                        {{ $review->created_at->format('Y-m-d H:i:s') }}
                                        <span class="mx-1">•</span>
                                        <span class="italic">({{ $review->created_at->diffForHumans() }})</span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('seller.reviews.show', $review) }}" class="text-blue-600 flex hover:underline text-sm">
                                        <x-icon-nav name="view" />
                                        View
                                    </a>
                                    <a href="{{ route('seller.reviews.edit', $review) }}" class="text-pink-600 flex hover:underline text-sm">
                                        <x-icon-nav name="edit" />
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 text-lg">
                                No reviews yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-pink-100 bg-white">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection