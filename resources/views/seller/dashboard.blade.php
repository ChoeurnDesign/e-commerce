@extends('layouts.seller')

@section('title', 'Seller Dashboard')

@section('content')
@php
    $seller = $seller ?? auth()->user()->seller;
@endphp

@if(!$seller)
    <div class="p-6 bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded">
        <h2 class="text-lg font-semibold text-red-700 dark:text-red-300 mb-2">No Seller Account</h2>
        <p class="text-sm text-red-600 dark:text-red-200">
            You have not created a seller profile yet.
            <a href="{{ route('seller.register.form') }}" class="underline text-indigo-600 dark:text-indigo-400">
                Start here
            </a>.
        </p>
    </div>
@else
<div class="max-w-full mx-auto py-6 space-y-10">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-3">
            <x-icon-nav name="dashboard" class="w-8 h-8 text-indigo-600" />
            Dashboard
        </h1>

        @if($seller->status === 'approved')
            <a href="{{ route('seller.products.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <x-icon-nav name="add" class="w-5 h-5 mr-2" />
                Add Product
            </a>
        @endif
    </div>

    {{-- Metrics --}}
    <section aria-label="Key metrics" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-seller.metric-card
            label="Active Products"
            :value="$productsCount"
            color="indigo" />
        <x-seller.metric-card
            label="Total Orders"
            :value="$ordersCount"
            color="green" />
        <x-seller.metric-card
            label="Average Rating"
            :value="$averageRating !== null ? number_format($averageRating,2) : '—'"
            color="yellow" />
    </section>

    {{-- Store Status --}}
    <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
        <div class="mb-4 flex flex-wrap items-center gap-3">
            <span class="font-semibold text-lg text-gray-900 dark:text-gray-100">Store Status:</span>
            <span class="px-4 py-1 rounded-full text-sm font-semibold capitalize
                @if($seller->status === 'approved')
                    bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200
                @elseif($seller->status === 'pending')
                    bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200
                @elseif($seller->status === 'rejected')
                    bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200
                @else
                    bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200
                @endif">
                {{ $seller->status }}
            </span>
        </div>

        @if($seller->status === 'approved')
            <div class="flex items-start gap-4">
                <x-icon-nav name="approve" class="w-14 h-14 text-green-500 dark:text-green-300" />
                <div>
                    <p class="text-green-700 dark:text-green-300 text-lg font-semibold">Your seller account is active!</p>
                    <p class="text-gray-600 dark:text-gray-400">Manage your products, track sales, and grow your store.</p>
                </div>
            </div>
        @elseif($seller->status === 'pending')
            <div class="flex items-start gap-4">
                <x-icon-nav name="pending" class="w-14 h-14 text-yellow-500 dark:text-yellow-300" />
                <div>
                    <p class="text-yellow-700 dark:text-yellow-200 text-lg font-semibold">Application Pending</p>
                    <p class="text-gray-600 dark:text-gray-400">
                        Awaiting admin review. Ensure all required details are complete.
                        <a href="{{ route('seller.register.form') }}" class="text-indigo-600 dark:text-indigo-400 underline">Review store profile</a>.
                    </p>
                    @includeIf('seller.partials.onboarding-checklist', ['seller' => $seller])
                </div>
            </div>
        @elseif($seller->status === 'rejected')
            <div class="flex items-start gap-4">
                <x-icon-nav name="reject" class="w-14 h-14 text-red-500 dark:text-red-300" />
                <div>
                    <p class="text-red-700 dark:text-red-200 text-lg font-semibold">Application Rejected</p>
                    <p class="text-gray-600 dark:text-gray-400">
                        Update required info & re-apply:
                        <a href="{{ route('seller.register.form') }}" class="text-indigo-600 dark:text-indigo-400 underline">Store profile</a>.
                    </p>
                    @if($seller->admin_comment)
                        <p class="mt-2 text-sm text-red-500 dark:text-red-400">Reason: {{ $seller->admin_comment }}</p>
                    @endif
                    @includeIf('seller.partials.onboarding-checklist', ['seller' => $seller])
                </div>
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">Status information unavailable.</p>
        @endif
    </section>

</div>
@endif
@endsection