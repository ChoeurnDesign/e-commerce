@extends('layouts.admin')

@section('title', 'Reviews Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="reviews" class="w-7 h-7 text-indigo-600"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900">Reviews</h1>
    </div>

    {{-- Simple Search --}}
    <x-admin.simple-search
        placeholder="ID / Product / User / Rating / Comment"
        hint="Search by id, product, user, rating, text"
        width="w-96"
        :autofocus="true"
    />

    <div class="bg-white shadow-sm overflow-hidden border border-gray-100 rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reviewer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($reviews as $review)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center text-gray-900">
                                {{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-indigo-700">
                                    {{ $review->product->name ?? '-' }}
                                </span>
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
                                            <x-icon-nav name="star-filled" class="w-4 h-4 inline-block text-yellow-400" />
                                        @else
                                            <x-icon-nav name="star-empty" class="w-4 h-4 inline-block text-gray-300" />
                                        @endif
                                    @endfor
                                    <span class="ml-2 text-gray-800 font-medium">
                                        {{ $review->rating }} / 5
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-800">
                                <span class="whitespace-pre-line">{{ $review->comment }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <x-admin.table-edit-button :href="route('admin.reviews.edit', $review)" />
                                    <x-admin.table-delete-button :action="route('admin.reviews.destroy', $review)" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 text-lg">
                                No reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
