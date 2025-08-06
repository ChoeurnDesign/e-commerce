@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-300 dark:bg-[#181f31] min-h-screen">
    <h1 class="text-2xl font-bold mb-6 flex items-center text-gray-900 dark:text-gray-100">
        <x-icon-dashboard name="settings" class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-200" />
        Settings
    </h1>
    <table class="min-w-full bg-white dark:bg-[#23263a] rounded shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <thead>
            <tr>
                <th class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-700 dark:text-gray-200">#</th>
                <th class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-700 dark:text-gray-200">Setting</th>
                <th class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-700 dark:text-gray-200">Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($settings as $setting)
                <tr>
                    <td class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-center text-gray-800 dark:text-gray-100">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-800 dark:text-gray-100">{{ $setting->key }}</td>
                    <td class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-800 dark:text-gray-100">{{ $setting->value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
