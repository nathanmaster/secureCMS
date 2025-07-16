<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display the public menu page.
     */
    public function index()
    {
        // Fetch all categories with their products
        $categories = Category::with(['products' => function ($query) {
            $query->orderBy('name');
        }])->orderBy('name')->get();

        // Also get products without categories
        $uncategorizedProducts = Product::whereNull('category_id')
            ->orderBy('name')
            ->get();

        return view('menu', compact('categories', 'uncategorizedProducts'));
    }

    /**
     * Display a specific product detail page.
     */
    public function show(Product $product)
    {
        // Load the product with its category
        $product->load('category');
        
        return view('product.show', compact('product'));
    }
}
