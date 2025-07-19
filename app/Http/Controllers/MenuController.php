<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductRating;
use App\Models\DefaultWeightOption;
use App\Models\Subcategory;
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
        try {
            // Get all categories and subcategories for filters
            $allCategories = Category::orderBy('name')->get();
            $allSubcategories = Subcategory::with('category')->orderBy('name')->get();
            $dynamicWeightOptions = DefaultWeightOption::where('is_active', true)->orderBy('sort_order')->get();
            
            // Build the products query
            $query = Product::with(['category', 'subcategory', 'ratings', 'availableWeightVariants.defaultWeightOption']);
            
            // Apply availability filter (non-admin users only see available products)
            if (!auth()->check() || !auth()->user()->is_admin) {
                $query->where('is_available', true);
            }
            
            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }
            
            // Apply category filter
            if ($request->filled('category')) {
                $query->where('category_id', $request->get('category'));
            }
            
            // Apply subcategory filter
            if ($request->filled('subcategory')) {
                $query->where('subcategory_id', $request->get('subcategory'));
            }
            
            // Apply THC percentage range filter
            if ($request->filled('min_percentage')) {
                $query->where('percentage', '>=', $request->get('min_percentage'));
            }
            
            if ($request->filled('max_percentage')) {
                $query->where('percentage', '<=', $request->get('max_percentage'));
            }
              // Apply weight options filter - this is now the primary filter
            $selectedWeightOptions = $request->get('weight_options', []);
            
            // Apply sorting
            $sortBy = $request->get('sort_by', 'name');
            $sortDirection = $request->get('sort_direction', 'asc');
            
            switch ($sortBy) {
                case 'price':
                    $query->orderBy('price', $sortDirection);
                    break;
                case 'percentage':
                    $query->orderBy('percentage', $sortDirection);
                    break;
                case 'name':
                default:
                    $query->orderBy('name', $sortDirection);
                    break;
            }

            // Get all products first
            $allProducts = $query->get();
            
            // Apply advanced filtering based on weight and price interactions
            $filteredProducts = $allProducts->filter(function($product) use ($selectedWeightOptions, $request) {
                // If weight options are selected, filter products accordingly
                if (!empty($selectedWeightOptions)) {
                    $availableVariants = $product->availableWeightVariants->whereIn('default_weight_option_id', $selectedWeightOptions);
                    
                    // Hide products that don't have any of the selected weight options
                    if ($availableVariants->isEmpty()) {
                        return false;
                    }
                    
                    // Apply price filter only to the selected weight variants
                    if ($request->filled('min_price') || $request->filled('max_price')) {
                        $minPrice = $request->get('min_price');
                        $maxPrice = $request->get('max_price');
                        
                        $priceFilteredVariants = $availableVariants->filter(function($variant) use ($minPrice, $maxPrice) {
                            if ($minPrice !== null && $variant->price < $minPrice) {
                                return false;
                            }
                            if ($maxPrice !== null && $variant->price > $maxPrice) {
                                return false;
                            }
                            return true;
                        });
                        
                        // If no variants pass the price filter, hide the product
                        if ($priceFilteredVariants->isEmpty()) {
                            return false;
                        }
                        
                        $product->filteredWeightVariants = $priceFilteredVariants;
                    } else {
                        $product->filteredWeightVariants = $availableVariants;
                    }
                } else {
                    // No weight filter selected, apply price filter to all variants
                    if ($request->filled('min_price') || $request->filled('max_price')) {
                        $minPrice = $request->get('min_price');
                        $maxPrice = $request->get('max_price');
                        
                        // Check if product's base price is in range
                        $baseInRange = true;
                        if ($minPrice !== null && $product->price < $minPrice) {
                            $baseInRange = false;
                        }
                        if ($maxPrice !== null && $product->price > $maxPrice) {
                            $baseInRange = false;
                        }
                        
                        // Check if any weight variants are in range
                        $variantsInRange = $product->availableWeightVariants->filter(function($variant) use ($minPrice, $maxPrice) {
                            if ($minPrice !== null && $variant->price < $minPrice) {
                                return false;
                            }
                            if ($maxPrice !== null && $variant->price > $maxPrice) {
                                return false;
                            }
                            return true;
                        });
                        
                        // Hide product if neither base price nor any variants are in range
                        if (!$baseInRange && $variantsInRange->isEmpty()) {
                            return false;
                        }
                        
                        // If variants are in range, filter them
                        if (!$variantsInRange->isEmpty()) {
                            $product->filteredWeightVariants = $variantsInRange;
                        } else {
                            $product->filteredWeightVariants = collect();
                        }
                    } else {
                        $product->filteredWeightVariants = $product->availableWeightVariants;
                    }
                }
                
                return true;
            });
            
            // Group filtered products by category
            $categories = $allCategories->filter(function($category) use ($filteredProducts) {
                return $filteredProducts->where('category_id', $category->id)->count() > 0;
            })->map(function($category) use ($filteredProducts) {
                $category->products = $filteredProducts->where('category_id', $category->id);
                return $category;
            });
            
            // Get uncategorized products from filtered results
            $uncategorizedProducts = $filteredProducts->whereNull('category_id');
            
            // Calculate price range from filtered products and their allowed variants
            $allPrices = collect();
            foreach ($filteredProducts as $product) {
                if (isset($product->filteredWeightVariants) && $product->filteredWeightVariants->isNotEmpty()) {
                    $allPrices = $allPrices->merge($product->filteredWeightVariants->pluck('price'));
                } else {
                    $allPrices->push($product->price);
                }
            }
            
            $priceRange = (object) [
                'min_price' => $allPrices->min() ?? 0,
                'max_price' => $allPrices->max() ?? 200
            ];
            
            return view('menu', compact(
                'categories',
                'uncategorizedProducts',
                'allCategories',
                'allSubcategories',
                'dynamicWeightOptions',
                'priceRange',
                'selectedWeightOptions'
            ));
        
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
