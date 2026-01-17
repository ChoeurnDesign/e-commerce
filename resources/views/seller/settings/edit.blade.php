@extends('layouts.seller')

@section('content')
@php
    $user   = auth()->user();
    $seller = $seller ?? $user->seller;
@endphp

<div class="max-w-full mx-auto p-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Store Profile</h1>

    {{-- Flash messages --}}
    @foreach (['status' => 'green', 'info' => 'amber'] as $flash => $color)
        @if(session($flash))
            <div class="mb-4 bg-{{ $color }}-100 text-{{ $color }}-800 px-4 py-2 rounded text-sm">
                {{ session($flash) }}
            </div>
        @endif
    @endforeach

    @if($seller->admin_comment && $seller->status === 'rejected')
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded text-sm">
            Admin Comment: {{ $seller->admin_comment }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('seller.settings.update') }}"
          enctype="multipart/form-data"
          class="space-y-10">
        @csrf
        
        {{-- STORE INFO --}}
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Store Information</h2>

            <div>
                <label class="block text-sm font-medium mb-1">Store Name</label>
                <input type="text" name="store_name"
                       value="{{ old('store_name', $seller->store_name) }}"
                       class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
                @error('store_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $seller->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Contact Email (optional) -->
            <div>
                <label class="block text-sm font-medium mb-1">Contact Email</label>
                <input type="email" name="contact_email"
                       value="{{ old('contact_email', $seller->contact_email ?? '') }}"
                       placeholder="seller@example.com"
                       class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                       >
                @error('contact_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Address (optional) -->
            <div>
                <label class="block text-sm font-medium mb-1">Address</label>
                <input type="text" name="address"
                       value="{{ old('address', $seller->address ?? '') }}"
                       placeholder="Street, City, Country"
                       class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                       >
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="text-sm">
                <span class="font-medium">Status:</span>
                <span class="ml-2 px-2 py-0.5 rounded text-xs
                    @class([
                        'bg-green-500/20 text-green-600' => $seller->status==='approved',
                        'bg-amber-500/20 text-amber-600' => $seller->status==='pending',
                        'bg-red-500/20 text-red-600'     => $seller->status==='rejected',
                        'bg-gray-500/20 text-gray-400'   => !in_array($seller->status,['approved','pending','rejected']),
                    ])">
                    {{ ucfirst($seller->status) }}
                </span>
            </div>
        </section>

        {{-- CONTACT, SOCIALS & SHIPPING --}}
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Contact, Socials & Shipping</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left: contact --}}
                <div class="space-y-4">
                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-1">Phone</label>
                        <input type="text" name="phone"
                            value="{{ old('phone', $seller->phone ?? '') }}"
                            placeholder="+855 12 345 678"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Public phone number for customers (optional).</p>
                    </div>

                    {{-- Website & Socials partial --}}
                    @include('seller.settings.partials.social-links')
                </div>

                {{-- Right: shipping & returns --}}
                <div class="space-y-4">
                    {{-- Ships worldwide --}}
                    <div class="flex items-start gap-3">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-1">Ships worldwide?</label>
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-800 dark:text-gray-100">
                                    <input type="hidden" name="ships_worldwide" value="0">
                                    <input type="checkbox" name="ships_worldwide" value="1"
                                        {{ old('ships_worldwide', $seller->ships_worldwide ?? false) ? 'checked' : '' }}
                                        class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 focus:border-indigo-500">
                                    <span>Yes, I ship internationally</span>
                                </label>
                            </div>
                            @error('ships_worldwide') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Returns days --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-1">Returns (days)</label>
                        <input type="number" name="returns_days" min="0" step="1"
                            value="{{ old('returns_days', $seller->returns_days ?? '') }}"
                            placeholder="eg. 14"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('returns_days') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Number of days customers can return items (optional).</p>
                    </div>

                    {{-- Typical response time --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-1">Typical response time</label>
                        <input type="text" name="response_time"
                            value="{{ old('response_time', $seller->response_time ?? '') }}"
                            placeholder="e.g. 1-2 business days"
                            class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('response_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Shipping summary --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-1">Shipping summary</label>
                        <textarea name="shipping_summary" rows="4"
                                class="w-full rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">{{ old('shipping_summary', $seller->shipping_summary ?? '') }}</textarea>
                        @error('shipping_summary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Short shipping details customers will see on your storefront (optional).</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- STORE LOGO & BANNER (combined container as requested) --}}
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Store Logo & Banner</h2>

            <div class="grid gap-6 grid-cols-1 md:grid-cols-3 items-start">
                {{-- Left column: Logo preview and controls --}}
                <div class="flex flex-col items-center gap-3">
                    {{-- This is the fixed block --}}
                    <div class="w-28 h-28 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        @if($seller->store_logo_url)
                            <img src="{{ $seller->store_logo_url }}" alt="Store Logo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500 text-center p-2">
                                <span>No logo uploaded</span>
                            </div>
                        @endif
                    </div>
                    {{-- End of the fixed block --}}

                    <span class="text-[11px] text-gray-500">Store Logo (square)</span>

                    <label class="inline-flex items-center gap-2 text-sm mt-2">
                        <input type="checkbox" name="remove_logo" value="1"
                            class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                        <span>Remove current logo</span>
                    </label>

                    <div class="w-full">
                        <input type="file" name="store_logo" accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full text-sm text-gray-300 dark:text-gray-300
                            file:bg-gray-700 file:dark:bg-gray-600 file:text-gray-100 file:border-0 file:px-3 file:py-2 file:rounded
                            file:hover:bg-gray-600 mt-2">
                        <p class="text-xs text-gray-500 mt-1">Accepted: JPG / PNG / WEBP (max 3MB, recommended 256×256)</p>
                        @error('store_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Middle & right columns: Banner preview and controls (no changes needed) --}}
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-3">
                        <div class="w-full rounded overflow-hidden border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700">
                            @if($seller->store_banner_url)
                                <img src="{{ $seller->store_banner_url }}" alt="Store Banner" class="w-full h-40 object-cover"
                                    onerror="this.onerror=null;this.src='{{ asset('images/default-banner.png') }}';">
                            @else
                                <div class="w-full h-40 flex items-center justify-center text-gray-500">
                                    <span>No banner uploaded</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-[11px] text-gray-500">Store Banner (recommended wide)</span>

                            <label class="inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" name="remove_banner" value="1"
                                    class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                                <span>Remove current banner</span>
                            </label>
                        </div>

                        <div>
                            <input type="file" name="store_banner" accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-gray-300 dark:text-gray-300
                                file:bg-gray-700 file:dark:bg-gray-600 file:text-gray-100 file:border-0 file:px-3 file:py-2 file:rounded
                                file:hover:bg-gray-600">
                            <p class="text-xs text-gray-500 mt-1">Accepted: JPG / PNG / WEBP (recommended 1500×500, max 5MB)</p>
                            @error('store_banner') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- BUSINESS DOCUMENT --}}
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Business Document</h2>

            @if($seller->business_document_url)
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="{{ $seller->business_document_url }}" target="_blank"
                       class="px-3 py-1 rounded bg-indigo-600 text-white text-xs hover:bg-indigo-500">
                        View / Download
                    </a>
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remove_document" value="1"
                               class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                        <span>Remove current document</span>
                    </label>
                </div>
            @else
                <p class="text-sm text-gray-500">No document uploaded.</p>
            @endif

            <div>
                <input type="file" name="business_document" accept=".pdf,.jpg,.jpeg,.png,.webp"
                       class="block w-full text-sm text-gray-300 dark:text-gray-300
                       file:bg-gray-700 file:dark:bg-gray-600 file:text-gray-100 file:border-0 file:px-3 file:py-2 file:rounded
                       file:hover:bg-gray-600">
                <p class="text-xs text-gray-500 mt-1">Accepted: PDF / JPG / PNG / WEBP (max 4MB)</p>
                @error('business_document') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </section>

        <div class="flex gap-4">
            <button type="submit"
                    class="px-6 py-2 rounded bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Save Changes
            </button>
            <a href="{{ route('seller.dashboard') }}"
               class="px-6 py-2 rounded border text-sm dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800">
               Back
            </a>
            @if(Route::has('store.show') && $seller->slug && $seller->status==='approved')
                <a href="{{ route('store.show', $seller) }}"
                   target="_blank"
                   class="px-6 py-2 rounded bg-gray-700 text-white text-sm hover:bg-gray-600">
                    View Storefront
                </a>
            @endif
        </div>
    </form>
</div>
@endsection