<x-public-layout title="Menu">
    <div class="page-transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-4">Our Menu</h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Discover our delicious selection of products, carefully crafted with the finest ingredients.
                </p>
            </div>

            <!-- Filter Toggle and View Mode -->
            <div class="flex justify-between items-center mb-6">
                <button id="filter-toggle" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                    Filters
                </button>
                
                <div class="flex items-center space-x-4">
                    <!-- Weight Filter Dropdown -->
                    <div class="relative">
                        <label for="global-weight-filter" class="sr-only">Filter by Weight</label>
                        <select id="global-weight-filter" class="bg-gray-800 border border-gray-600 text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                            <option value="">All Weights</option>
                            @foreach($dynamicWeightOptions as $option)
                                <option value="{{ $option->value }}" {{ request('selected_weight') == $option->value ? 'selected' : '' }}>
                                    {{ $option->label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <form method="GET" action="{{ route('menu') }}" class="inline">
                        @foreach(request()->except('view_mode') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="view_mode" onchange="this.form.submit()" class="bg-gray-800 border border-gray-600 text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="grid" {{ request('view_mode', 'grid') == 'grid' ? 'selected' : '' }}>Grid View</option>
                            <option value="list" {{ request('view_mode') == 'list' ? 'selected' : '' }}>List View</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Collapsible Filters -->
            <div id="filter-panel" class="hidden bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                <form method="GET" action="{{ route('menu') }}" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Search products...">
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                            <select id="category" name="category" class="w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">All Categories</option>
                                @foreach($allCategories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subcategory -->
                        <div>
                            <label for="subcategory" class="block text-sm font-medium text-gray-300 mb-2">Subcategory</label>
                            <select id="subcategory" name="subcategory" class="w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">All Subcategories</option>
                                @foreach($allSubcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Price Range</label>
                        <div class="flex items-center space-x-4">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   class="w-24 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Min" step="0.01">
                            <span class="text-gray-400">to</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   class="w-24 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Max" step="0.01">
                        </div>
                    </div>

                    <!-- Submit/Clear Buttons -->
                    <div class="flex justify-between">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md transition-colors">
                            Apply Filters
                        </button>
                        <a href="{{ route('menu') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md transition-colors">
                            Clear All
                        </a>
                    </div>
                </form>
            </div>

            <!-- Categories with Products -->
            @if($categories->count() > 0)
                @foreach($categories as $category)
                    @if($category->products->count() > 0)
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold text-purple-400 mb-6">{{ $category->name }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($category->products as $product)
                                    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700 hover:border-purple-500 transition-colors">
                                        <div class="aspect-w-16 aspect-h-9">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="w-full h-48 object-cover">
                                            @else
                                                <div class="w-full h-48 bg-gray-600 flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold text-white mb-2">{{ $product->name }}</h3>
                                            <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                            <div class="flex justify-between items-center">
                                                <span class="text-green-400 font-semibold">{{ $product->display_price }}</span>
                                                <a href="{{ route('product.show', $product) }}" 
                                                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm transition-colors">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

            <!-- Uncategorized Products -->
            @if($uncategorizedProducts->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-purple-400 mb-6">Other Products</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($uncategorizedProducts as $product)
                            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700 hover:border-purple-500 transition-colors">
                                <div class="aspect-w-16 aspect-h-9">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-600 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-white mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-green-400 font-semibold">{{ $product->display_price }}</span>
                                        <a href="{{ route('product.show', $product) }}" 
                                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm transition-colors">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Empty State -->
            @if($categories->count() === 0 && $uncategorizedProducts->count() === 0)
                <div class="text-center py-16">
                    <svg class="mx-auto h-16 w-16 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No products found</h3>
                    <p class="text-gray-400 mb-6">Try adjusting your filters or search terms.</p>
                    <a href="{{ route('menu') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md transition-colors">
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter toggle functionality
            const filterToggle = document.getElementById('filter-toggle');
            const filterPanel = document.getElementById('filter-panel');
            
            if (filterToggle && filterPanel) {
                filterToggle.addEventListener('click', function() {
                    filterPanel.classList.toggle('hidden');
                });
            }
        });
    </script>
    @endpush
</x-public-layout>
