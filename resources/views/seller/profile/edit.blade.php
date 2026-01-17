@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Seller Profile</h1>
    @if(session('status'))
        <div class="mb-4 text-green-600">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('seller.profile.update') }}">
        @csrf
        <input type="hidden" name="_method" value="">

        <div class="mb-4">
            <label class="block text-gray-700">Store Name</label>
            <input type="text" name="store_name" value="{{ old('store_name', $seller->store_name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @error('store_name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Add more seller-specific fields here --}}

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">
            Save Changes
        </button>
    </form>
</div>
@endsection

