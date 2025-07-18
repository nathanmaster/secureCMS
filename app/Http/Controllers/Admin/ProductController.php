<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\DefaultWeightOption;
use App\Models\ProductWeightVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $subcategories = \App\Models\Subcategory::orderBy('name')->get();
        $defaultWeightOptions = DefaultWeightOption::active()->orderBy('sort_order')->orderBy('min_weight')->get();
        
        return view('admin.products.create', compact('categories', 'subcategories', 'defaultWeightOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'is_available' => 'boolean',
            'weight_variants' => 'nullable|array',
            'weight_variants.*.weight_option_id' => 'nullable|exists:default_weight_options,id',
            'weight_variants.*.custom_weight' => 'nullable|numeric|min:0',
            'weight_variants.*.custom_label' => 'nullable|string|max:255',
            'weight_variants.*.price' => 'nullable|numeric|min:0',
            'weight_variants.*.is_available' => 'boolean',
        ]);

        DB::transaction(function () use ($request) {
            $data = $request->only(['name', 'description', 'weight', 'percentage', 'category_id', 'subcategory_id']);
            $data['price'] = $request->base_price; // Keep base price in product table for compatibility
            $data['is_available'] = $request->has('is_available');

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $data['image_path'] = $image->storeAs('products', $filename, 'public');
            }

            $product = Product::create($data);

            // Create weight variants if provided
            if ($request->has('weight_variants') && is_array($request->weight_variants)) {
                foreach ($request->weight_variants as $variant) {
                    if (!empty($variant['price'])) {
                        ProductWeightVariant::create([
                            'product_id' => $product->id,
                            'default_weight_option_id' => $variant['weight_option_id'] ?? null,
                            'custom_weight' => $variant['custom_weight'] ?? null,
                            'custom_label' => $variant['custom_label'] ?? null,
                            'price' => $variant['price'],
                            'is_available' => isset($variant['is_available']) ? (bool)$variant['is_available'] : true,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $subcategories = \App\Models\Subcategory::orderBy('name')->get();
        $defaultWeightOptions = DefaultWeightOption::active()->orderBy('sort_order')->orderBy('min_weight')->get();
        $product->load('weightVariants.defaultWeightOption');
        
        return view('admin.products.edit', compact('product', 'categories', 'subcategories', 'defaultWeightOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'is_available' => 'boolean',
            'weight_variants' => 'nullable|array',
            'weight_variants.*.weight_option_id' => 'nullable|exists:default_weight_options,id',
            'weight_variants.*.custom_weight' => 'nullable|numeric|min:0',
            'weight_variants.*.custom_label' => 'nullable|string|max:255',
            'weight_variants.*.price' => 'nullable|numeric|min:0',
            'weight_variants.*.is_available' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $product) {
            $data = $request->only(['name', 'description', 'weight', 'percentage', 'category_id', 'subcategory_id']);
            $data['price'] = $request->base_price; // Keep base price in product table for compatibility
            $data['is_available'] = $request->has('is_available');

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image if exists
                if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                    Storage::disk('public')->delete($product->image_path);
                }
                
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $data['image_path'] = $image->storeAs('products', $filename, 'public');
            }

            $product->update($data);

            // Delete existing weight variants
            $product->weightVariants()->delete();

            // Create new weight variants if provided
            if ($request->has('weight_variants') && is_array($request->weight_variants)) {
                foreach ($request->weight_variants as $variant) {
                    if (!empty($variant['price'])) {
                        ProductWeightVariant::create([
                            'product_id' => $product->id,
                            'default_weight_option_id' => $variant['weight_option_id'] ?? null,
                            'custom_weight' => $variant['custom_weight'] ?? null,
                            'custom_label' => $variant['custom_label'] ?? null,
                            'price' => $variant['price'],
                            'is_available' => isset($variant['is_available']) ? (bool)$variant['is_available'] : true,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated image if exists
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
