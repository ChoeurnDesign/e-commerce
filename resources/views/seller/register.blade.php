<x-app-layout>
    <div class="pt-8 bg-gray-200 dark:bg-gray-900">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2 flex items-center justify-center gap-2">
                    <x-icon-nav name="store" class="w-8 h-8" />
                    Become a Seller
                </h2>
                <p class="text-gray-600 dark:text-gray-300">
                    Start selling your amazing products with us today!
                </p>
            </div>
            <div class="bg-white dark:bg-[#181b23] rounded-xl shadow-lg p-8 border border-gray-200 dark:border-[#23263a]">
                <form method="POST" action="{{ route('seller.register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="store_name" value="Store Name" class="text-gray-700 dark:text-gray-200"/>
                        <x-text-input
                            id="store_name"
                            name="store_name"
                            type="text"
                            required
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                            :value="old('store_name')"
                            placeholder="e.g. Jane's Boutique"
                        />
                        @error('store_name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="description" value="Store Description" class="text-gray-700 dark:text-gray-200"/>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="form-control w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Tell customers what your store is about..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="business_document" value="Business Document (optional, PDF/JPG/PNG)" class="text-gray-700 dark:text-gray-200"/>
                        <x-text-input
                            id="business_document"
                            name="business_document"
                            type="file"
                            class="w-full bg-white dark:bg-[#23263a] text-gray-900 dark:text-white"
                            accept=".pdf,.jpg,.jpeg,.png"
                        />
                        @error('business_document')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:underline">
                            &larr; Back to Dashboard
                        </a>
                        <button
                            type="submit"
                            class="px-6 py-2 bg-indigo-700 hover:bg-indigo-800 text-white rounded-lg shadow transition-colors"
                        >
                            Submit Application
                        </button>
                    </div>
                </form>
                <div class="text-xs text-gray-400 text-center mt-6">
                    By applying, you agree to our <a href="#" class="underline">Seller Terms & Policies</a>.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
