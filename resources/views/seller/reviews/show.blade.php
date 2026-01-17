@extends('layouts.seller')

@section('title', 'View Review')

@section('content')
<div class="container mx-auto">
    <a href="{{ route('seller.reviews.index') }}" class="text-sm text-gray-600 hover:underline mb-4 inline-block">← Back to reviews</a>

    <div class="bg-white dark:bg-gray-800 rounded p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold">{{ $review->user->name ?? 'Anonymous' }}</h2>
                <div class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</div>
            </div>
            <div class="text-lg font-bold text-yellow-500">{{ number_format($review->rating, 1) }}</div>
        </div>

        <div class="mt-4 text-gray-800 dark:text-gray-200">
            {{ $review->comment }}
        </div>

        <div class="mt-4">
            <a href="{{ route('seller.reviews.edit', $review) }}" class="inline-block bg-blue-600 text-white px-3 py-2 rounded">Edit</a>
        </div>
    </div>
</div>
@endsection