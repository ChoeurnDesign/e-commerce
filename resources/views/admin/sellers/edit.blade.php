@extends('layouts.admin')
@section('title', 'Seller Management')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <x-icon-nav name="users" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
            <h1 class="ml-2 text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Seller</h1>
        </div>  
    </div>

    <div class="bg-white dark:bg-[#23263a] p-8 rounded-lg shadow-sm border border-gray-200 dark:border-[#23263a]">
        <form method="POST" action="{{ route('admin.sellers.update', $seller) }}">
            @csrf
            @method('PUT')

            <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="name" value="Full Name"/>
                        <x-text-input id="name" name="name" type="text" 
                                      class="mt-1 block w-full dark:bg-[#1a1d2e] dark:border-gray-700 dark:text-gray-300"
                                      :value="old('name', $seller->user?->name)" required autofocus/>
                    </div>
                    <div>
                        <x-input-label for="email" value="Email Address"/>
                        <x-text-input id="email" name="email" type="email" 
                                      class="mt-1 block w-full dark:bg-[#1a1d2e] dark:border-gray-700 dark:text-gray-300"
                                      :value="old('email', $seller->user?->email)" required/>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Store Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="store_name" value="Store Name"/>
                        <x-text-input id="store_name" name="store_name" type="text" 
                                      class="mt-1 block w-full dark:bg-[#1a1d2e] dark:border-gray-700 dark:text-gray-300"
                                      :value="old('store_name', $seller->store_name)" required/>
                    </div>
                    <div>
                        <x-input-label for="status" value="Verification Status"/>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-[#1a1d2e] text-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="pending" @selected(old('status', $seller->status) == 'pending')>Pending</option>
                            <option value="approved" @selected(old('status', $seller->status) == 'approved')>Approved</option>
                            <option value="rejected" @selected(old('status', $seller->status) == 'rejected')>Rejected</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2">
                    Save Changes
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection