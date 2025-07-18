<x-public-layout title="{{ $product->name }}">
    <div class="page-transition">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Back to Menu Button -->
            <div class="mb-6">
                <a href="{{ route('menu') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Menu
                </a>
            </div>

            <!-- Product Details -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700 {{ !$product->is_available ? 'opacity-75' : '' }}">
                <div class="md:flex">
                    <!-- Product Image -->
                    <div class="md:w-2/5 relative">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-80 object-cover {{ !$product->is_available ? 'grayscale' : '' }}">
                        @else
                            <div class="w-full h-80 bg-gray-600 flex items-center justify-center {{ !$product->is_available ? 'grayscale' : '' }}">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-400">No Image Available</p>
                                </div>
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
                    <div class="md:w-3/5 p-8">
                        <div class="mb-4">
                            @if($product->category)
                                <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full uppercase tracking-wide font-semibold">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-bold text-white mb-4">{{ $product->name }}</h1>
                        
                        <!-- Weight Options and Pricing -->
                        @if($product->weightVariants && $product->weightVariants->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-white mb-3">Select Weight & Price</h3>
                                <div class="mb-4">
                                    <select id="weight-selector" class="w-full md:w-auto bg-gray-700 text-white border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        @foreach($product->weightVariants as $variant)
                                            <option value="{{ $variant->id }}" 
                                                    data-price="{{ $variant->price }}"
                                                    class="bg-gray-700 text-white"
                                                    {{ $loop->first ? 'selected' : '' }}>
                                                {{ $variant->effective_label }} - ${{ number_format($variant->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-2xl font-bold text-green-400 mb-4">
                                    $<span id="selected-price">{{ number_format($product->weightVariants->first()->price ?? 0, 2) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-2xl font-bold text-green-400 mb-6">
                                {{ $product->display_price }}
                            </div>
                        @endif

                        <!-- Description -->
                        @if($product->description)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-white mb-2">Description</h3>
                                <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                            </div>
                        @endif

                        <!-- Product Details -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-white mb-2">Details</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                @if($product->category)
                                    <div>
                                        <span class="text-gray-400">Category:</span>
                                        <span class="text-white ml-2">{{ $product->category->name }}</span>
                                    </div>
                                @endif
                                @if($product->subcategory)
                                    <div>
                                        <span class="text-gray-400">Subcategory:</span>
                                        <span class="text-white ml-2">{{ $product->subcategory->name }}</span>
                                    </div>
                                @endif
                                @if($product->percentage)
                                    <div>
                                        <span class="text-gray-400">Percentage:</span>
                                        <span class="text-white ml-2">{{ $product->percentage }}%</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-gray-400">Availability:</span>
                                    <span class="text-white ml-2">{{ $product->is_available ? 'In Stock' : 'Out of Stock' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Average Rating -->
                        @if($product->ratings && $product->ratings->count() > 0)
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <span class="text-gray-400 mr-2">Rating:</span>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-gray-300">{{ number_format($product->average_rating, 1) }} ({{ $product->ratings->count() }} reviews)</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex space-x-4">
                            @auth
                                @if($product->is_available)
                                    <button onclick="addToWishlist({{ $product->id }}, this)" 
                                            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-md font-medium transition-colors flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        Add to Wishlist
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-md font-medium transition-colors">
                                    Login to Add to Wishlist
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments and Ratings Section -->
            @auth
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Leave a Review</h3>
                    <form method="POST" action="{{ route('product.comment', $product) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $i }}" class="hidden">
                                    <label for="rating-{{ $i }}" class="star-rating cursor-pointer">
                                        <svg class="w-6 h-6 text-gray-400 hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-300 mb-2">Comment</label>
                            <textarea id="comment" name="comment" rows="4" 
                                      class="w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Write your review..."></textarea>
                        </div>
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                            Submit Review
                        </button>
                    </form>
                </div>
            @endauth

            <!-- Existing Comments -->
            @if($product->approvedComments && $product->approvedComments->count() > 0)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Customer Reviews</h3>
                    <div class="space-y-4">
                        @foreach($product->approvedComments as $comment)
                            <div class="border-b border-gray-700 pb-4">
                                <div class="flex items-center mb-2">
                                    <span class="font-medium text-white">{{ $comment->user->name }}</span>
                                    @if($comment->rating)
                                        <div class="flex items-center ml-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                    @endif
                                    <span class="text-gray-400 text-sm ml-auto">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-300">{{ $comment->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Handle weight selector changes
        document.addEventListener('DOMContentLoaded', function() {
            const weightSelector = document.getElementById('weight-selector');
            const selectedPriceElement = document.getElementById('selected-price');
            
            if (weightSelector && selectedPriceElement) {
                weightSelector.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.dataset.price;
                    if (price) {
                        selectedPriceElement.textContent = parseFloat(price).toFixed(2);
                    }
                });
            }

            // Star rating functionality
            const stars = document.querySelectorAll('.star-rating');
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            
            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const ratingValue = index + 1;
                    ratingInputs[index].checked = true;
                    
                    // Update star colors
                    stars.forEach((s, i) => {
                        const svg = s.querySelector('svg');
                        if (i < ratingValue) {
                            svg.classList.remove('text-gray-400');
                            svg.classList.add('text-yellow-400');
                        } else {
                            svg.classList.remove('text-yellow-400');
                            svg.classList.add('text-gray-400');
                        }
                    });
                });
            });
        });

        // Wishlist functionality
        function addToWishlist(productId, button) {
            const weightSelector = document.getElementById('weight-selector');
            let selectedWeight = null;
            let selectedPrice = null;
            
            if (weightSelector) {
                const selectedOption = weightSelector.options[weightSelector.selectedIndex];
                selectedWeight = selectedOption.textContent.split(' - ')[0];
                selectedPrice = selectedOption.dataset.price;
            }
            
            button.disabled = true;
            button.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Adding...';
            
            fetch('{{ route('wishlist.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    selected_weight: selectedWeight,
                    selected_price: selectedPrice
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Added to Wishlist';
                    button.classList.remove('bg-purple-600', 'hover:bg-purple-700');
                    button.classList.add('bg-green-600');
                    
                    // Update wishlist count if element exists
                    const wishlistCount = document.getElementById('wishlist-count');
                    if (wishlistCount && data.wishlist_count) {
                        wishlistCount.textContent = data.wishlist_count;
                        wishlistCount.classList.remove('hidden');
                    }
                } else {
                    button.disabled = false;
                    button.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>Add to Wishlist';
                    alert(data.message || 'Failed to add to wishlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                button.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>Add to Wishlist';
                alert('An error occurred. Please try again.');
            });
        }
    </script>
    @endpush
</x-public-layout>
