<x-public-layout title="My Wishlist">
    <div class="page-transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-white">My Wishlist</h1>
                <a href="{{ route('menu') }}" class="text-purple-primary hover:text-purple-light font-medium hover-lift">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Menu
                    </div>
                </a>
            </div>

            @if($wishlists->count() > 0)
                <div class="card-purple rounded-lg shadow-lg overflow-hidden">
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
                                    <tr class="hover:bg-gray-700 transition-colors">
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
                                                        <a href="{{ route('product.show', $wishlist->product) }}" class="hover:text-purple-primary transition-colors">
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
                                                   class="text-purple-primary hover:text-purple-light transition-colors">View</a>
                                                <button onclick="removeFromWishlist({{ $wishlist->id }}, this)" 
                                                        class="text-red-400 hover:text-red-300 transition-colors">Remove</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Wishlist Summary -->
                <div class="mt-8 card-purple rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-purple-primary mb-2">Wishlist Summary</h3>
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
                    <a href="{{ route('menu') }}" class="btn-purple hover-lift">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Browse Products
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
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
                    const wishlistCountMobile = document.getElementById('wishlist-count-mobile');
                    if (wishlistCount) {
                        if (data.wishlist_count > 0) {
                            wishlistCount.textContent = data.wishlist_count;
                            wishlistCount.classList.remove('hidden');
                        } else {
                            wishlistCount.classList.add('hidden');
                        }
                    }
                    if (wishlistCountMobile) {
                        if (data.wishlist_count > 0) {
                            wishlistCountMobile.textContent = data.wishlist_count;
                            wishlistCountMobile.classList.remove('hidden');
                        } else {
                            wishlistCountMobile.classList.add('hidden');
                        }
                    }
                    
                    // Show success notification
                    if (typeof showNotification === 'function') {
                        showNotification('Item removed from wishlist', 'success');
                    }
                    
                    // Refresh page if no items left
                    if (document.querySelectorAll('tbody tr').length === 0) {
                        location.reload();
                    }
                } else {
                    button.disabled = false;
                    button.textContent = 'Remove';
                    if (typeof showNotification === 'function') {
                        showNotification(data.message || 'Failed to remove item', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                button.textContent = 'Remove';
                if (typeof showNotification === 'function') {
                    showNotification('An error occurred. Please try again.', 'error');
                }
            });
        }
    </script>
    @endpush
</x-public-layout>
