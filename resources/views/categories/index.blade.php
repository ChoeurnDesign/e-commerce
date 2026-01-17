<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-categories.category-card :parentCategories="$parentCategories" />
            
        </div>
    </div>
</x-app-layout>
