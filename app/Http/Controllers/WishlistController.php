<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->latest()->get();
        
        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Add a product to the wishlist.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'selected_weight' => 'nullable|string',
            'selected_price' => 'nullable|numeric',
            'notes' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check if item already exists in wishlist
        $exists = Auth::user()->hasInWishlist($request->product_id, $request->selected_weight);
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This item is already in your wishlist.'
            ], 422);
        }

        $wishlist = Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'selected_weight' => $request->selected_weight,
            'selected_price' => $request->selected_price,
            'notes' => $request->notes,
            'phone_number' => $request->phone_number ?: Auth::user()->phone_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully!',
            'wishlist_count' => Auth::user()->wishlist_count
        ]);
    }

    /**
     * Remove a product from the wishlist.
     */
    public function destroy(Wishlist $wishlist)
    {
        // Ensure the user owns this wishlist item
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist successfully!',
            'wishlist_count' => Auth::user()->wishlist_count
        ]);
    }

    /**
     * Get the current wishlist count for the authenticated user.
     */
    public function getCount()
    {
        $count = auth()->user()->wishlists()->count();
        return response()->json(['count' => $count]);
    }
    
    public function checkProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'weight' => 'required|string'
        ]);
        
        $inWishlist = auth()->user()->wishlists()
            ->where('product_id', $request->product_id)
            ->where('selected_weight', $request->weight)
            ->exists();
            
        return response()->json(['in_wishlist' => $inWishlist]);
    }
}
