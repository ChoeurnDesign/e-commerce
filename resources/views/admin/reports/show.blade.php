@extends('layouts.admin')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Report #{{ $report->id }}</h1>
    <div class="bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 p-8">
        <p><strong>Title:</strong> {{ $report->title }}</p>
        <p><strong>Description:</strong> {{ $report->description }}</p>
        <p><strong>Status:</strong> {{ $report->status }}</p>
        <p><strong>Created at:</strong> {{ $report->created_at }}</p>
        <p><strong>Updated at:</strong> {{ $report->updated_at }}</p>
        <p><strong>Images:</strong>
            @php
                $images = is_array($report->images) ? $report->images : json_decode($report->images, true);
            @endphp
            @if(!empty($images) && count($images))
                <div style="display: flex; gap: 10px;">
                    @foreach ($images as $image)
                        <img src="{{ asset($image) }}" alt="Report Image" width="200">
                    @endforeach
                </div>
            @else
                No images
            @endif
        </p>
        <p><strong>Is Read:</strong> {{ $report->is_read ? 'Yes' : 'No' }}</p>
    </div>
</div>
@endsection
