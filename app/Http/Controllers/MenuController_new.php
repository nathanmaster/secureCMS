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
        // Get filter parameters
        $filters = [
            'search' => $request->get('search'),
            'category' => $request->get('category'),
            'subcategory' => $request->get('subcategory'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'weights' => $request->get('weights', []),
            'selected_weight' => $request->get('selected_weight'), // For dynamic filtering
            'min_percentage' => $request->get('min_percentage'),
            'max_percentage' => $request->get('max_percentage'),
            'availability' => $request->get('availability', ['available', 'unavailable']),
        ];

        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $viewMode = $request->get('view_mode', 'grid');
        $selectedWeight = $request->get('selected_weight');

        // Build the products query
        $productsQuery = Product::with(['category', 'subcategory', 'ratings', 'weightVariants'])
            ->when(!auth()->check() || !auth()->user()->is_admin, function ($query) {
                // Hide unavailable products from guests and non-admin users
                $query->where('is_available', true);
            });

        // Apply filters using the service
        $productsQuery = $this->filterService->applyFilters($productsQuery, $filters);

        // Apply sorting using the service
        $productsQuery = $this->filterService->applySorting($productsQuery, $sortBy, $sortDirection, $selectedWeight);

        // Fetch categories with filtered products
        $categories = Category::with(['products' => function ($query) use ($filters, $sortBy, $sortDirection, $selectedWeight) {
            $query->when(!auth()->check() || !auth()->user()->is_admin, function ($q) {
                $q->where('is_available', true);
            });
            
            // Apply the same filters to category products
            $query = $this->filterService->applyFilters($query, $filters);
            $query = $this->filterService->applySorting($query, $sortBy, $sortDirection, $selectedWeight);
        }])
        ->when($filters['category'], function ($query, $categoryId) {
            $query->where('id', $categoryId);
        })
        ->orderBy('name')
        ->get();

        // Get uncategorized products with filters
        $uncategorizedQuery = Product::with(['ratings', 'weightVariants'])
            ->when(!auth()->check() || !auth()->user()->is_admin, function ($query) {
                $query->where('is_available', true);
            })
            ->whereNull('category_id');

        $uncategorizedQuery = $this->filterService->applyFilters($uncategorizedQuery, $filters);
        $uncategorizedQuery = $this->filterService->applySorting($uncategorizedQuery, $sortBy, $sortDirection, $selectedWeight);
        $uncategorizedProducts = $uncategorizedQuery->get();

        // Get all categories for filter dropdown
        $allCategories = Category::orderBy('name')->get();

        // Get all subcategories for filter dropdown
        $allSubcategories = \App\Models\Subcategory::with('category')->orderBy('name')->get();

        // Price range for filters (dynamic based on selected weight)
        $priceRange = $this->filterService->getPriceRange($selectedWeight);

        // Weight options for filters using the service
        $dynamicWeightOptions = $this->filterService->getAvailableWeightOptions();

        // Process products to add weight options and pricing data
        foreach ($categories as $category) {
            foreach ($category->products as $product) {
                $product->weightOptions = $this->filterService->getProductWeightOptions($product);
                $product->defaultWeight = $this->filterService->getDefaultWeight($product);
                $product->selectedWeightPrice = $selectedWeight ? 
                    $this->filterService->getPriceForWeight($product, $selectedWeight) : 
                    null;
            }
        }

        foreach ($uncategorizedProducts as $product) {
            $product->weightOptions = $this->filterService->getProductWeightOptions($product);
            $product->defaultWeight = $this->filterService->getDefaultWeight($product);
            $product->selectedWeightPrice = $selectedWeight ? 
                $this->filterService->getPriceForWeight($product, $selectedWeight) : 
                null;
        }

        return view('menu', compact(
            'categories', 
            'uncategorizedProducts', 
            'allCategories', 
            'allSubcategories',
            'priceRange',
            'dynamicWeightOptions',
            'categoryFilter' => $filters['category'],
            'subcategoryFilter' => $filters['subcategory'],
            'minPrice' => $filters['min_price'],
            'maxPrice' => $filters['max_price'],
            'minPercentage' => $filters['min_percentage'],
            'maxPercentage' => $filters['max_percentage'],
            'selectedWeight',
            'sortBy',
            'sortDirection',
            'viewMode'
        ));
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

        // Add weight options for the product detail page
        $product->weightOptions = $this->filterService->getProductWeightOptions($product);
        $product->defaultWeight = $this->filterService->getDefaultWeight($product);
        
        return view('product.show', compact('product'));
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
