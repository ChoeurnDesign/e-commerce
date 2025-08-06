<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen"> {{-- Added dark mode background and min-h-screen --}}
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Your Review</h2> {{-- Added dark:text-gray-100 --}}

            @if ($errors->any())
                <div class="mb-4 text-red-600 dark:text-red-400"> {{-- Added dark:text-red-400 --}}
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md"> {{-- Added dark:bg-gray-800, p-6, rounded-lg, shadow-md --}}
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rating</label> {{-- Added dark:text-gray-300 --}}
                    <div
                        x-data="{ rating: {{ old('rating', $review->rating) }} }"
                        class="flex space-x-2"
                    >
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input
                                    type="radio"
                                    name="rating"
                                    value="{{ $i }}"
                                    class="sr-only"
                                    x-model="rating"
                                >
                                <svg
                                    :class="rating >= {{ $i }} ? 'text-yellow-400 dark:text-yellow-300' : 'text-gray-300 dark:text-gray-600'"
                                    class="w-8 h-8 transition-colors duration-150"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</div> {{-- Added dark:text-red-400 --}}
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Review</label> {{-- Added dark:text-gray-300 --}}
                    <textarea id="comment" name="comment" rows="4" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">{{ old('comment', $review->comment) }}</textarea> {{-- Added dark mode styles for textarea --}}
                    @error('comment')
                        <div class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</div> {{-- Added dark:text-red-400 --}}
                    @enderror
                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium dark:bg-indigo-700 dark:hover:bg-indigo-600"> {{-- Added dark mode for button --}}
                    Update Review
                </button>
                <a href="{{ route('products.show', $review->product->slug) }}" class="ml-4 text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">Back to Product</a> {{-- Added dark mode text colors --}}
            </form>
        </div>
    </div>
</x-app-layout>
