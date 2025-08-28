@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-[#23263a] p-8 rounded-xl shadow mt-12 border border-gray-200 dark:border-[#23263a]">
    <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Customer</h2>
    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <x-input-label for="name" value="Name" class="mb-1 font-medium" />
            <x-text-input name="name" id="name" :value="old('name', $customer->name)" required
                class="w-full border border-gray-400 dark:border-gray-500 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-200" />
        </div>
        <div class="mb-4">
            <x-input-label for="email" value="Email" class="mb-1 font-medium" />
            <x-text-input type="email" name="email" id="email" :value="old('email', $customer->email)" required
                class="w-full border border-gray-400 dark:border-gray-500 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-200" />
        </div>
        <div class="mb-4">
            <x-input-label for="role" value="Role" class="mb-1 font-medium" />
            <select name="role" id="role"
                class="w-full border border-gray-400 dark:border-gray-500 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-200">
                <option value="user" {{ old('role', $customer->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $customer->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="flex justify-end space-x-2">
            <x-admin.form-submit-button :action="route('admin.customers.update', $customer->id)">Save</x-admin.form-submit-button>
            <x-admin.form-cancel-button :href="route('admin.customers.index')">Cancel</x-admin.form-cancel-button>
        </div>
    </form>
</div>
@endsection
