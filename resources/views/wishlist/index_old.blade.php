<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SecureCMS') }} - My Wishlist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="bg-gray-800 shadow-lg sticky top-0 z-50 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('menu') }}" class="text-xl font-bold text-white">
                        {{ config('app.name', 'SecureCMS') }}
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('menu') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Menu
                    </a>
                    @auth
                        <!-- Wishlist -->
                        <a href="{{ route('wishlist.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors relative">
                            <div class="flex items-center">
                                Wishlist
                                <span id="wishlist-count" class="ml-1 bg-purple-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ auth()->user()->wishlist_count > 0 ? '' : 'hidden' }}">
                                    {{ auth()->user()->wishlist_count }}
                                </span>
                            </div>
                        </a>
                        
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Admin Dashboard
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-white">My Wishlist</h1>
            <a href="{{ route('menu') }}" class="text-purple-400 hover:text-purple-300 font-medium">
                ← Back to Menu
            </a>
        </div>

    @if($wishlists->count() > 0)
        <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Weight</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Added</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @foreach($wishlists as $wishlist)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            @if($wishlist->product->image_path)
                                                <img src="{{ asset('storage/' . $wishlist->product->image_path) }}" 
                                                     alt="{{ $wishlist->product->name }}" 
                                                     class="h-16 w-16 rounded-lg object-cover">
                                            @else
                                                <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-white">
                                                <a href="{{ route('product.show', $wishlist->product) }}" class="hover:text-purple-400">
                                                    {{ $wishlist->product->name }}
                                                </a>
                                            </div>
                                            <div class="text-sm text-gray-400">
                                                {{ $wishlist->product->description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $wishlist->selected_weight ?: 'Default' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-400">
                                    @if($wishlist->selected_price)
                                        ${{ number_format($wishlist->selected_price, 2) }}
                                    @else
                                        {{ $wishlist->product->display_price }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($wishlist->status === 'pending') bg-yellow-900 text-yellow-300
                                        @elseif($wishlist->status === 'contacted') bg-blue-900 text-blue-300
                                        @else bg-green-900 text-green-300
                                        @endif">
                                        {{ $wishlist->formatted_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ $wishlist->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('product.show', $wishlist->product) }}" 
                                           class="text-purple-400 hover:text-purple-300">View</a>
                                        <button onclick="removeFromWishlist({{ $wishlist->id }}, this)" 
                                                class="text-red-400 hover:text-red-300">Remove</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Wishlist Summary -->
        <div class="mt-8 bg-purple-900 rounded-lg p-6 border border-purple-700">
            <h3 class="text-lg font-semibold text-purple-100 mb-2">Wishlist Summary</h3>
            <p class="text-purple-200">
                You have {{ $wishlists->count() }} {{ Str::plural('item', $wishlists->count()) }} in your wishlist.
                @if($wishlists->where('status', 'pending')->count() > 0)
                    {{ $wishlists->where('status', 'pending')->count() }} are pending review.
                @endif
            </p>
            <p class="text-sm text-purple-300 mt-2">
                Our team will review your wishlist and contact you about availability and pricing.
            </p>
        </div>
    @else
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-white mb-2">Your wishlist is empty</h3>
            <p class="text-gray-400 mb-6">Start browsing our products to add items to your wishlist.</p>
            <a href="{{ route('menu') }}" class="bg-purple-600 text-white px-6 py-3 rounded-md font-medium hover:bg-purple-700 transition-colors">
                Browse Products
            </a>
        </div>
    @endif
</div>

<script>
function removeFromWishlist(wishlistId, button) {
    if (!confirm('Are you sure you want to remove this item from your wishlist?')) {
        return;
    }
    
    button.disabled = true;
    button.textContent = 'Removing...';
    
    fetch(`/wishlist/${wishlistId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the row from the table
            button.closest('tr').remove();
            
            // Update wishlist count in navbar if present
            const wishlistCount = document.getElementById('wishlist-count');
            if (wishlistCount) {
                wishlistCount.textContent = data.wishlist_count;
                if (data.wishlist_count === 0) {
                    wishlistCount.classList.add('hidden');
                }
            }
            
            // Show success message
            showNotification(data.message, 'success');
            
            // If no more items, reload the page to show empty state
            if (document.querySelectorAll('tbody tr').length === 0) {
                location.reload();
            }
        } else {
            showNotification(data.message, 'error');
            button.disabled = false;
            button.textContent = 'Remove';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
        button.disabled = false;
        button.textContent = 'Remove';
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-4 py-3 rounded-md shadow-lg z-50 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

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
