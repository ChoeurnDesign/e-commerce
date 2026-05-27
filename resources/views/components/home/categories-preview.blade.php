<!-- Categories Preview Section -->
<div id="categories" class="py-10 sm:py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-7 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                {{ __('Shop by Category') }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base max-w-xl mx-auto">
                {{ __('Explore our wide range of product categories') }}
            </p>
        </div>
        <x-categories.category-card :parentCategories="$parentCategories" />
    </div>
    <div class="text-center mt-8 sm:mt-12">
        <a href="{{ route('categories.index') }}"
            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                   py-2.5 px-7 sm:py-3 sm:px-8 rounded-full text-sm sm:text-base
                   transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                   dark:bg-indigo-500 dark:hover:bg-indigo-600 shadow-md hover:shadow-lg">
            {{ __('View All Categories') }}
        </a>
    </div>
</div>
