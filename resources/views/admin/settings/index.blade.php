@extends('layouts.admin')

@section('title', 'Settings Management')

@section('content')
<div class="p-4 md:p-6 w-full">
    
    {{-- Settings Content --}}
    <div class="space-y-6">
        @include('admin.settings.partials.banner-section')
        @include('admin.settings.partials.general-section')
        @include('admin.settings.partials.storefront-section')
        @include('admin.settings.partials.payment-section')
        @include('admin.settings.partials.policies-section')
    </div>

</div>
@endsection