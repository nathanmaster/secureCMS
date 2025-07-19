<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProductController;
use Illuminate\Support\Facades\Route;

// Default route - Menu page for all users (guests and logged in)
Route::get('/', [MenuController::class, 'index'])->name('menu');

// Debug test route
Route::get('/debug-test', function() {
    return view('test-debug');
})->name('debug.test');

// Simple test route
Route::get('/test', function() {
    return 'Laravel is working!';
})->name('test');

// Simple test with blade
Route::get('/test-simple', function() {
    return view('test-simple');
})->name('test-simple');

// Test menu view rendering
Route::get('/test-menu', function() {
    try {
        // Create a mock price range object
        $priceRange = (object) [
            'min_price' => 0,
            'max_price' => 100
        ];
        
        return view('menu', [
            'categories' => collect(),
            'uncategorizedProducts' => collect(),
            'allCategories' => collect(),
            'allSubcategories' => collect(),
            'priceRange' => $priceRange,
            'dynamicWeightOptions' => collect(),
            'categoryFilter' => null,
            'subcategoryFilter' => null,
            'minPrice' => null,
            'maxPrice' => null,
            'minPercentage' => null,
            'maxPercentage' => null,
            'selectedWeight' => null,
            'sortBy' => 'name',
            'sortDirection' => 'asc',
            'viewMode' => 'grid'
        ]);
    } catch (\Exception $e) {
        return 'Menu view error: ' . $e->getMessage();
    }
})->name('test-menu');

// Test public layout directly
Route::get('/test-layout', function() {
    try {
        return view('layouts.public', ['slot' => 'Test content']);
    } catch (\Exception $e) {
        return 'Layout error: ' . $e->getMessage();
    }
})->name('test-layout');

// Product detail route for all users (guests and logged in)
Route::get('/product/{product}', [MenuController::class, 'show'])->name('product.show');

// AJAX route for getting product price by weight
Route::get('/product/{product}/price', [MenuController::class, 'getProductPrice'])->name('product.price');

// Product routes
Route::get('/product/{product}', [PublicProductController::class, 'show'])->name('product.show');

// Product comments and ratings (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::post('/product/{product}/comment', [PublicProductController::class, 'storeComment'])->name('product.comment');
    
    // Wishlist routes
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{wishlist}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::get('/wishlist/count', [\App\Http\Controllers\WishlistController::class, 'getCount'])->name('wishlist.count');
    Route::get('/wishlist/check', [\App\Http\Controllers\WishlistController::class, 'checkProduct'])->name('wishlist.check');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard - only accessible to admin users
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management Routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
    
    // Product Management Routes
    Route::resource('admin/products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    
    // Category Management Routes
    Route::resource('admin/categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    
    // Subcategory Management Routes
    Route::resource('admin/subcategories', SubcategoryController::class)->names([
        'index' => 'admin.subcategories.index',
        'create' => 'admin.subcategories.create',
        'store' => 'admin.subcategories.store',
        'show' => 'admin.subcategories.show',
        'edit' => 'admin.subcategories.edit',
        'update' => 'admin.subcategories.update',
        'destroy' => 'admin.subcategories.destroy',
    ]);
    
    // Comment Management Routes
    Route::get('admin/comments', [CommentController::class, 'index'])->name('admin.comments.index');
    Route::patch('admin/comments/{comment}/approve', [CommentController::class, 'approve'])->name('admin.comments.approve');
    Route::patch('admin/comments/{comment}/unapprove', [CommentController::class, 'unapprove'])->name('admin.comments.unapprove');
    Route::delete('admin/comments/{comment}', [CommentController::class, 'destroy'])->name('admin.comments.destroy');
    
    // Weight Options Management Routes
    Route::resource('admin/weight-options', \App\Http\Controllers\Admin\DefaultWeightOptionController::class)->names([
        'index' => 'admin.weight-options.index',
        'create' => 'admin.weight-options.create',
        'store' => 'admin.weight-options.store',
        'show' => 'admin.weight-options.show',
        'edit' => 'admin.weight-options.edit',
        'update' => 'admin.weight-options.update',
        'destroy' => 'admin.weight-options.destroy',
    ]);
    Route::patch('admin/weight-options/{weightOption}/toggle-active', [\App\Http\Controllers\Admin\DefaultWeightOptionController::class, 'toggleActive'])->name('admin.weight-options.toggle-active');
    
    // Wishlist Management Routes
    Route::get('admin/wishlists', [\App\Http\Controllers\Admin\WishlistController::class, 'index'])->name('admin.wishlists.index');
    Route::get('admin/wishlists/{wishlist}', [\App\Http\Controllers\Admin\WishlistController::class, 'show'])->name('admin.wishlists.show');
    Route::patch('admin/wishlists/{wishlist}/contacted', [\App\Http\Controllers\Admin\WishlistController::class, 'markContacted'])->name('admin.wishlists.mark-contacted');
    Route::patch('admin/wishlists/{wishlist}/completed', [\App\Http\Controllers\Admin\WishlistController::class, 'markCompleted'])->name('admin.wishlists.mark-completed');
    Route::delete('admin/wishlists/{wishlist}', [\App\Http\Controllers\Admin\WishlistController::class, 'destroy'])->name('admin.wishlists.destroy');
});

require __DIR__.'/auth.php';
