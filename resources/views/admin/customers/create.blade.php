@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-[#23263a] p-8 rounded-xl shadow mt-12 border border-gray-200 dark:border-[#23263a]">
    <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100">Add New Customer</h2>
    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <x-input-label for="name" value="Name" class="mb-1 font-medium" />
            <x-text-input name="name" id="name" :value="old('name')" required
                class="w-full border border-gray-400 dark:border-gray-500 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-200" />
        </div>
        <div class="mb-4">
            <x-input-label for="email" value="Email" class="mb-1 font-medium" />
            <x-text-input type="email" name="email" id="email" :value="old('email')" required
                class="w-full border border-gray-400 dark:border-gray-500 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-200" />
        </div>
        <div class="mb-4">
            <x-input-label for="role" value="Role" class="mb-1 font-medium" />
            <select name="role" id="role"
                class="w-full border border-gray-400 dark:border-gray-500 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-200">
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.customers.index') }}"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600 transition">Cancel</a>
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 transition">Add</button>
        </div>
    </form>
</div>
@endsection
