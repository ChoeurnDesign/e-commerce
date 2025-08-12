@extends('layouts.admin')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="w-full max-w-full rounded-xl shadow-lg bg-white dark:bg-[#23263a] border border-gray-200 dark:border-[#23263a] px-8 py-10">
        <div class="mb-6 flex items-center">
            <h1 class="text-2xl text-gray-900 dark:text-gray-100">Report #{{ $report->id }}</h1>
        </div>
        <div class="space-y-4">
            <!-- Title -->
            <div class="mt-2">
                <span class="text-sm text-gray-400 uppercase">Title:</span>
                <span class="ml-2 text-md text-indigo-400">{{ $report->title }}</span>
            </div>
            <!-- Description -->
            <div class="mt-4">
                <span class="text-sm text-gray-400 uppercase">Description:</span>
                <span class="ml-2 text-md text-gray-200">{{ $report->description }}</span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-base text-gray-500 dark:text-gray-400">Status:</span>
                    <span class="ml-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs uppercase tracking-wide">
                        {{ $report->status }}
                    </span>
                </div>
                <div>
                    <span class="text-base text-gray-500 dark:text-gray-400">Is Read:</span>
                    <span class="ml-2 px-3 py-1 rounded-full {{ $report->is_read ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300' }} text-xs">
                        {{ $report->is_read ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-base text-gray-500 dark:text-gray-400">Created at:</span>
                    <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $report->created_at }}</span>
                </div>
                <div>
                    <span class="text-base text-gray-500 dark:text-gray-400">Updated at:</span>
                    <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $report->updated_at }}</span>
                </div>
            </div>
            <div>
                <span class="text-base text-gray-500 dark:text-gray-400">Images:</span>
                @php
                    $images = is_array($report->images) ? $report->images : json_decode($report->images, true);
                @endphp
                @if(!empty($images) && count($images))
                    <div class="flex flex-wrap gap-4 mt-3">
                        @foreach ($images as $image)
                            <div class="rounded-lg overflow-hidden border-2 border-gray-200 dark:border-[#34385c] bg-gray-200 dark:bg-[#1f2236] shadow">
                                <img src="{{ asset('storage/' . $image) }}" alt="Report Image" class="w-40 h-40 object-contain bg-white dark:bg-[#23263a] p-2 transition-transform duration-200 hover:scale-105" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <span class="text-gray-500 dark:text-gray-400 ml-2">No images</span>
                @endif
            </div>
        </div>
    </div>
@endsection
