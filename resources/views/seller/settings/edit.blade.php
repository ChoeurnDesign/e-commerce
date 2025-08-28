@extends('layouts.seller')

@section('content')
@php
    $user   = auth()->user();
    $seller = $seller ?? $user->seller;
@endphp

<div class="max-w-5xl mx-auto p-6">
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
                       class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
                @error('store_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $seller->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

        {{-- STORE LOGO --}}
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Store Logo</h2>

            @if($seller->store_logo_url)
                <div class="flex items-start gap-6 flex-wrap">
                    <div class="flex flex-col items-center gap-2">
                        <img src="{{ $seller->store_logo_url }}"
                             alt="Store Logo"
                             class="w-28 h-28 rounded object-cover border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700"
                             onerror="this.onerror=null;this.src='{{ asset('images/default-store.png') }}';">
                        <span class="text-[11px] text-gray-500">Current Logo</span>
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm mt-2">
                        <input type="checkbox" name="remove_logo" value="1"
                               class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                        <span>Remove current logo</span>
                    </label>
                </div>
            @else
                <p class="text-sm text-gray-500">No logo uploaded yet.</p>
            @endif

            <div>
                <input type="file" name="store_logo" accept=".jpg,.jpeg,.png,.webp"
                       class="block w-full text-sm text-gray-300 dark:text-gray-300
                       file:bg-gray-700 file:dark:bg-gray-600 file:text-gray-100 file:border-0 file:px-3 file:py-2 file:rounded
                       file:hover:bg-gray-600">
                <p class="text-xs text-gray-500 mt-1">Accepted: JPG / PNG / WEBP (max 3MB)</p>
                @error('store_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

        {{-- Debug block (remove in production)
        <pre class="mt-8 text-[11px] text-gray-500">
Raw store_logo: {{ $seller->store_logo }}
Resolved store_logo_url: {{ $seller->store_logo_url }}
File exists? @php try{ echo Storage::disk('public')->exists($seller->store_logo ?? '') ? 'YES' : 'NO'; }catch(\Throwable $e){ echo 'error'; } @endphp
        </pre>
        --}}
    </form>
</div>
@endsection