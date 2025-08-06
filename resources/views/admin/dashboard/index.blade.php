@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-300 dark:bg-[#101624] py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <!-- Page Header -->
            @include('admin.dashboard._header')

            <!-- Stats Cards -->
            @include('admin.dashboard._stats')

            <!-- Charts Section -->
            @include('admin.dashboard._charts')

            <!-- Quick Actions -->
            @include('admin.dashboard._quick-actions')
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.dashboard._chart-scripts')
@endpush
