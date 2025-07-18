<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Wishlist Details') }}
            </h2>
            <a href="{{ route('admin.wishlists.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Wishlists
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-gray-100">Customer Information</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Name:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->user->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Email:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">
                                        <a href="mailto:{{ $wishlist->user->email }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            {{ $wishlist->user->email }}
                                        </a>
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Phone:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">
                                        @if($wishlist->phone_number || $wishlist->user->phone_number)
                                            <a href="tel:{{ $wishlist->phone_number ?: $wishlist->user->phone_number }}" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $wishlist->phone_number ?: $wishlist->user->phone_number }}
                                            </a>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">Not provided</span>
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Member Since:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->user->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-gray-100">Product Details</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Product:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->product->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Selected Weight:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->selected_weight }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Price:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">${{ number_format($wishlist->selected_price, 2) }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Category:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->product->category->name ?? 'N/A' }}</span>
                                </div>
                                @if($wishlist->product->subcategory)
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Subcategory:</span>
                                        <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->product->subcategory->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist Information -->
                    <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-gray-100">Wishlist Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $wishlist->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($wishlist->status === 'contacted' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($wishlist->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Added On:</span>
                                <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->created_at->format('M j, Y \a\t g:i A') }}</span>
                            </div>
                            @if($wishlist->contacted_at)
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Contacted On:</span>
                                    <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $wishlist->contacted_at->format('M j, Y \a\t g:i A') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        @if($wishlist->notes)
                            <div class="mt-4">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Notes:</span>
                                <div class="mt-2 p-3 bg-white dark:bg-gray-800 rounded border">
                                    <p class="text-gray-900 dark:text-gray-100">{{ $wishlist->notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex flex-wrap gap-3">
                        @if($wishlist->status === 'pending')
                            <form method="POST" action="{{ route('admin.wishlists.mark-contacted', $wishlist) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Mark as Contacted
                                </button>
                            </form>
                        @endif
                        
                        @if($wishlist->status === 'contacted')
                            <form method="POST" action="{{ route('admin.wishlists.mark-completed', $wishlist) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Mark as Completed
                                </button>
                            </form>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.wishlists.destroy', $wishlist) }}" 
                              class="inline" onsubmit="return confirm('Are you sure you want to delete this wishlist item? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Wishlist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
