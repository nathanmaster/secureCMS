<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductRating;
use App\Models\DefaultWeightOption;
use App\Services\ProductFilterService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $filterService;

    public function __construct(ProductFilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * Display the public menu page.
     */
    public function index(Request $request)
    {
        // Debug: Add some logging
        \Log::info('Menu index called');
        
        try {
            // Simplified version for testing
            $categories = \App\Models\Category::with(['products' => function($query) {
                if (!auth()->check() || !auth()->user()->is_admin) {
                    $query->where('is_available', true);
                }
                $query->with(['ratings', 'weightVariants']);
            }])->orderBy('name')->get();
            
            $uncategorizedProducts = \App\Models\Product::whereNull('category_id')
                ->when(!auth()->check() || !auth()->user()->is_admin, function ($query) {
                    $query->where('is_available', true);
                })
                ->with(['ratings', 'weightVariants'])
                ->orderBy('name')
                ->get();
            
            $allCategories = \App\Models\Category::orderBy('name')->get();
            $allSubcategories = \App\Models\Subcategory::with('category')->orderBy('name')->get();
            
            // Simple price range
            $priceRange = (object) [
                'min_price' => 0,
                'max_price' => 100
            ];
            
            $dynamicWeightOptions = \App\Models\DefaultWeightOption::where('is_active', true)->orderBy('value')->get();
            
            return view('menu', [
                'categories' => $categories,
                'uncategorizedProducts' => $uncategorizedProducts,
                'allCategories' => $allCategories,
                'allSubcategories' => $allSubcategories,
                'priceRange' => $priceRange,
                'dynamicWeightOptions' => $dynamicWeightOptions,
                'categoryFilter' => $request->get('category'),
                'subcategoryFilter' => $request->get('subcategory'),
                'minPrice' => $request->get('min_price'),
                'maxPrice' => $request->get('max_price'),
                'minPercentage' => $request->get('min_percentage'),
                'maxPercentage' => $request->get('max_percentage'),
                'selectedWeight' => $request->get('selected_weight'),
                'sortBy' => $request->get('sort_by', 'name'),
                'sortDirection' => $request->get('sort_direction', 'asc'),
                'viewMode' => $request->get('view_mode', 'grid')
            ]);
        
        } catch (\Exception $e) {
            \Log::error('Menu index error: ' . $e->getMessage());
            return response('Menu error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * AJAX endpoint for getting product price by weight
     */
    public function getProductPrice(Request $request, Product $product)
    {
        $weight = $request->get('weight');
        $price = $this->filterService->getPriceForWeight($product, $weight);
        
        return response()->json([
            'price' => $price,
            'formatted_price' => $price ? '$' . number_format($price, 2) : null
        ]);
    }

    /**
     * Display a specific product detail page.
     */
    public function show(Product $product)
    {
        // Debug: Add some logging
        \Log::info('Product show called for product: ' . $product->id);
        
        try {
            // Hide unavailable products from guests and non-admin users
            if (!$product->is_available && (!auth()->check() || !auth()->user()->is_admin)) {
                abort(404);
            }

            // Load the product with its category, approved comments, ratings, and weight variants
            $product->load([
                'category', 
                'approvedComments.user', 
                'ratings.user',
                'weightVariants'
            ]);

            // Simple weight options without service
            $product->weightOptions = $product->weightVariants->map(function($variant) {
                return [
                    'value' => $variant->weight_option_value,
                    'label' => $variant->effective_label,
                    'price' => $variant->price
                ];
            });
            
            $product->defaultWeight = $product->weightVariants->first();
            
            return view('product.show', compact('product'));
        
        } catch (\Exception $e) {
            \Log::error('Product show error: ' . $e->getMessage());
            return response('Product show error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a comment and rating for a product.
     */
    public function storeComment(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Store or update the rating
        ProductRating::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $request->rating,
            ]
        );

        // Store the comment (pending approval)
        ProductComment::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_approved' => false, // Require admin approval
        ]);

        return redirect()->back()->with('success', 'Thank you for your review! It will be published after admin approval.');
    }
}
