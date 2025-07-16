<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Menu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Menu</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover our delicious selection of products, carefully crafted with the finest ingredients.
            </p>
        </div>

        <!-- Categories with Products -->
        @if($categories->count() > 0)
            @foreach($categories as $category)
                @if($category->products->count() > 0)
                    <div class="mb-16">
                        <!-- Category Header -->
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $category->name }}</h2>
                            <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
                        </div>

                        <!-- Products Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($category->products as $product)
                                <a href="{{ route('product.show', $product) }}" class="block">
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 {{ !$product->is_available ? 'opacity-75' : '' }}">
                                        <!-- Product Image -->
                                        <div class="relative">
                                            @if($product->hasImage())
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                                            @else
                                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
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
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2 {{ !$product->is_available ? 'text-gray-500' : '' }}">
                                                {{ $product->name }}
                                            </h3>
                                            
                                            @if($product->description)
                                                <p class="text-gray-600 text-sm mb-3 line-clamp-2 {{ !$product->is_available ? 'text-gray-400' : '' }}">
                                                    {{ $product->description }}
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
                    </div>
                @endif
            @endforeach
        @endif

        <!-- Uncategorized Products -->
        @if($uncategorizedProducts->count() > 0)
            <div class="mb-16">
                <!-- Section Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Other Items</h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($uncategorizedProducts as $product)
                        <a href="{{ route('product.show', $product) }}" class="block">
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 {{ !$product->is_available ? 'opacity-75' : '' }}">
                                <!-- Product Image -->
                                <div class="relative">
                                    @if($product->hasImage())
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
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
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2 {{ !$product->is_available ? 'text-gray-500' : '' }}">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    @if($product->description)
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2 {{ !$product->is_available ? 'text-gray-400' : '' }}">
                                            {{ $product->description }}
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
    </main>

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
</body>
</html>
