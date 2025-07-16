<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display the public menu page.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $search = $request->get('search');
        $categoryFilter = $request->get('category');
        $subcategoryFilter = $request->get('subcategory');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $weights = $request->get('weights', []);
        $minPercentage = $request->get('min_percentage');
        $maxPercentage = $request->get('max_percentage');
        $availability = $request->get('availability', ['available', 'unavailable']);
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $viewMode = $request->get('view_mode', 'grid');

        // Build the products query
        $productsQuery = Product::with(['category', 'subcategory', 'ratings'])
            ->when(!auth()->check() || !auth()->user()->is_admin, function ($query) {
                // Hide unavailable products from guests and non-admin users
                $query->where('is_available', true);
            });

        // Apply search filter
        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply price filters
        if ($minPrice) {
            $productsQuery->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        // Apply weight filters (checkbox-based)
        if (!empty($weights)) {
            $productsQuery->where(function ($query) use ($weights) {
                foreach ($weights as $weight) {
                    if ($weight === '0-100') {
                        $query->orWhere(function ($q) {
                            $q->where('weight', '>=', 0)->where('weight', '<=', 100);
                        });
                    } elseif ($weight === '100-250') {
                        $query->orWhere(function ($q) {
                            $q->where('weight', '>', 100)->where('weight', '<=', 250);
                        });
                    } elseif ($weight === '250-500') {
                        $query->orWhere(function ($q) {
                            $q->where('weight', '>', 250)->where('weight', '<=', 500);
                        });
                    } elseif ($weight === '500-1000') {
                        $query->orWhere(function ($q) {
                            $q->where('weight', '>', 500)->where('weight', '<=', 1000);
                        });
                    } elseif ($weight === '1000+') {
                        $query->orWhere('weight', '>', 1000);
                    }
                }
            });
        }

        // Apply percentage filters
        if ($minPercentage) {
            $productsQuery->where('percentage', '>=', $minPercentage);
        }
        if ($maxPercentage) {
            $productsQuery->where('percentage', '<=', $maxPercentage);
        }

        // Apply availability filter
        if (!empty($availability)) {
            $productsQuery->where(function ($query) use ($availability) {
                if (in_array('available', $availability)) {
                    $query->orWhere('is_available', true);
                }
                if (in_array('unavailable', $availability)) {
                    $query->orWhere('is_available', false);
                }
            });
        }

        // Apply subcategory filter
        if ($subcategoryFilter) {
            $productsQuery->where('subcategory_id', $subcategoryFilter);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price':
                $productsQuery->orderBy('price', $sortDirection);
                break;
            case 'weight':
                $productsQuery->orderBy('weight', $sortDirection);
                break;
            case 'percentage':
                $productsQuery->orderBy('percentage', $sortDirection);
                break;
            case 'rating':
                $productsQuery->withAvg('ratings', 'rating')
                    ->orderBy('ratings_avg_rating', $sortDirection);
                break;
            default:
                $productsQuery->orderBy('name', $sortDirection);
        }

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
            
            // Apply weight filters
            if (!empty($weights)) {
                $query->where(function ($q) use ($weights) {
                    foreach ($weights as $weight) {
                        if ($weight === '0-100') {
                            $q->orWhere(function ($subQ) {
                                $subQ->where('weight', '>=', 0)->where('weight', '<=', 100);
                            });
                        } elseif ($weight === '100-250') {
                            $q->orWhere(function ($subQ) {
                                $subQ->where('weight', '>', 100)->where('weight', '<=', 250);
                            });
                        } elseif ($weight === '250-500') {
                            $q->orWhere(function ($subQ) {
                                $subQ->where('weight', '>', 250)->where('weight', '<=', 500);
                            });
                        } elseif ($weight === '500-1000') {
                            $q->orWhere(function ($subQ) {
                                $subQ->where('weight', '>', 500)->where('weight', '<=', 1000);
                            });
                        } elseif ($weight === '1000+') {
                            $q->orWhere('weight', '>', 1000);
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

        return view('menu', compact(
            'categories', 
            'uncategorizedProducts', 
            'allCategories', 
            'allSubcategories',
            'priceRange',
            'weightRange',
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

        // Load the product with its category, approved comments, and ratings
        $product->load([
            'category', 
            'approvedComments.user', 
            'ratings.user'
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
