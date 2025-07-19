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
                            <div class="mb-6 bg-gray-700/50 rounded-lg p-4 border border-gray-600">
                                <h3 class="text-lg font-semibold text-white mb-3">Customer Rating</h3>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex items-center mr-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-6 h-6 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-500' }} drop-shadow-sm" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <div class="text-xl font-bold text-yellow-400 mr-2">{{ number_format($product->average_rating, 1) }}</div>
                                        <div class="text-gray-400 text-sm">out of 5</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-white font-medium">{{ $product->ratings->count() }}</div>
                                        <div class="text-gray-400 text-sm">{{ $product->ratings->count() === 1 ? 'review' : 'reviews' }}</div>
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
                    @if($userReview || $userRating)
                        <h3 class="text-xl font-semibold text-white mb-6">Edit Your Review</h3>
                        <div class="bg-blue-900/30 border border-blue-600/50 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-blue-300 text-sm">You've already reviewed this product. You can update your review below.</span>
                            </div>
                        </div>
                    @else
                        <h3 class="text-xl font-semibold text-white mb-6">Leave a Review</h3>
                    @endif
                    
                    <form method="POST" action="{{ route('product.comment', $product) }}">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-3">Your Rating *</label>
                            <div class="flex items-center space-x-1 mb-2" id="rating-container">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $i }}" class="hidden" 
                                           {{ ($userRating && $userRating->rating == $i) ? 'checked' : '' }} required>
                                    <label for="rating-{{ $i }}" class="star-rating cursor-pointer transition-all duration-200 hover:scale-110 focus:scale-110 focus:outline-none" tabindex="0">
                                        <svg class="w-8 h-8 {{ ($userRating && $i <= $userRating->rating) ? 'text-yellow-400' : 'text-gray-500' }} hover:text-yellow-400 transition-colors duration-200 drop-shadow-sm" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-400">Click to select your rating (1 = Poor, 5 = Excellent)</p>
                            <div id="rating-feedback" class="text-sm font-medium mt-2 opacity-0 transition-opacity duration-200"></div>
                        </div>
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-300 mb-2">Your Review</label>
                            <textarea id="comment" name="comment" rows="5" 
                                      class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors resize-vertical"
                                      placeholder="Share your experience with this product...">{{ $userReview ? $userReview->comment : '' }}</textarea>
                        </div>
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-md font-medium transition-all duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                            {{ ($userReview || $userRating) ? 'Update Review' : 'Submit Review' }}
                        </button>
                    </form>
                </div>
            @endauth

            <!-- Rating Overview and Filters -->
            @if($ratingStats['total'] > 0)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-6">Rating Overview</h3>
                    
                    <div class="grid md:grid-cols-2 gap-8 mb-6">
                        <!-- Rating Summary -->
                        <div class="text-center">
                            <div class="text-4xl font-bold text-yellow-400 mb-2">{{ $ratingStats['average'] }}</div>
                            <div class="flex items-center justify-center mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $ratingStats['average'] ? 'text-yellow-400' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <div class="text-gray-400">Based on {{ $ratingStats['total'] }} {{ $ratingStats['total'] === 1 ? 'review' : 'reviews' }}</div>
                        </div>
                        
                        <!-- Rating Distribution -->
                        <div class="space-y-2">
                            @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-300 w-2">{{ $i }}</span>
                                    <svg class="w-4 h-4 text-yellow-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <div class="flex-1 mx-3">
                                        <div class="bg-gray-700 rounded-full h-2 overflow-hidden">
                                            <div class="bg-yellow-400 h-full transition-all duration-500" style="width: {{ $ratingStats['percentages'][$i] }}%"></div>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-400 w-12 text-right">{{ $ratingStats['distribution'][$i] }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap gap-4 pt-6 border-t border-gray-700">
                        <div class="flex items-center space-x-2">
                            <label for="rating-filter" class="text-sm text-gray-300">Filter by rating:</label>
                            <select id="rating-filter" class="bg-gray-700 border border-gray-600 rounded px-3 py-1 text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="all" {{ $ratingFilter === 'all' ? 'selected' : '' }}>All ratings</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ $ratingFilter == $i ? 'selected' : '' }}>
                                        {{ $i }} star{{ $i > 1 ? 's' : '' }} ({{ $ratingStats['distribution'][$i] }})
                                    </option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <label for="sort-by" class="text-sm text-gray-300">Sort by:</label>
                            <select id="sort-by" class="bg-gray-700 border border-gray-600 rounded px-3 py-1 text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Newest first</option>
                                <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                                <option value="highest_rated" {{ $sortBy === 'highest_rated' ? 'selected' : '' }}>Highest rated</option>
                                <option value="lowest_rated" {{ $sortBy === 'lowest_rated' ? 'selected' : '' }}>Lowest rated</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Customer Reviews -->
            @if($comments && $comments->count() > 0)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-6">Customer Reviews ({{ $comments->total() }})</h3>
                    <div class="space-y-6">
                        @foreach($comments as $comment)
                            <div class="bg-gray-700/30 rounded-lg p-6 border border-gray-600/50 hover:border-gray-600 transition-colors duration-200">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-12 h-12 bg-purple-600 rounded-full mr-4">
                                            <span class="text-white font-semibold">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white">{{ $comment->user->name }}</h4>
                                            @if($comment->rating_value)
                                                <div class="flex items-center mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $comment->rating_value ? 'text-yellow-400' : 'text-gray-500' }} drop-shadow-sm" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endfor
                                                    <span class="ml-2 text-yellow-400 font-medium text-sm">{{ $comment->rating_value }}/5</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                                        @if($comment->updated_at != $comment->created_at)
                                            <div class="text-gray-500 text-xs">Updated {{ $comment->updated_at->diffForHumans() }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="pl-16">
                                    <p class="text-gray-300 leading-relaxed">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($comments->hasPages())
                        <div class="mt-8">
                            {{ $comments->appends(request()->query())->links('pagination.custom') }}
                        </div>
                    @endif
                </div>
            @elseif($ratingStats['total'] == 0)
                <div class="bg-gray-800 rounded-lg shadow-lg p-8 mb-8 border border-gray-700 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.13 8.13 0 01-2.939-.542l-3.462 3.462A2 2 0 015.16 21H3a1 1 0 01-1-1v-2.16a2 2 0 01.586-1.414l3.462-3.462A8.13 8.13 0 015 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">No Reviews Yet</h3>
                    <p class="text-gray-400">Be the first to leave a review for this product!</p>
                </div>
            @endif

            <!-- Related Products -->
            @if($relatedProducts && $relatedProducts->count() > 0)
                <div class="bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-6">Related Products</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="bg-gray-700/50 rounded-lg overflow-hidden border border-gray-600/50 hover:border-purple-500 transition-colors group">
                                <div class="aspect-w-16 aspect-h-9">
                                    @if($relatedProduct->image_path)
                                        <img src="{{ asset('storage/' . $relatedProduct->image_path) }}" 
                                             alt="{{ $relatedProduct->name }}" 
                                             class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-32 bg-gray-600 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-semibold text-white mb-2 line-clamp-1">{{ $relatedProduct->name }}</h4>
                                    
                                    <!-- Category -->
                                    @if($relatedProduct->category)
                                        <div class="mb-2">
                                            <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                                {{ $relatedProduct->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- Rating -->
                                    @if($relatedProduct->ratings && $relatedProduct->ratings->count() > 0)
                                        <div class="flex items-center mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $relatedProduct->average_rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                            <span class="text-xs text-yellow-400 ml-1">{{ number_format($relatedProduct->average_rating, 1) }}</span>
                                            <span class="text-xs text-gray-500 ml-1">({{ $relatedProduct->ratings->count() }})</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Price -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-green-400 font-semibold text-sm">{{ $relatedProduct->price_range }}</span>
                                        <a href="{{ route('product.show', $relatedProduct) }}" 
                                           class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <style>
        /* Custom line clamp utilities */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Custom pagination styling */
        .pagination-wrapper .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.25rem;
        }
        
        .pagination-wrapper .pagination .page-item {
            display: inline-block;
        }
        
        .pagination-wrapper .pagination .page-link {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            background-color: #374151;
            color: #e5e7eb;
            border: 1px solid #4b5563;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .pagination-wrapper .pagination .page-link:hover {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
            color: white;
        }
        
        .pagination-wrapper .pagination .page-item.active .page-link {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
            color: white;
        }
        
        .pagination-wrapper .pagination .page-item.disabled .page-link {
            background-color: #1f2937;
            color: #6b7280;
            border-color: #374151;
            cursor: not-allowed;
        }
    </style>
    
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
            const ratingFeedback = document.getElementById('rating-feedback');
            
            const ratingLabels = {
                1: 'Poor',
                2: 'Fair', 
                3: 'Good',
                4: 'Very Good',
                5: 'Excellent'
            };
            
            // Initialize with existing rating if present
            let selectedRating = 0;
            const checkedRating = document.querySelector('input[name="rating"]:checked');
            if (checkedRating) {
                selectedRating = parseInt(checkedRating.value);
                updateStarDisplay(selectedRating);
                updateFeedback(selectedRating);
            }
            
            stars.forEach((star, index) => {
                const ratingValue = index + 1;
                
                // Handle click events
                star.addEventListener('click', function() {
                    selectedRating = ratingValue;
                    ratingInputs[index].checked = true;
                    updateStarDisplay(ratingValue);
                    updateFeedback(ratingValue);
                });
                
                // Handle keyboard events
                star.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
                
                // Handle hover events
                star.addEventListener('mouseenter', function() {
                    if (selectedRating === 0) {
                        updateStarDisplay(ratingValue, true);
                        updateFeedback(ratingValue, true);
                    }
                });
                
                star.addEventListener('mouseleave', function() {
                    if (selectedRating === 0) {
                        updateStarDisplay(0);
                        updateFeedback(0);
                    } else {
                        updateStarDisplay(selectedRating);
                        updateFeedback(selectedRating);
                    }
                });
            });
            
            function updateStarDisplay(rating, isHover = false) {
                stars.forEach((star, index) => {
                    const svg = star.querySelector('svg');
                    if (index < rating) {
                        svg.classList.remove('text-gray-500');
                        svg.classList.add('text-yellow-400');
                        if (isHover) {
                            svg.classList.add('scale-110');
                        } else {
                            svg.classList.remove('scale-110');
                        }
                    } else {
                        svg.classList.remove('text-yellow-400', 'scale-110');
                        svg.classList.add('text-gray-500');
                    }
                });
            }
            
            function updateFeedback(rating, isHover = false) {
                if (rating > 0) {
                    ratingFeedback.textContent = `${rating}/5 - ${ratingLabels[rating]}`;
                    ratingFeedback.className = `text-sm font-medium mt-2 transition-opacity duration-200 opacity-100 ${isHover ? 'text-gray-300' : 'text-yellow-400'}`;
                } else {
                    ratingFeedback.className = 'text-sm font-medium mt-2 opacity-0 transition-opacity duration-200';
                }
            }

            // Filter functionality
            const ratingFilter = document.getElementById('rating-filter');
            const sortBy = document.getElementById('sort-by');
            
            if (ratingFilter) {
                ratingFilter.addEventListener('change', function() {
                    updateFilters();
                });
            }
            
            if (sortBy) {
                sortBy.addEventListener('change', function() {
                    updateFilters();
                });
            }
            
            function updateFilters() {
                const url = new URL(window.location);
                url.searchParams.set('rating_filter', ratingFilter.value);
                url.searchParams.set('sort_by', sortBy.value);
                url.searchParams.delete('page'); // Reset to first page
                window.location.href = url.toString();
            }
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
