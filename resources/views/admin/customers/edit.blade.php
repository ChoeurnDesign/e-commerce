@extends('layouts.admin')

@section('content')

<div class="space-y-6 min-h-screen">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Customer #{{ $customer->id }}</h2>
    
    <div class="max-w-full mx-auto bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-gray-600">

        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile Image --}}
            <div class="mb-4">
                <x-input-label value="Profile Image" />
                <div class="mt-1 flex items-center space-x-4">
                    @if($customer->profile_image)
                        <img src="{{ asset('storage/'.$customer->profile_image) }}" 
                             class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500">
                    @else
                        <div class="w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-2xl font-bold text-indigo-700 dark:text-indigo-300">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" name="profile_image" accept="image/*"
                               class="block w-full text-sm text-gray-500 dark:text-gray-400
                               file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                               file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty to keep current image. Max 2MB.</p>
                    </div>
                </div>
                @error('profile_image')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Customer Name --}}
            <div class="mb-4">
                <x-input-label for="name" value="Full Name" />
                <x-text-input name="name" id="name" :value="old('name', $customer->name)" required
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md" />
                @error('name')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Customer Email --}}
            <div class="mb-4">
                <x-input-label for="email" value="Email Address" />
                <x-text-input type="email" name="email" id="email" :value="old('email', $customer->email)" required
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md" />
                @error('email')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone Number (You need to add this column to users table if you want it) --}}
            <div class="mb-4">
                <x-input-label for="phone" value="Phone Number" />
                <x-text-input type="tel" name="phone" id="phone" :value="old('phone', $customer->phone ?? '')"
                    placeholder="+1 234 567 8900"
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md" />
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">⚠️ This field requires adding a 'phone' column to users table</p>
                @error('phone')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- User Role --}}
            <div class="mb-4">
                <x-input-label for="role" value="User Role" />
                <select name="role" id="role" 
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                    <option value="user" {{ old('role', $customer->role) == 'user' ? 'selected' : '' }}>👤 User</option>
                    <option value="seller" {{ old('role', $customer->role) == 'seller' ? 'selected' : '' }}>🛍️ Seller</option>
                    <option value="admin" {{ old('role', $customer->role) == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                </select>
                @error('role')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password (Optional) --}}
            <div class="mb-4">
                <x-input-label for="password" value="New Password (Optional)" />
                <x-text-input type="password" name="password" id="password"
                    placeholder="Leave blank to keep current password"
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md" />
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 8 characters. Only enter if you want to change password.</p>
                @error('password')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <x-input-label for="password_confirmation" value="Confirm New Password" />
                <x-text-input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md" />
            </div>

            {{-- Preferences Section (These exist in your users table) --}}
            <div class="mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Preferences</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Preferred Currency (EXISTS in your table) --}}
                    <div>
                        <x-input-label for="preferred_currency" value="Preferred Currency" />
                        <select name="preferred_currency" id="preferred_currency"
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                            <option value="USD" {{ old('preferred_currency', $customer->preferred_currency ?? 'USD') == 'USD' ? 'selected' : '' }}>💵 USD ($)</option>
                            <option value="EUR" {{ old('preferred_currency', $customer->preferred_currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>💶 EUR (€)</option>
                            <option value="GBP" {{ old('preferred_currency', $customer->preferred_currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>💷 GBP (£)</option>
                            <option value="KHR" {{ old('preferred_currency', $customer->preferred_currency ?? 'USD') == 'KHR' ? 'selected' : '' }}>៛ KHR (៛)</option>
                        </select>
                    </div>

                    {{-- Preferred Language (EXISTS in your table) --}}
                    <div>
                        <x-input-label for="preferred_language" value="Preferred Language" />
                        <select name="preferred_language" id="preferred_language"
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                            <option value="en" {{ old('preferred_language', $customer->preferred_language ?? 'en') == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                            <option value="km" {{ old('preferred_language', $customer->preferred_language ?? 'en') == 'km' ? 'selected' : '' }}>🇰🇭 ភាសាខ្មែរ</option>
                            <option value="zh" {{ old('preferred_language', $customer->preferred_language ?? 'en') == 'zh' ? 'selected' : '' }}>🇨🇳 中文</option>
                        </select>
                    </div>

                    {{-- Timezone (EXISTS in your table) --}}
                    <div>
                        <x-input-label for="timezone" value="Timezone" />
                        <select name="timezone" id="timezone"
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                            <option value="UTC" {{ old('timezone', $customer->timezone ?? 'UTC') == 'UTC' ? 'selected' : '' }}>🌍 UTC</option>
                            <option value="Asia/Phnom_Penh" {{ old('timezone', $customer->timezone ?? 'UTC') == 'Asia/Phnom_Penh' ? 'selected' : '' }}>🇰🇭 Asia/Phnom Penh</option>
                            <option value="America/New_York" {{ old('timezone', $customer->timezone ?? 'UTC') == 'America/New_York' ? 'selected' : '' }}>🇺🇸 America/New York</option>
                            <option value="Europe/London" {{ old('timezone', $customer->timezone ?? 'UTC') == 'Europe/London' ? 'selected' : '' }}>🇬🇧 Europe/London</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 flex space-x-4">
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm transition">
                    Update Customer
                </button>
                <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md shadow-sm transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection