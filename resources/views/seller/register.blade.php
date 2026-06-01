<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">

            {{-- Back link --}}
            <a href="{{ route('seller.landing') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-pink-600 mb-6 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Seller Info
            </a>

            @php
                $existingSeller = auth()->check() ? auth()->user()->seller : null;
            @endphp

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 rounded-xl p-4">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-blue-700">{{ session('info') }}</p>
                </div>
            @endif

            {{-- Existing application status banners --}}
            @if($existingSeller)
                @if($existingSeller->status === 'pending')
                    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
                        <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-amber-800 mb-1">Application Under Review</h3>
                        <p class="text-sm text-amber-700 mb-2">
                            Your application for <strong>{{ $existingSeller->store_name }}</strong> is being reviewed.
                            We will email you at <strong>{{ auth()->user()->email }}</strong> within 1–3 business days.
                        </p>
                        <p class="text-xs text-amber-600">
                            Submitted: {{ $existingSeller->created_at->diffForHumans() }}
                        </p>
                    </div>
                @elseif($existingSeller->status === 'approved')
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-green-800 mb-2">Your Store is Approved!</h3>
                        <p class="text-sm text-green-700 mb-4">
                            <strong>{{ $existingSeller->store_name }}</strong> is live. Start listing products and growing your business.
                        </p>
                        <a href="{{ route('seller.dashboard') }}"
                           class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">
                            Go to Seller Dashboard
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @elseif($existingSeller->status === 'rejected')
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-red-800 mb-1">Application Not Approved</h3>
                                <p class="text-sm text-red-700 mb-2">
                                    Your previous application for <strong>{{ $existingSeller->store_name }}</strong> was not approved.
                                </p>
                                @if($existingSeller->admin_comment)
                                    <div class="bg-white rounded-lg p-3 mb-3 text-sm text-red-800 border border-red-200">
                                        <strong>Reason:</strong> {{ $existingSeller->admin_comment }}
                                    </div>
                                @endif
                                <p class="text-xs text-red-600">
                                    To reapply, please <a href="{{ route('contact') }}" class="underline">contact support</a> first.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Don't show form if already has a seller record --}}
                @if(in_array($existingSeller->status, ['pending', 'approved']))
                    <div class="text-center mt-4">
                        <a href="{{ route('dashboard') }}" class="text-sm text-pink-600 hover:underline">
                            Return to Dashboard
                        </a>
                    </div>
                @endif
            @endif

            {{-- Application Form: show only if no existing seller, or if rejected (could be reapplication) --}}
            @if(!$existingSeller || $existingSeller->status === 'rejected')
                @if($existingSeller?->status !== 'rejected')
                    {{-- Header --}}
                    <div class="mb-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-pink-100 rounded-2xl mb-4">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Apply to Sell on {{ setting('store_name', 'ShopExpress') }}</h1>
                        <p class="text-gray-500 text-sm">
                            Fill out the form below. Our team reviews all applications within 1–3 business days.
                        </p>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
                    <form method="POST" action="{{ route('seller.register') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Store Name --}}
                        <div>
                            <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Store Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="store_name" name="store_name" type="text" required
                                value="{{ old('store_name') }}"
                                placeholder="e.g. Jane's Boutique"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 text-gray-900 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                            />
                            @error('store_name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Contact Email --}}
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Store Contact Email
                                <span class="text-gray-400 font-normal">(public)</span>
                            </label>
                            <input
                                id="contact_email" name="contact_email" type="email"
                                value="{{ old('contact_email', auth()->user()->email) }}"
                                placeholder="store@example.com"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 text-gray-900 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                            />
                            <p class="mt-1 text-xs text-gray-400">Shown to customers on your store page. Leave blank to use your account email.</p>
                            @error('contact_email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Store Description --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Store Description
                            </label>
                            <textarea
                                id="description" name="description" rows="3"
                                placeholder="Tell customers what your store is about, what you sell, and what makes you unique..."
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 text-gray-900 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition resize-none"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Store Logo --}}
                        <div>
                            <label for="store_logo" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Store Logo <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <label for="store_logo" class="flex-1 cursor-pointer border-2 border-dashed border-gray-200 rounded-xl p-4 flex items-center gap-3 hover:border-pink-400 transition">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-500" id="logo-label">Click to upload logo (JPG, PNG, WebP — max 2MB)</span>
                                    <input id="store_logo" name="store_logo" type="file" accept=".jpg,.jpeg,.png,.gif,.webp" class="hidden"
                                        onchange="document.getElementById('logo-label').textContent = this.files[0]?.name || 'Click to upload logo'">
                                </label>
                            </div>
                            @error('store_logo')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Business Document --}}
                        <div>
                            <label for="business_document" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Business Document <span class="text-gray-400 font-normal">(optional — speeds up review)</span>
                            </label>
                            <label for="business_document" class="cursor-pointer block border-2 border-dashed border-gray-200 rounded-xl p-4 flex items-center gap-3 hover:border-pink-400 transition">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm text-gray-500" id="doc-label">Click to upload (PDF, JPG, PNG — max 4MB)</span>
                                <input id="business_document" name="business_document" type="file" accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                                    onchange="document.getElementById('doc-label').textContent = this.files[0]?.name || 'Click to upload'">
                            </label>
                            <p class="mt-1 text-xs text-gray-400">Business registration, trade license, or ID. Providing a document helps us approve faster.</p>
                            @error('business_document')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Terms --}}
                        <div class="flex items-start gap-2.5">
                            <input id="terms" name="terms" type="checkbox" required
                                class="w-4 h-4 mt-0.5 rounded border-gray-300 text-pink-600 focus:ring-pink-500 cursor-pointer">
                            <label for="terms" class="text-sm text-gray-600 cursor-pointer">
                                I agree to the
                                <a href="#" class="text-pink-600 hover:underline">Seller Terms & Policies</a>
                                and confirm that the information provided is accurate.
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-xl shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>

                {{-- What happens next info --}}
                <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                        <div class="text-2xl font-bold text-pink-600 mb-1">1</div>
                        <p class="text-xs text-gray-500">Submit your application</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                        <div class="text-2xl font-bold text-pink-600 mb-1">2</div>
                        <p class="text-xs text-gray-500">We review in 1–3 days</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                        <div class="text-2xl font-bold text-pink-600 mb-1">3</div>
                        <p class="text-xs text-gray-500">Start selling on approval</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
