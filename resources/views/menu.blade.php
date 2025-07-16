<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SecureCMS') }} - Menu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom styles for dual range slider and dark mode -->
    <style>
        /* Dual Range Slider */
        .dual-range-slider {
            position: relative;
            width: 100%;
            height: 6px;
            background: #374151;
            border-radius: 3px;
            outline: none;
        }
        
        .dual-range-slider input[type="range"] {
            position: absolute;
            width: 100%;
            height: 6px;
            background: transparent;
            -webkit-appearance: none;
            appearance: none;
            pointer-events: none;
            outline: none;
        }
        
        .dual-range-slider input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            pointer-events: auto;
            position: relative;
            z-index: 2;
        }
        
        .dual-range-slider input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            pointer-events: auto;
        }
        
        .dual-range-slider input[type="range"]:hover::-webkit-slider-thumb {
            background: #2563eb;
        }
        
        .dual-range-slider input[type="range"]:hover::-moz-range-thumb {
            background: #2563eb;
        }
        
        .dual-range-slider .slider-track {
            position: absolute;
            height: 6px;
            background: #3b82f6;
            border-radius: 3px;
            pointer-events: none;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Dark Mode Styles */
        .dark {
            background-color: #111827;
            color: #f9fafb;
        }
        
        .dark .bg-gray-50 {
            background-color: #111827;
        }
        
        .dark .bg-white {
            background-color: #1f2937;
        }
        
        .dark .text-gray-900 {
            color: #f9fafb;
        }
        
        .dark .text-gray-800 {
            color: #f3f4f6;
        }
        
        .dark .text-gray-700 {
            color: #d1d5db;
        }
        
        .dark .text-gray-600 {
            color: #9ca3af;
        }
        
        .dark .text-gray-500 {
            color: #6b7280;
        }
        
        .dark .text-gray-400 {
            color: #9ca3af;
        }
        
        .dark .border-gray-300 {
            border-color: #4b5563;
        }
        
        .dark .border-gray-200 {
            border-color: #374151;
        }
        
        .dark .bg-gray-100 {
            background-color: #374151;
        }
        
        .dark .bg-gray-200 {
            background-color: #4b5563;
        }
        
        .dark .bg-blue-50 {
            background-color: #1e3a8a;
        }
        
        .dark .bg-blue-100 {
            background-color: #1e40af;
        }
        
        .dark .text-blue-800 {
            color: #dbeafe;
        }
        
        .dark .text-blue-900 {
            color: #dbeafe;
        }
        
        .dark .border-blue-200 {
            border-color: #1e40af;
        }
        
        .dark .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.16);
        }
        
        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.16);
        }
        
        .dark .bg-gray-800 {
            background-color: #111827;
        }
        
        .dark .bg-gray-50:hover {
            background-color: #374151;
        }
        
        .dark .hover\:bg-gray-100:hover {
            background-color: #4b5563;
        }
        
        .dark input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .dark select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Form Fields Dark Mode */
        .dark input[type="text"],
        .dark input[type="number"],
        .dark input[type="range"],
        .dark select {
            background-color: #374151;
            color: #f9fafb;
            border-color: #4b5563;
        }
        
        .dark input[type="text"]:focus,
        .dark input[type="number"]:focus,
        .dark select:focus {
            background-color: #4b5563;
            color: #f9fafb;
            border-color: #3b82f6;
        }
        
        .dark input[type="text"]::placeholder,
        .dark input[type="number"]::placeholder {
            color: #9ca3af;
        }
        
        .dark input[type="checkbox"] {
            background-color: #374151;
            border-color: #4b5563;
        }
        
        .dark input[type="checkbox"]:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .dark select option {
            background-color: #374151;
            color: #f9fafb;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark">>
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('menu') }}" class="text-xl font-bold text-gray-800">
                        {{ config('app.name', 'SecureCMS') }}
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('menu') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Menu
                    </a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Admin Dashboard
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Menu</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover our delicious selection of products, carefully crafted with the finest ingredients.
            </p>
        </div>

        <!-- Filter Toggle and View Mode -->
        <div class="flex justify-between items-center mb-6">
            <button id="filter-toggle" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                </svg>
                Filters
            </button>
            
            <div class="flex items-center space-x-4">
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
                    <select name="view_mode" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="grid" {{ request('view_mode', 'grid') == 'grid' ? 'selected' : '' }}>Grid View</option>
                        <option value="list" {{ request('view_mode') == 'list' ? 'selected' : '' }}>List View</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Collapsible Filters -->
        <div id="filter-panel" class="hidden bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('menu') }}" class="space-y-6">
                <!-- First Row: Search and Category -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            Search Products <span class="text-xs text-gray-500">(Ctrl+K)</span>
                        </label>
                        <input type="text" name="search" id="search" 
                               value="{{ request('search', '') }}" 
                               placeholder="Search by name or description..."
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" id="category" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}" {{ $categoryFilter == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                        <select name="subcategory" id="subcategory" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Subcategories</option>
                            @foreach($allSubcategories ?? [] as $subcat)
                                <option value="{{ $subcat->id }}" {{ ($subcategoryFilter ?? '') == $subcat->id ? 'selected' : '' }}>
                                    {{ $subcat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Second Row: Price Range Slider -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Price Range</label>
                        <div class="px-3">
                            <div class="mb-4">
                                <div class="dual-range-slider">
                                    <div class="slider-track" id="slider-track"></div>
                                    <input type="range" name="min_price" id="min_price_slider" 
                                           min="0" max="{{ $priceRange->max_price }}" 
                                           value="{{ $minPrice ?? 0 }}" step="0.01">
                                    <input type="range" name="max_price" id="max_price_slider" 
                                           min="0" max="{{ $priceRange->max_price }}" 
                                           value="{{ $maxPrice ?? $priceRange->max_price }}" step="0.01">
                                </div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>$<span id="min_price_display">{{ $minPrice ?? 0 }}</span></span>
                                <span>$<span id="max_price_display">{{ $maxPrice ?? $priceRange->max_price }}</span></span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Weight Options</label>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $defaultWeights = [
                                    ['value' => '0-100', 'label' => 'Light (0-100g)'],
                                    ['value' => '100-250', 'label' => 'Small (100-250g)'],
                                    ['value' => '250-500', 'label' => 'Medium (250-500g)'],
                                    ['value' => '500-1000', 'label' => 'Large (500g-1kg)'],
                                    ['value' => '1000+', 'label' => 'Extra Large (1kg+)'],
                                ];
                                $selectedWeights = is_array(request('weights')) ? request('weights') : [];
                            @endphp
                            @foreach($defaultWeights as $weight)
                                <label class="flex items-center bg-gray-50 px-3 py-2 rounded-md border hover:bg-gray-100">
                                    <input type="checkbox" name="weights[]" value="{{ $weight['value'] }}" 
                                           {{ in_array($weight['value'], $selectedWeights) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                                    <span class="text-sm text-gray-700">{{ $weight['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Third Row: Percentage and Availability -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="min_percentage" class="block text-sm font-medium text-gray-700 mb-2">Min Percentage</label>
                        <input type="number" name="min_percentage" id="min_percentage" 
                               value="{{ $minPercentage ?? 0 }}" 
                               min="0" max="100" step="1" placeholder="0"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="max_percentage" class="block text-sm font-medium text-gray-700 mb-2">Max Percentage</label>
                        <input type="number" name="max_percentage" id="max_percentage" 
                               value="{{ $maxPercentage ?? 100 }}" 
                               min="0" max="100" step="1" placeholder="100"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Availability</label>
                        <div class="flex space-x-4">
                            @php
                                $selectedAvailability = is_array(request('availability')) ? request('availability') : ['available', 'unavailable'];
                            @endphp
                            <label class="flex items-center">
                                <input type="checkbox" name="availability[]" value="available" 
                                       {{ in_array('available', $selectedAvailability) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                                <span class="text-sm text-gray-700">Available</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="availability[]" value="unavailable" 
                                       {{ in_array('unavailable', $selectedAvailability) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                                <span class="text-sm text-gray-700">Out of Stock</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Fourth Row: Sort Options and Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select name="sort_by" id="sort_by" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="price" {{ $sortBy == 'price' ? 'selected' : '' }}>Price</option>
                            <option value="weight" {{ $sortBy == 'weight' ? 'selected' : '' }}>Weight</option>
                            <option value="percentage" {{ $sortBy == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="rating" {{ $sortBy == 'rating' ? 'selected' : '' }}>Rating</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="sort_direction" class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                        <select name="sort_direction" id="sort_direction" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="asc" {{ $sortDirection == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ $sortDirection == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors font-medium">
                            Apply Filters
                        </button>
                        <a href="{{ route('menu') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                            Clear All
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Info and Active Filters -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">
                        @if(request()->hasAny(['search', 'category', 'subcategory', 'min_price', 'max_price', 'weights', 'min_percentage', 'max_percentage', 'availability']))
                            Search Results
                        @else
                            All Products
                        @endif
                    </h3>
                    <p class="text-sm text-gray-600">
                        @php
                            $totalProducts = $categories->sum(function($category) {
                                return $category->products->count();
                            }) + $uncategorizedProducts->count();
                        @endphp
                        Showing {{ $totalProducts }} {{ Str::plural('product', $totalProducts) }}
                        @if(request('search'))
                            for "{{ request('search') }}"
                        @endif
                    </p>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request()->hasAny(['search', 'category', 'subcategory', 'min_price', 'max_price', 'weights', 'min_percentage', 'max_percentage']))
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Active Filters:</h4>
                    <div class="flex flex-wrap gap-2">
                        @if(request('search'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Search: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request('category'))
                            @php $selectedCategory = $allCategories->find(request('category')); @endphp
                            @if($selectedCategory)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Category: {{ $selectedCategory->name }}
                                </span>
                            @endif
                        @endif
                        @if(request('subcategory'))
                            @php $selectedSubcategory = $allSubcategories->find(request('subcategory')); @endphp
                            @if($selectedSubcategory)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Subcategory: {{ $selectedSubcategory->name }}
                                </span>
                            @endif
                        @endif
                        @if(request('min_price') || request('max_price'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Price: ${{ request('min_price', '0') }} - ${{ request('max_price', '∞') }}
                            </span>
                        @endif
                        @if(request('weights'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Weight filters applied
                            </span>
                        @endif
                        @if(request('min_percentage') || request('max_percentage'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Percentage: {{ request('min_percentage', '0') }}% - {{ request('max_percentage', '100') }}%
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Categories with Products -->
        @if($categories->count() > 0)
            @foreach($categories as $category)
                @if($category->products->count() > 0)
                    <div class="mb-16">
                        <!-- Category Header -->
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
                            <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
                        </div>

                        <!-- Products Grid/List -->
                        @if($viewMode === 'list')
                            <!-- List View -->
                            <div class="space-y-4">
                                @foreach($category->products as $product)
                                    <a href="{{ route('product.show', $product) }}" class="block">
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 {{ !$product->is_available ? 'opacity-75' : '' }}">
                                            <div class="flex">
                                                <!-- Product Image -->
                                                <div class="relative w-48 h-32 flex-shrink-0">
                                                    @if($product->image_path)
                                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                                                    @else
                                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                                            <div class="text-center">
                                                                <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                                <p class="text-gray-500 text-xs">No Image</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Out of Stock Banner -->
                                                    @if(!$product->is_available)
                                                        <div class="absolute top-0 right-0 bg-red-600 text-white px-2 py-1 text-xs font-semibold rounded-bl-lg">
                                                            Out of Stock
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Product Details -->
                                                <div class="flex-1 p-4">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <h3 class="text-lg font-semibold text-gray-900 {{ !$product->is_available ? 'text-gray-500' : '' }}">
                                                            {{ $product->name }}
                                                        </h3>
                                                        <span class="text-xl font-bold {{ $product->is_available ? 'text-green-600' : 'text-gray-400' }}">
                                                            ${{ number_format($product->price, 2) }}
                                                        </span>
                                                    </div>
                                                    
                                                    @if($product->description)
                                                        <p class="text-gray-600 text-sm mb-3 {{ !$product->is_available ? 'text-gray-400' : '' }}">
                                                            {{ $product->description }}
                                                        </p>
                                                    @endif

                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                            <!-- Weight -->
                                                            @if($product->weight)
                                                                <span>Weight: {{ $product->formatted_weight }}</span>
                                                            @endif

                                                            <!-- Percentage -->
                                                            @if($product->percentage)
                                                                <span>{{ $product->formatted_percentage }}</span>
                                                            @endif

                                                            <!-- Rating -->
                                                            @if($product->ratings_count > 0)
                                                                <div class="flex items-center">
                                                                    <div class="flex items-center">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            @if($i <= $product->average_rating)
                                                                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                                </svg>
                                                                            @else
                                                                                <svg class="w-3 h-3 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                                </svg>
                                                                            @endif
                                                                        @endfor
                                                                    </div>
                                                                    <span class="text-xs text-gray-600 ml-1">
                                                                        {{ number_format($product->average_rating, 1) }} ({{ $product->ratings_count }})
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <div>
                                                            @if($product->is_available)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    Available
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                    Unavailable
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <!-- Grid View -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach($category->products as $product)
                                    <a href="{{ route('product.show', $product) }}" class="block">
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 {{ !$product->is_available ? 'opacity-75' : '' }}">
                                            <!-- Product Image -->
                                            <div class="relative">
                                                @if($product->image_path)
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                                                @else
                                                    <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                                        <div class="text-center">
                                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <p class="text-gray-500 text-xs">No Image</p>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                <!-- Out of Stock Banner -->
                                                @if(!$product->is_available)
                                                    <div class="absolute top-0 right-0 bg-red-600 text-white px-3 py-1 text-sm font-semibold rounded-bl-lg">
                                                        Out of Stock
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Product Details -->
                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2 {{ !$product->is_available ? 'text-gray-500' : '' }}">
                                                    {{ $product->name }}
                                                </h3>
                                                
                                                @if($product->description)
                                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2 {{ !$product->is_available ? 'text-gray-400' : '' }}">
                                                        {{ $product->description }}
                                                    </p>
                                                @endif

                                                <!-- Weight -->
                                                @if($product->weight)
                                                    <p class="text-gray-500 text-xs mb-1">
                                                        Weight: {{ $product->formatted_weight }}
                                                    </p>
                                                @endif

                                                <!-- Percentage -->
                                                @if($product->percentage)
                                                    <p class="text-gray-500 text-xs mb-2">
                                                        Percentage: {{ $product->formatted_percentage }}
                                                    </p>
                                                @endif

                                                <!-- Rating -->
                                                @if($product->ratings_count > 0)
                                                    <div class="flex items-center mb-2">
                                                        <div class="flex items-center">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $product->average_rating)
                                                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="text-sm text-gray-600 ml-2">
                                                            {{ number_format($product->average_rating, 1) }} ({{ $product->ratings_count }})
                                                        </span>
                                                    </div>
                                                @endif

                                                <div class="flex items-center justify-between">
                                                    <span class="text-2xl font-bold {{ $product->is_available ? 'text-green-600' : 'text-gray-400' }}">
                                                        ${{ number_format($product->price, 2) }}
                                                    </span>
                                                    
                                                    @if($product->is_available)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Available
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Unavailable
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        @endif

        <!-- Uncategorized Products -->
        @if($uncategorizedProducts->count() > 0)
            <div class="mb-16">
                <!-- Section Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Other Items</h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
                </div>

                <!-- Products Grid/List -->
                @if($viewMode === 'list')
                    <!-- List View -->
                    <div class="space-y-4">
                        @foreach($uncategorizedProducts as $product)
                            <a href="{{ route('product.show', $product) }}" class="block">
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 {{ !$product->is_available ? 'opacity-75' : '' }}">
                                    <div class="flex">
                                        <!-- Product Image -->
                                        <div class="relative w-48 h-32 flex-shrink-0">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                                    <div class="text-center">
                                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <p class="text-gray-500 text-xs">No Image</p>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Out of Stock Banner -->
                                            @if(!$product->is_available)
                                                <div class="absolute top-0 right-0 bg-red-600 text-white px-2 py-1 text-xs font-semibold rounded-bl-lg">
                                                    Out of Stock
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="text-lg font-semibold text-gray-900 {{ !$product->is_available ? 'text-gray-500' : '' }}">
                                                    {{ $product->name }}
                                                </h3>
                                                <span class="text-xl font-bold {{ $product->is_available ? 'text-green-600' : 'text-gray-400' }}">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                            </div>
                                            
                                            @if($product->description)
                                                <p class="text-gray-600 text-sm mb-3 {{ !$product->is_available ? 'text-gray-400' : '' }}">
                                                    {{ $product->description }}
                                                </p>
                                            @endif

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                    <!-- Weight -->
                                                    @if($product->weight)
                                                        <span>Weight: {{ $product->formatted_weight }}</span>
                                                    @endif

                                                    <!-- Percentage -->
                                                    @if($product->percentage)
                                                        <span>{{ $product->formatted_percentage }}</span>
                                                    @endif
                                                </div>
                                                
                                                <div>
                                                    @if($product->is_available)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Available
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Unavailable
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <!-- Grid View -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($uncategorizedProducts as $product)
                            <a href="{{ route('product.show', $product) }}" class="block">
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 {{ !$product->is_available ? 'opacity-75' : '' }}">
                                    <!-- Product Image -->
                                    <div class="relative">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                                <div class="text-center">
                                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <p class="text-gray-500 text-xs">No Image</p>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Out of Stock Banner -->
                                        @if(!$product->is_available)
                                            <div class="absolute top-0 right-0 bg-red-600 text-white px-3 py-1 text-sm font-semibold rounded-bl-lg">
                                                Out of Stock
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2 {{ !$product->is_available ? 'text-gray-500' : '' }}">
                                            {{ $product->name }}
                                        </h3>
                                        
                                        @if($product->description)
                                            <p class="text-gray-600 text-sm mb-3 line-clamp-2 {{ !$product->is_available ? 'text-gray-400' : '' }}">
                                                {{ $product->description }}
                                            </p>
                                        @endif

                                        <!-- Weight -->
                                        @if($product->weight)
                                            <p class="text-gray-500 text-xs mb-1">
                                                Weight: {{ $product->formatted_weight }}
                                            </p>
                                        @endif

                                        <!-- Percentage -->
                                        @if($product->percentage)
                                            <p class="text-gray-500 text-xs mb-2">
                                                Percentage: {{ $product->formatted_percentage }}
                                            </p>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <span class="text-2xl font-bold {{ $product->is_available ? 'text-green-600' : 'text-gray-400' }}">
                                                ${{ number_format($product->price, 2) }}
                                            </span>
                                            
                                            @if($product->is_available)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Available
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Unavailable
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- Empty State -->
        @if($categories->where('products', '!=', '[]')->count() === 0 && $uncategorizedProducts->count() === 0)
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-full w-full">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No products available</h3>
                <p class="mt-2 text-sm text-gray-500">
                    We're working on adding new products to our menu. Please check back soon!
                </p>
            </div>
        @endif

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-sm text-gray-300">
                    &copy; {{ date('Y') }} {{ config('app.name', 'SecureCMS') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for enhanced filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            const searchInput = document.getElementById('search');
            const form = document.querySelector('#filter-panel form');
            const minPriceSlider = document.getElementById('min_price_slider');
            const maxPriceSlider = document.getElementById('max_price_slider');
            const minPriceDisplay = document.getElementById('min_price_display');
            const maxPriceDisplay = document.getElementById('max_price_display');
            const sliderTrack = document.getElementById('slider-track');
            const filterToggle = document.getElementById('filter-toggle');
            const filterPanel = document.getElementById('filter-panel');
            
            // Store all subcategories
            const allSubcategories = @json($allSubcategories);
            
            // Filter panel toggle
            filterToggle.addEventListener('click', function() {
                filterPanel.classList.toggle('hidden');
            });
            
            // Update subcategories when category changes
            if (categorySelect && subcategorySelect) {
                categorySelect.addEventListener('change', function() {
                    const selectedCategoryId = this.value;
                    const filteredSubcategories = selectedCategoryId ? 
                        allSubcategories.filter(sub => sub.category_id == selectedCategoryId) : 
                        allSubcategories;
                    
                    // Clear and repopulate subcategory options
                    subcategorySelect.innerHTML = '<option value="">All Subcategories</option>';
                    filteredSubcategories.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name;
                        subcategorySelect.appendChild(option);
                    });
                });
            }
            
            // Dual range slider functionality
            if (minPriceSlider && maxPriceSlider && sliderTrack) {
                const minRange = parseFloat(minPriceSlider.min);
                const maxRange = parseFloat(minPriceSlider.max);
                
                function updateSlider() {
                    const minValue = parseFloat(minPriceSlider.value);
                    const maxValue = parseFloat(maxPriceSlider.value);
                    
                    // Ensure min is never greater than max
                    if (minValue > maxValue) {
                        minPriceSlider.value = maxValue;
                    }
                    
                    if (maxValue < minValue) {
                        maxPriceSlider.value = minValue;
                    }
                    
                    // Update displays
                    minPriceDisplay.textContent = minPriceSlider.value;
                    maxPriceDisplay.textContent = maxPriceSlider.value;
                    
                    // Update visual track
                    const percentMin = ((minPriceSlider.value - minRange) / (maxRange - minRange)) * 100;
                    const percentMax = ((maxPriceSlider.value - minRange) / (maxRange - minRange)) * 100;
                    
                    sliderTrack.style.left = percentMin + '%';
                    sliderTrack.style.width = (percentMax - percentMin) + '%';
                }
                
                minPriceSlider.addEventListener('input', updateSlider);
                maxPriceSlider.addEventListener('input', updateSlider);
                
                // Initialize slider
                updateSlider();
                
                // Auto-submit form when price sliders change
                minPriceSlider.addEventListener('change', function() {
                    if (form) form.submit();
                });
                maxPriceSlider.addEventListener('change', function() {
                    if (form) form.submit();
                });
            }
            
            // Auto-submit form on search input with debounce
            if (searchInput && form) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        form.submit();
                    }, 500);
                });
            }
            
            // Auto-submit form on select changes
            if (form) {
                const selects = form.querySelectorAll('select');
                selects.forEach(select => {
                    select.addEventListener('change', function() {
                        form.submit();
                    });
                });
                
                // Auto-submit form on checkbox changes
                const checkboxes = form.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        form.submit();
                    });
                });
            }
            
            // Keyboard shortcut for search (Ctrl+K)
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'k') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });
            
            // Focus search input if it has a value
            if (searchInput && searchInput.value) {
                searchInput.focus();
            }
        });
    </script>
</body>
</html>
