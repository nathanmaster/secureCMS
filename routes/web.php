<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Default route - Menu page for all users (guests and logged in)
Route::get('/', [MenuController::class, 'index'])->name('menu');

// Product detail route for all users (guests and logged in)
Route::get('/product/{product}', [MenuController::class, 'show'])->name('product.show');

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
});

require __DIR__.'/auth.php';
