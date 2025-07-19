<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductRating;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicProductController extends Controller
{
    /**
     * Display the product details page.
     */
    public function show(Product $product, Request $request)
    {
        // Load necessary relationships
        $product->load([
            'category',
            'subcategory',
            'weightVariants' => function ($query) {
                $query->where('is_available', true)->orderBy('price');
            },
            'ratings',
        ]);

        // Get current user's existing review if authenticated
        $userReview = null;
        $userRating = null;
        if (Auth::check()) {
            $userReview = ProductComment::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();
            
            $userRating = ProductRating::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        // Get filter parameters
        $ratingFilter = $request->get('rating_filter', 'all');
        $sortBy = $request->get('sort_by', 'newest');
        $perPage = 5;

        // Build comments query with ratings
        $commentsQuery = $product->approvedComments()
            ->with(['user'])
            ->leftJoin('product_ratings', function($join) use ($product) {
                $join->on('product_comments.user_id', '=', 'product_ratings.user_id')
                     ->where('product_ratings.product_id', '=', $product->id);
            })
            ->select('product_comments.*', 'product_ratings.rating as rating_value');

        // Apply rating filter
        if ($ratingFilter !== 'all') {
            $commentsQuery->where('product_ratings.rating', '=', $ratingFilter);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'oldest':
                $commentsQuery->orderBy('product_comments.created_at', 'asc');
                break;
            case 'highest_rated':
                $commentsQuery->orderByRaw('product_ratings.rating DESC NULLS LAST')
                    ->orderBy('product_comments.created_at', 'desc');
                break;
            case 'lowest_rated':
                $commentsQuery->orderByRaw('product_ratings.rating ASC NULLS LAST')
                    ->orderBy('product_comments.created_at', 'desc');
                break;
            case 'newest':
            default:
                $commentsQuery->orderBy('product_comments.created_at', 'desc');
                break;
        }

        $comments = $commentsQuery->paginate($perPage);

        // Get rating statistics
        $ratingStats = $this->getRatingStatistics($product);

        // Get related products
        $relatedProducts = $this->getRelatedProducts($product);

        return view('product.show', compact(
            'product',
            'comments',
            'userReview',
            'userRating',
            'ratingStats',
            'relatedProducts',
            'ratingFilter',
            'sortBy'
        ));
    }

    /**
     * Store or update a comment and rating for a product.
     */
    public function storeComment(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();

        // Check if user already has a review
        $existingComment = ProductComment::where('product_id', $product->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingComment) {
            // Update existing comment
            $existingComment->update([
                'comment' => $request->comment,
                'is_approved' => false, // Require re-approval for edits
            ]);
            $message = 'Your review has been updated and is pending approval.';
        } else {
            // Create new comment
            ProductComment::create([
                'product_id' => $product->id,
                'user_id' => $userId,
                'comment' => $request->comment,
                'is_approved' => false,
            ]);
            $message = 'Thank you for your review! It will be published after admin approval.';
        }

        // Store or update the rating
        ProductRating::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => $userId,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get rating statistics for a product.
     */
    private function getRatingStatistics(Product $product): array
    {
        $ratings = $product->ratings;
        
        if ($ratings->isEmpty()) {
            return [
                'average' => 0,
                'total' => 0,
                'distribution' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
                'percentages' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
            ];
        }

        $total = $ratings->count();
        $average = $ratings->avg('rating');
        
        // Calculate distribution
        $distribution = [];
        $percentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $ratings->where('rating', $i)->count();
            $distribution[$i] = $count;
            $percentages[$i] = $total > 0 ? round(($count / $total) * 100, 1) : 0;
        }

        return [
            'average' => round($average, 1),
            'total' => $total,
            'distribution' => $distribution,
            'percentages' => $percentages,
        ];
    }

    /**
     * Get related products based on category and subcategory.
     */
    private function getRelatedProducts(Product $product, int $limit = 4): \Illuminate\Database\Eloquent\Collection
    {
        $query = Product::where('id', '!=', $product->id)
            ->where('is_available', true)
            ->with(['category', 'ratings', 'weightVariants']);

        // First try to get products from same subcategory
        if ($product->subcategory_id) {
            $relatedProducts = $query->where('subcategory_id', $product->subcategory_id)
                ->limit($limit)
                ->get();
            
            if ($relatedProducts->count() >= $limit) {
                return $relatedProducts;
            }
        }

        // If not enough from subcategory, get from same category
        if ($product->category_id) {
            $excludeIds = $relatedProducts->pluck('id')->toArray();
            $additionalProducts = $query->where('category_id', $product->category_id)
                ->whereNotIn('id', $excludeIds)
                ->limit($limit - $relatedProducts->count())
                ->get();
            
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        // If still not enough, get random products
        if ($relatedProducts->count() < $limit) {
            $excludeIds = $relatedProducts->pluck('id')->toArray();
            $additionalProducts = $query->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->limit($limit - $relatedProducts->count())
                ->get();
            
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        return $relatedProducts;
    }
}
