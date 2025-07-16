<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Category Details') }}: {{ $category->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Category
                </a>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Categories
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Category Details -->
                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Name</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $category->name }}</p>
                            </div>

                            <!-- Slug -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Slug</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                    <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $category->slug }}</code>
                                </p>
                            </div>

                            <!-- Product Count -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Products</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $category->products->count() }} {{ Str::plural('product', $category->products->count()) }}
                                </p>
                            </div>

                            <!-- Timestamps -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Additional Information</h3>
                                <div class="mt-3 space-y-2">
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Created:</span> {{ $category->created_at->format('F j, Y g:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Last Updated:</span> {{ $category->updated_at->format('F j, Y g:i A') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-4 pt-6">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Category
                                </a>
                                @if($category->products->count() == 0)
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                            Delete Category
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Products in this Category -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Products in this Category</h3>
                            @if($category->products->count() > 0)
                                <div class="space-y-4">
                                    @foreach($category->products as $product)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300">${{ number_format($product->price, 2) }}</p>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    @if($product->is_available)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Available
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Unavailable
                                                        </span>
                                                    @endif
                                                    <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 text-sm">No products in this category yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
