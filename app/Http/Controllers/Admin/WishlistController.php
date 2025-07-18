<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $query = Wishlist::with(['user', 'product']);
        
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by user name, email, or product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('product', function ($productQuery) use ($search) {
                    $productQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        $wishlists = $query->latest()->paginate(20);
        
        return view('admin.wishlists.index', compact('wishlists'));
    }
    
    public function show(Wishlist $wishlist)
    {
        $wishlist->load(['user', 'product']);
        return view('admin.wishlists.show', compact('wishlist'));
    }
    
    public function markContacted(Wishlist $wishlist)
    {
        $wishlist->update([
            'status' => 'contacted',
            'contacted_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Wishlist marked as contacted.');
    }
    
    public function markCompleted(Wishlist $wishlist)
    {
        $wishlist->update([
            'status' => 'completed'
        ]);
        
        return redirect()->back()->with('success', 'Wishlist marked as completed.');
    }
    
    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        
        return redirect()->route('admin.wishlists.index')->with('success', 'Wishlist deleted successfully.');
    }
}
