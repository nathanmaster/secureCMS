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

class MenuController extends Controller
{
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
        $categories = Category::with(['products' => function ($query) use ($search, $categoryFilter, $subcategoryFilter, $minPrice, $maxPrice, $weights, $minPercentage, $maxPercentage, $availability, $sortBy, $sortDirection) {
            $query->when(!auth()->check() || !auth()->user()->is_admin, function ($q) {
                $q->where('is_available', true);
            });
            
            // Apply search filter
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            if ($minPrice) {
                $query->where('price', '>=', $minPrice);
            }
            if ($maxPrice) {
                $query->where('price', '<=', $maxPrice);
            }
            
            // Apply weight filters using dynamic weight options
            if (!empty($weights)) {
                $query->where(function ($q) use ($weights) {
                    foreach ($weights as $weightValue) {
                        $weightOption = DefaultWeightOption::where('value', $weightValue)->first();
                        if ($weightOption) {
                            if ($weightOption->value === '1000+') {
                                $q->orWhere('weight', '>', 1000);
                            } elseif ($weightOption->min_weight && $weightOption->max_weight) {
                                $q->orWhere(function ($subQ) use ($weightOption) {
                                    $subQ->where('weight', '>=', $weightOption->min_weight)
                                         ->where('weight', '<=', $weightOption->max_weight);
                                });
                            }
                        }
                    }
                });
            }
            
            if ($minPercentage) {
                $query->where('percentage', '>=', $minPercentage);
            }
            if ($maxPercentage) {
                $query->where('percentage', '<=', $maxPercentage);
            }
            
            // Apply availability filter
            if (!empty($availability)) {
                $query->where(function ($q) use ($availability) {
                    if (in_array('available', $availability)) {
                        $q->orWhere('is_available', true);
                    }
                    if (in_array('unavailable', $availability)) {
                        $q->orWhere('is_available', false);
                    }
                });
            }
            
            if ($subcategoryFilter) {
                $query->where('subcategory_id', $subcategoryFilter);
            }
            
            switch ($sortBy) {
                case 'price':
                    $query->orderBy('price', $sortDirection);
                    break;
                case 'weight':
                    $query->orderBy('weight', $sortDirection);
                    break;
                case 'percentage':
                    $query->orderBy('percentage', $sortDirection);
                    break;
                case 'rating':
                    $query->withAvg('ratings', 'rating')
                        ->orderBy('ratings_avg_rating', $sortDirection);
                    break;
                default:
                    $query->orderBy('name', $sortDirection);
            }
        }])
        ->when($categoryFilter, function ($query) use ($categoryFilter) {
            $query->where('id', $categoryFilter);
        })
        ->orderBy('name')
        ->get();

        // Get uncategorized products with filters
        $uncategorizedProducts = $productsQuery->clone()
            ->whereNull('category_id')
            ->get();

        // Get all categories for filter dropdown
        $allCategories = Category::orderBy('name')->get();

        // Get all subcategories for filter dropdown
        $allSubcategories = \App\Models\Subcategory::with('category')->orderBy('name')->get();

        // Price range for filters
        $priceRange = Product::when(!auth()->check() || !auth()->user()->is_admin, function ($query) {
            $query->where('is_available', true);
        })->selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        // Weight range for filters
        $weightRange = Product::when(!auth()->check() || !auth()->user()->is_admin, function ($query) {
            $query->where('is_available', true);
        })->whereNotNull('weight')->selectRaw('MIN(weight) as min_weight, MAX(weight) as max_weight')->first();

        // Get dynamic weight options for filter
        $dynamicWeightOptions = DefaultWeightOption::active()->orderBy('sort_order')->orderBy('min_weight')->get();

        return view('menu', compact(
            'categories', 
            'uncategorizedProducts', 
            'allCategories', 
            'allSubcategories',
            'priceRange',
            'weightRange',
            'dynamicWeightOptions',
            'categoryFilter',
            'subcategoryFilter',
            'minPrice',
            'maxPrice',
            'minPercentage',
            'maxPercentage',
            'sortBy',
            'sortDirection',
            'viewMode'
        ));
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
            'availableWeightVariants.defaultWeightOption'
        ]);
        
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
