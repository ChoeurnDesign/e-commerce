@extends('layouts.admin')
@section('title', 'Edit Seller')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="flex items-center mb-6">
        <x-icon-dashboard name="users" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        <h1 class="ml-2 text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Seller</h1>
    </div>
    <form method="POST" action="{{ route('admin.sellers.update', $seller) }}">
        @csrf
        <input type="hidden" name="_method" value="">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" value="Name"/>
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                              :value="old('name', $seller->user?->name)" required autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="email" value="Email"/>
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                              :value="old('email', $seller->user?->email)" required autocomplete="email"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="store_name" value="Store Name"/>
                <x-text-input id="store_name" name="store_name" type="text" class="mt-1 block w-full"
                              :value="old('store_name', $seller->store_name)" required/>
                <x-input-error :messages="$errors->get('store_name')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="status" value="Status"/>
                <select id="status" name="status" class="mt-1 block w-full rounded">
                    <option value="pending" @selected(old('status', $seller->status) == 'pending')>Pending</option>
                    <option value="approved" @selected(old('status', $seller->status) == 'approved')>Approved</option>
                    <option value="rejected" @selected(old('status', $seller->status) == 'rejected')>Rejected</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2"/>
            </div>
        </div>
        <div class="mt-6">
            <x-primary-button>Update Seller</x-primary-button>
        </div>
    </form>
</div>
@endsection

