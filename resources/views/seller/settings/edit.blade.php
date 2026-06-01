@extends('layouts.seller')

@section('content')
@php
    $user   = auth()->user();
    $seller = $seller ?? $user->seller;
@endphp

<div class="max-w-full mx-auto p-6">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Store Settings</h1>
            <p class="text-xs text-gray-500">Manage your store profile, branding, and shipping</p>
        </div>
    </div>

    @if($seller->admin_comment && $seller->status === 'rejected')
        <div class="mb-4 flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-800">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <span><strong>Admin Comment:</strong> {{ $seller->admin_comment }}</span>
        </div>
    @endif

    <form method="POST"
          action="{{ route('seller.settings.update') }}"
          enctype="multipart/form-data"
          class="space-y-10">
        @csrf
        
        {{-- STORE INFO --}}
        <section class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-5">
            <h2 class="text-lg font-semibold text-gray-800">Store Information</h2>

            <div>
                <label class="block text-sm font-medium mb-1">Store Name</label>
                <input type="text" name="store_name"
                       value="{{ old('store_name', $seller->store_name) }}"
                       class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500"
                       required>
                @error('store_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500">{{ old('description', $seller->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Contact Email (optional) -->
            <div>
                <label class="block text-sm font-medium mb-1">Contact Email</label>
                <input type="email" name="contact_email"
                       value="{{ old('contact_email', $seller->contact_email ?? '') }}"
                       placeholder="seller@example.com"
                       class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500"
                       >
                @error('contact_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Address (optional) -->
            <div>
                <label class="block text-sm font-medium mb-1">Address</label>
                <input type="text" name="address"
                       value="{{ old('address', $seller->address ?? '') }}"
                       placeholder="Street, City, Country"
                       class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500"
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
        <section class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-5">
            <h2 class="text-lg font-semibold text-gray-800">Contact, Socials & Shipping</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left: contact --}}
                <div class="space-y-4">
                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-1">Phone</label>
                        <input type="text" name="phone"
                            value="{{ old('phone', $seller->phone ?? '') }}"
                            placeholder="+855 12 345 678"
                            class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 mt-1">Public phone number for customers (optional).</p>
                    </div>

                    {{-- Website & Socials partial --}}
                    @include('seller.settings.partials.social-links')
                </div>

                {{-- Right: shipping & returns --}}
                <div class="space-y-4">
                    {{-- Ships worldwide --}}
                    <div class="flex items-start gap-3">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-800 mb-1">Ships worldwide?</label>
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-800">
                                    <input type="hidden" name="ships_worldwide" value="0">
                                    <input type="checkbox" name="ships_worldwide" value="1"
                                        {{ old('ships_worldwide', $seller->ships_worldwide ?? false) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-pink-600 focus:ring-pink-500 focus:border-pink-500">
                                    <span>Yes, I ship internationally</span>
                                </label>
                            </div>
                            @error('ships_worldwide') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Returns days --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-1">Returns (days)</label>
                        <input type="number" name="returns_days" min="0" step="1"
                            value="{{ old('returns_days', $seller->returns_days ?? '') }}"
                            placeholder="eg. 14"
                            class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500">
                        @error('returns_days') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 mt-1">Number of days customers can return items (optional).</p>
                    </div>

                    {{-- Typical response time --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-1">Typical response time</label>
                        <input type="text" name="response_time"
                            value="{{ old('response_time', $seller->response_time ?? '') }}"
                            placeholder="e.g. 1-2 business days"
                            class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500">
                        @error('response_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Shipping summary --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-1">Shipping summary</label>
                        <textarea name="shipping_summary" rows="4"
                                class="w-full rounded border border-gray-300 focus:ring-pink-500 focus:border-pink-500">{{ old('shipping_summary', $seller->shipping_summary ?? '') }}</textarea>
                        @error('shipping_summary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 mt-1">Short shipping details customers will see on your storefront (optional).</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- STORE LOGO & BANNER --}}
        <section class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-5">
            <h2 class="text-lg font-semibold text-gray-800">Store Logo & Banner</h2>

            <div class="grid gap-6 grid-cols-1 md:grid-cols-3 items-start">
                {{-- Left column: Logo preview --}}
                <div class="flex flex-col items-center gap-3">
                    @php
                        $storeLogo = $seller->store_logo_url;
                        $storeName = $seller->store_name;
                        
                        $storeInitials = 'S';
                        if ($storeName) {
                            $words = explode(' ', $storeName);
                            $initialsArray = array_map(fn($word) => mb_substr($word, 0, 1), $words);
                            $storeInitials = strtoupper(implode('', $initialsArray));
                        }
                    @endphp

                    <div class="w-28 h-28 rounded-full overflow-hidden border border-pink-500 bg-gray-100 flex items-center justify-center">
                        @if($storeLogo)
                            <img src="{{ $storeLogo }}" 
                                alt="Store Logo" 
                                class="w-full h-full object-cover"
                                onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                            <div class="w-full h-full bg-pink-600 text-white hidden flex items-center justify-center font-bold text-2xl">
                                {{ $storeInitials }}
                            </div>
                        @else
                            <div class="w-full h-full bg-pink-600 text-white flex items-center justify-center font-bold text-2xl">
                                {{ $storeInitials }}
                            </div>
                        @endif
                    </div>

                    <span class="text-[11px] text-gray-500">Store Logo (square)</span>

                    <label class="inline-flex items-center gap-2 text-sm mt-2 cursor-pointer">
                        <input type="checkbox" name="remove_logo" value="1"
                            class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                        <span class="text-gray-700">Remove current logo</span>
                    </label>

                    <div class="w-full">
                        <input type="file" name="store_logo" accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full text-sm text-gray-500
                            file:bg-pink-600 file:text-white file:border-0 file:px-3 file:py-2 file:rounded
                            file:hover:bg-pink-700 mt-2">
                        @error('store_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Middle & right columns: Banner preview --}}
                <div class="md:col-span-2">
                    <div class="flex flex-col gap-3">
                        <div class="w-full rounded overflow-hidden border border-gray-300 bg-gray-100">
                            @if($seller->store_banner_url)
                                <img src="{{ $seller->store_banner_url }}" 
                                    alt="Store Banner" 
                                    class="w-full h-40 object-cover"
                                    onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                                {{-- This placeholder shows if the image link is broken --}}
                                <div class="w-full h-40 hidden flex items-center justify-center bg-gray-200 text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium">Banner could not be loaded</span>
                                    </div>
                                </div>
                            @else
                                {{-- This placeholder shows if no banner is uploaded --}}
                                <div class="w-full h-40 flex items-center justify-center bg-gray-200 text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium">No banner uploaded</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-[11px] text-gray-500">Store Banner (1500×500)</span>

                            <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" name="remove_banner" value="1"
                                    class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                                <span class="text-gray-700">Remove current banner</span>
                            </label>
                        </div>

                        <div>
                            <input type="file" name="store_banner" accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm text-gray-500
                                file:bg-pink-600 file:text-white file:border-0 file:px-3 file:py-2 file:rounded
                                file:hover:bg-pink-700">
                            <p class="text-xs text-gray-500 mt-1">Accepted: JPG / PNG / WEBP (max 5MB)</p>
                            @error('store_banner') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- BUSINESS DOCUMENT --}}
        <section class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-5">
            <h2 class="text-lg font-semibold text-gray-800">Business Document</h2>

            @if($seller->business_document_url)
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="{{ $seller->business_document_url }}" target="_blank"
                       class="px-3 py-1 rounded bg-pink-600 text-white text-xs hover:bg-pink-500">
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
                       class="block w-full text-sm text-gray-300
                       file:bg-pink-600 file:text-white file:border-0 file:px-3 file:py-2 file:rounded
                       file:hover:bg-pink-700">
                <p class="text-xs text-gray-500 mt-1">Accepted: PDF / JPG / PNG / WEBP (max 4MB)</p>
                @error('business_document') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </section>

        <div class="flex gap-4">
            <button type="submit"
                    class="px-6 py-2 rounded bg-pink-600 text-white text-sm font-medium hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                Save Changes
            </button>
            <a href="{{ route('seller.dashboard') }}"
               class="px-6 py-2 rounded border text-sm hover:bg-gray-50">
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