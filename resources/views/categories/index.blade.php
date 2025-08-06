<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Shop by Category</h1>
                <p class="text-xl text-gray-600 dark:text-gray-300">Explore our wide range of product categories</p>
            </div>
            <x-categories.category-card :parentCategories="$parentCategories" />
        </div>
    </div>
</x-app-layout>
