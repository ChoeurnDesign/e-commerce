@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <div class="space-y-6">
        @include('admin.dashboard._header')

        @include('admin.dashboard._stats')

        @include('admin.dashboard._charts')

        @include('admin.dashboard._quick-actions')
    </div>
</div>
@endsection

@push('scripts')
@include('admin.dashboard._chart-scripts')
@endpush