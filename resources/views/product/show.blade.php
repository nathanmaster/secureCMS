<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $product->name }} - {{ config('app.name', 'Laravel') }}</title>

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
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Back to Menu Button -->
            <div class="mb-6">
                <a href="{{ route('menu') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Menu
                </a>
            </div>

            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden {{ !$product->is_available ? 'opacity-75' : '' }}">
                <div class="md:flex">
                    <!-- Product Image -->
                    <div class="md:w-1/2 relative">
                        @if($product->hasImage())
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                        @else
                            <div class="w-full h-96 bg-gray-200 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Out of Stock Banner -->
                        @if(!$product->is_available)
                            <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Out of Stock
                            </div>
                        @endif
                    </div>

                    <!-- Product Information -->
                    <div class="md:w-1/2 p-8">
                        <div class="mb-4">
                            @if($product->category)
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full uppercase tracking-wide font-semibold">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        
                        <div class="text-2xl font-bold text-green-600 mb-6">
                            ${{ number_format($product->price, 2) }}
                        </div>

                        @if($product->description)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                            </div>
                        @endif

                        <!-- Availability Status -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Availability</h3>
                            @if($product->is_available)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Available
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4">
                            @if($product->is_available)
                                <button class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors font-medium">
                                    Add to Cart
                                </button>
                            @else
                                <button class="bg-gray-400 text-white px-6 py-3 rounded-md cursor-not-allowed font-medium" disabled>
                                    Unavailable
                                </button>
                            @endif
                            
                            <button class="border border-gray-300 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-50 transition-colors font-medium">
                                Share
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products (if same category) -->
            @if($product->category)
                @php
                    $relatedProducts = $product->category->products()
                        ->where('id', '!=', $product->id)
                        ->take(4)
                        ->get();
                @endphp
                
                @if($relatedProducts->count() > 0)
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($relatedProducts as $relatedProduct)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow {{ !$relatedProduct->is_available ? 'opacity-75' : '' }}">
                                    <div class="relative">
                                        @if($relatedProduct->hasImage())
                                            <img src="{{ $relatedProduct->image_url }}" 
                                                 alt="{{ $relatedProduct->name }}" 
                                                 class="w-full h-48 object-cover {{ !$relatedProduct->is_available ? 'grayscale' : '' }}">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center {{ !$relatedProduct->is_available ? 'grayscale' : '' }}">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        @if(!$relatedProduct->is_available)
                                            <div class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded-full text-xs font-medium">
                                                Out of Stock
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                                        <p class="text-green-600 font-bold">${{ number_format($relatedProduct->price, 2) }}</p>
                                        <div class="mt-3">
                                            <a href="{{ route('product.show', $relatedProduct) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View Details →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

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
