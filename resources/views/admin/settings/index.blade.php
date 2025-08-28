@extends('layouts.admin')

@section('title', 'Settings Management')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto p-8 min-h-screen font-sans">

    @include('admin.settings.partials.banner-section')
    @include('admin.settings.partials.general-section')
    @include('admin.settings.partials.storefront-section')
    @include('admin.settings.partials.payment-section')
    @include('admin.settings.partials.policies-section')

</div>
@endsection
