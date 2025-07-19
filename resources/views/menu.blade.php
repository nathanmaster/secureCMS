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
                    <!-- Sort By Dropdown -->
                    <div class="relative">
                        <label for="sort-select" class="sr-only">Sort by</label>
                        <select id="sort-select" onchange="updateSort()" class="bg-gray-800 border border-gray-600 text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                            <option value="name-asc" {{ request('sort_by') == 'name' && request('sort_direction') == 'asc' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="name-desc" {{ request('sort_by') == 'name' && request('sort_direction') == 'desc' ? 'selected' : '' }}>Name Z-A</option>
                            <option value="price-asc" {{ request('sort_by') == 'price' && request('sort_direction') == 'asc' ? 'selected' : '' }}>Price Low to High</option>
                            <option value="price-desc" {{ request('sort_by') == 'price' && request('sort_direction') == 'desc' ? 'selected' : '' }}>Price High to Low</option>
                            <option value="percentage-asc" {{ request('sort_by') == 'percentage' && request('sort_direction') == 'asc' ? 'selected' : '' }}>THC % Low to High</option>
                            <option value="percentage-desc" {{ request('sort_by') == 'percentage' && request('sort_direction') == 'desc' ? 'selected' : '' }}>THC % High to Low</option>
                        </select>
                    </div>
                    
                    <!-- View Mode -->
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

                    <!-- Price Range Slider -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Price Range</label>
                        <div class="slider-container">
                            <div class="relative">
                                <input type="range" id="price-min" name="min_price" min="0" max="200" value="{{ request('min_price', $priceRange->min_price) }}" 
                                       class="absolute w-full h-2 bg-gray-900 border border-gray-600 rounded-lg appearance-none cursor-pointer slider-thumb">
                                <input type="range" id="price-max" name="max_price" min="0" max="200" value="{{ request('max_price', $priceRange->max_price) }}" 
                                       class="absolute w-full h-2 bg-gray-900 border border-gray-600 rounded-lg appearance-none cursor-pointer slider-thumb">
                            </div>
                            <div class="flex justify-between text-sm text-gray-300 mt-6 font-medium">
                                <span>$<span id="price-min-value">{{ request('min_price', $priceRange->min_price) }}</span></span>
                                <span>$<span id="price-max-value">{{ request('max_price', $priceRange->max_price) }}</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- THC Percentage Range Slider -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">THC Percentage Range</label>
                        <div class="slider-container">
                            <div class="relative">
                                <input type="range" id="thc-min" name="min_percentage" min="0" max="40" value="{{ request('min_percentage', 0) }}" 
                                       class="absolute w-full h-2 bg-gray-900 border border-gray-600 rounded-lg appearance-none cursor-pointer slider-thumb">
                                <input type="range" id="thc-max" name="max_percentage" min="0" max="40" value="{{ request('max_percentage', 40) }}" 
                                       class="absolute w-full h-2 bg-gray-900 border border-gray-600 rounded-lg appearance-none cursor-pointer slider-thumb">
                            </div>
                            <div class="flex justify-between text-sm text-gray-300 mt-6 font-medium">
                                <span><span id="thc-min-value">{{ request('min_percentage', 0) }}</span>%</span>
                                <span><span id="thc-max-value">{{ request('max_percentage', 40) }}</span>%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Weight Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Weight Options</label>
                        <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto">
                            @foreach($dynamicWeightOptions as $option)
                                <label class="flex items-center space-x-2 text-sm">
                                    <input type="checkbox" name="weight_options[]" value="{{ $option->id }}" 
                                           {{ in_array($option->id, request('weight_options', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-600 text-purple-600 focus:ring-purple-500 focus:ring-offset-0 bg-gray-700">
                                    <span class="text-gray-300">{{ $option->label }}</span>
                                </label>
                            @endforeach
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
                                            
                                            <!-- THC Percentage -->
                                            @if($product->percentage)
                                                <div class="flex items-center mb-2">
                                                    <span class="text-xs text-gray-400 mr-2">THC:</span>
                                                    <span class="text-xs font-medium text-purple-400">{{ $product->formatted_percentage }}</span>
                                                </div>
                                            @endif
                                            
                                            <!-- Rating -->
                                            @if($product->ratings && $product->ratings->count() > 0)
                                                <div class="flex items-center mb-2">
                                                    <div class="flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-3 h-3 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                        @endfor
                                                        <span class="text-xs text-yellow-400 ml-1 font-medium">{{ number_format($product->average_rating, 1) }}</span>
                                                        <span class="text-xs text-gray-500 ml-1">({{ $product->ratings->count() }})</span>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Weight and Price Selection -->
                                            <div class="mb-3">
                                                @if($product->filteredWeightVariants && $product->filteredWeightVariants->count() > 0)
                                                    <div class="flex items-center space-x-2 mb-2">
                                                        <label class="text-xs text-gray-400">Weight:</label>
                                                        <select class="weight-selector bg-gray-700 border border-gray-600 rounded text-white text-xs px-2 py-1 focus:outline-none focus:ring-1 focus:ring-purple-500" 
                                                                data-product-id="{{ $product->id }}">
                                                            @foreach($product->filteredWeightVariants as $variant)
                                                                <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-weight-option="{{ $variant->default_weight_option_id }}">
                                                                    {{ $variant->effective_label }} - ${{ number_format($variant->price, 2) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-green-400 font-semibold product-price" data-base-price="{{ $product->price }}">
                                                            ${{ number_format($product->filteredWeightVariants->first()->price, 2) }}
                                                        </span>
                                                        <a href="{{ route('product.show', $product) }}" 
                                                           class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                                            View Details
                                                        </a>
                                                    </div>
                                                @elseif($product->availableWeightVariants && $product->availableWeightVariants->count() > 0)
                                                    <div class="flex items-center space-x-2 mb-2">
                                                        <label class="text-xs text-gray-400">Weight:</label>
                                                        <select class="weight-selector bg-gray-700 border border-gray-600 rounded text-white text-xs px-2 py-1 focus:outline-none focus:ring-1 focus:ring-purple-500" 
                                                                data-product-id="{{ $product->id }}">
                                                            @foreach($product->availableWeightVariants as $variant)
                                                                <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-weight-option="{{ $variant->default_weight_option_id }}">
                                                                    {{ $variant->effective_label }} - ${{ number_format($variant->price, 2) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-green-400 font-semibold product-price" data-base-price="{{ $product->price }}">
                                                            ${{ number_format($product->availableWeightVariants->first()->price, 2) }}
                                                        </span>
                                                        <a href="{{ route('product.show', $product) }}" 
                                                           class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                                            View Details
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-green-400 font-semibold">{{ $product->display_price }}</span>
                                                        <a href="{{ route('product.show', $product) }}" 
                                                           class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                                            View Details
                                                        </a>
                                                    </div>
                                                @endif
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
                                    
                                    <!-- THC Percentage -->
                                    @if($product->percentage)
                                        <div class="flex items-center mb-2">
                                            <span class="text-xs text-gray-400 mr-2">THC:</span>
                                            <span class="text-xs font-medium text-purple-400">{{ $product->formatted_percentage }}</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Weight and Price Selection -->
                                    <div class="mb-3">
                                        @if($product->filteredWeightVariants && $product->filteredWeightVariants->count() > 0)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <label class="text-xs text-gray-400">Weight:</label>
                                                <select class="weight-selector bg-gray-700 border border-gray-600 rounded text-white text-xs px-2 py-1 focus:outline-none focus:ring-1 focus:ring-purple-500" 
                                                        data-product-id="{{ $product->id }}">
                                                    @foreach($product->filteredWeightVariants as $variant)
                                                        <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-weight-option="{{ $variant->default_weight_option_id }}">
                                                            {{ $variant->effective_label }} - ${{ number_format($variant->price, 2) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-green-400 font-semibold product-price" data-base-price="{{ $product->price }}">
                                                    ${{ number_format($product->filteredWeightVariants->first()->price, 2) }}
                                                </span>
                                                <a href="{{ route('product.show', $product) }}" 
                                                   class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                                    View Details
                                                </a>
                                            </div>
                                        @elseif($product->availableWeightVariants && $product->availableWeightVariants->count() > 0)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <label class="text-xs text-gray-400">Weight:</label>
                                                <select class="weight-selector bg-gray-700 border border-gray-600 rounded text-white text-xs px-2 py-1 focus:outline-none focus:ring-1 focus:ring-purple-500" 
                                                        data-product-id="{{ $product->id }}">
                                                    @foreach($product->availableWeightVariants as $variant)
                                                        <option value="{{ $variant->id }}" data-price="{{ $variant->price }}" data-weight-option="{{ $variant->default_weight_option_id }}">
                                                            {{ $variant->effective_label }} - ${{ number_format($variant->price, 2) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-green-400 font-semibold product-price" data-base-price="{{ $product->price }}">
                                                    ${{ number_format($product->availableWeightVariants->first()->price, 2) }}
                                                </span>
                                                <a href="{{ route('product.show', $product) }}" 
                                                   class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                                    View Details
                                                </a>
                                            </div>
                                        @else
                                            <div class="flex justify-between items-center">
                                                <span class="text-green-400 font-semibold">{{ $product->display_price }}</span>
                                                <a href="{{ route('product.show', $product) }}" 
                                                   class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                                    View Details
                                                </a>
                                            </div>
                                        @endif
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
        
        /* Custom slider styles */
        .slider-thumb {
            -webkit-appearance: none;
            pointer-events: none;
            position: absolute;
            height: 0;
            width: 200px;
            outline: none;
            background: linear-gradient(to right, #1F2937 0%, #1F2937 100%);
            border: 1px solid #4B5563;
            border-radius: 5px;
        }
        
        .slider-thumb::-webkit-slider-thumb {
            -webkit-appearance: none;
            background: #8B5CF6;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: all;
            position: relative;
            z-index: 1;
        }
        
        .slider-thumb::-moz-range-thumb {
            background: #8B5CF6;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: all;
            position: relative;
            z-index: 1;
            border: none;
        }
        
        .slider-thumb::-webkit-slider-track {
            background: #1F2937;
            height: 5px;
            border-radius: 5px;
            border: 1px solid #4B5563;
        }
        
        .slider-thumb::-moz-range-track {
            background: #1F2937;
            height: 5px;
            border-radius: 5px;
            border: 1px solid #4B5563;
        }
        
        .slider-thumb:focus {
            outline: none;
        }
        
        .slider-thumb:focus::-webkit-slider-thumb {
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.3);
        }
        
        .slider-thumb:focus::-moz-range-thumb {
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.3);
        }
        
        /* Additional slider styling for better visibility */
        .slider-thumb::-webkit-slider-runnable-track {
            background: #1F2937;
            height: 5px;
            border-radius: 5px;
            border: 1px solid #4B5563;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .slider-thumb::-moz-range-progress {
            background: #8B5CF6;
            height: 5px;
            border-radius: 5px;
        }
        
        /* Container styling for better contrast */
        .slider-container {
            background: rgba(31, 41, 55, 0.5);
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #374151;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Pass PHP data to JavaScript
        window.selectedWeightOptions = @json($selectedWeightOptions ?? []);
        
        document.addEventListener('DOMContentLoaded', function() {
            // Filter toggle functionality
            const filterToggle = document.getElementById('filter-toggle');
            const filterPanel = document.getElementById('filter-panel');
            
            if (filterToggle && filterPanel) {
                filterToggle.addEventListener('click', function() {
                    filterPanel.classList.toggle('hidden');
                });
            }
            
            // Dual range slider functionality
            function initializeDualSlider(minId, maxId, minValueId, maxValueId, prefix = '', suffix = '') {
                const minSlider = document.getElementById(minId);
                const maxSlider = document.getElementById(maxId);
                const minValue = document.getElementById(minValueId);
                const maxValue = document.getElementById(maxValueId);
                
                if (!minSlider || !maxSlider || !minValue || !maxValue) return;
                
                function updateValues() {
                    let minVal = parseInt(minSlider.value);
                    let maxVal = parseInt(maxSlider.value);
                    
                    if (minVal > maxVal) {
                        [minVal, maxVal] = [maxVal, minVal];
                        minSlider.value = minVal;
                        maxSlider.value = maxVal;
                    }
                    
                    minValue.textContent = prefix + minVal + suffix;
                    maxValue.textContent = prefix + maxVal + suffix;
                }
                
                minSlider.addEventListener('input', updateValues);
                maxSlider.addEventListener('input', updateValues);
                
                updateValues();
            }
            
            // Initialize price range slider
            initializeDualSlider('price-min', 'price-max', 'price-min-value', 'price-max-value', '', '');
            
            // Initialize THC percentage range slider
            initializeDualSlider('thc-min', 'thc-max', 'thc-min-value', 'thc-max-value', '', '');
            
            // Weight selector functionality
            document.querySelectorAll('.weight-selector').forEach(selector => {
                selector.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    const priceElement = this.closest('.p-4').querySelector('.product-price');
                    
                    if (priceElement && price) {
                        priceElement.textContent = '$' + parseFloat(price).toFixed(2);
                    }
                });
            });
            
            // Weight filter checkbox functionality
            function updateWeightSelectors() {
                const selectedWeightOptions = Array.from(document.querySelectorAll('input[name="weight_options[]"]:checked')).map(cb => cb.value);
                let availablePrices = [];
                
                document.querySelectorAll('.weight-selector').forEach(selector => {
                    const productCard = selector.closest('.bg-gray-800');
                    const allOptions = Array.from(selector.options);
                    
                    if (selectedWeightOptions.length === 0) {
                        // No filters selected, show all options
                        allOptions.forEach(option => {
                            option.style.display = '';
                            const price = parseFloat(option.getAttribute('data-price'));
                            if (price) availablePrices.push(price);
                        });
                        if (productCard) {
                            productCard.style.display = '';
                        }
                    } else {
                        // Filter options based on selected weight checkboxes
                        let hasValidOption = false;
                        
                        allOptions.forEach(option => {
                            const weightOption = option.getAttribute('data-weight-option');
                            if (selectedWeightOptions.includes(weightOption)) {
                                option.style.display = '';
                                hasValidOption = true;
                                const price = parseFloat(option.getAttribute('data-price'));
                                if (price) availablePrices.push(price);
                            } else {
                                option.style.display = 'none';
                            }
                        });
                        
                        // Hide entire product card if no valid weight options
                        if (productCard) {
                            productCard.style.display = hasValidOption ? '' : 'none';
                        }
                        
                        // Update selected option if current selection is now hidden
                        if (hasValidOption && selector.selectedOptions[0] && selector.selectedOptions[0].style.display === 'none') {
                            const firstVisibleOption = allOptions.find(opt => opt.style.display !== 'none');
                            if (firstVisibleOption) {
                                selector.value = firstVisibleOption.value;
                                // Trigger change event to update price
                                selector.dispatchEvent(new Event('change'));
                            }
                        }
                    }
                });
                
                // Update price range sliders based on available prices - but don't constrain user input
                if (availablePrices.length > 0) {
                    const minPrice = Math.min(...availablePrices);
                    const maxPrice = Math.max(...availablePrices);
                    
                    const priceMinSlider = document.getElementById('price-min');
                    const priceMaxSlider = document.getElementById('price-max');
                    
                    if (priceMinSlider && priceMaxSlider) {
                        // Update slider bounds to allow full range from 0 to the maximum available price
                        priceMinSlider.min = 0;
                        priceMinSlider.max = Math.ceil(maxPrice);
                        priceMaxSlider.min = 0;
                        priceMaxSlider.max = Math.ceil(maxPrice);
                        
                        // Only update values if they haven't been set by user or are outside the available range
                        const currentMinValue = parseFloat(priceMinSlider.value);
                        const currentMaxValue = parseFloat(priceMaxSlider.value);
                        
                        // Don't reset user's price selection unless it's completely outside the available range
                        if (currentMinValue > maxPrice) {
                            priceMinSlider.value = Math.floor(minPrice);
                        }
                        if (currentMaxValue > Math.ceil(maxPrice)) {
                            priceMaxSlider.value = Math.ceil(maxPrice);
                        }
                        
                        // Update displayed values to reflect current slider positions
                        document.getElementById('price-min-value').textContent = priceMinSlider.value;
                        document.getElementById('price-max-value').textContent = priceMaxSlider.value;
                    }
                }
            }
            
            // Add event listeners to weight filter checkboxes
            document.querySelectorAll('input[name="weight_options[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateWeightSelectors);
            });
            
            // Initialize weight selectors on page load only if no weight filters are active from URL
            const urlParams = new URLSearchParams(window.location.search);
            const hasWeightFilters = urlParams.getAll('weight_options[]').length > 0;
            
            // Only run initial update if no weight filters are set in URL, or if we need to initialize the display
            if (!hasWeightFilters || document.querySelectorAll('input[name="weight_options[]"]:checked').length === 0) {
                updateWeightSelectors();
            }
            
            // Sort functionality
            window.updateSort = function() {
                const sortSelect = document.getElementById('sort-select');
                const [sortBy, sortDirection] = sortSelect.value.split('-');
                
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '{{ route("menu") }}';
                
                // Add all current parameters
                const params = new URLSearchParams(window.location.search);
                for (let [key, value] of params) {
                    if (key !== 'sort_by' && key !== 'sort_direction') {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }
                }
                
                // Add new sort parameters
                const sortByInput = document.createElement('input');
                sortByInput.type = 'hidden';
                sortByInput.name = 'sort_by';
                sortByInput.value = sortBy;
                form.appendChild(sortByInput);
                
                const sortDirectionInput = document.createElement('input');
                sortDirectionInput.type = 'hidden';
                sortDirectionInput.name = 'sort_direction';
                sortDirectionInput.value = sortDirection;
                form.appendChild(sortDirectionInput);
                
                document.body.appendChild(form);
                form.submit();
            };
        });
    </script>
    @endpush
</x-public-layout>
