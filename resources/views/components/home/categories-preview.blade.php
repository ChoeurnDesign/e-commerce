<!-- Categories Preview Section -->
<div id="categories" class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('Shop by Category') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-300 text-lg">
                {{ __('Explore our wide range of product categories') }}
            </p>
        </div>
        <x-categories.category-card :parentCategories="$parentCategories" />
    </div>
    <div class="text-center mt-12">
        <a href="{{ route('categories.index') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-purple-700 dark:hover:bg-purple-600 dark:focus:ring-purple-400">
            {{ __('View All Categories') }}
        </a>
    </div>
</div>
