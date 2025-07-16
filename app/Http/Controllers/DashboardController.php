<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductComment;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'active_products' => Product::where('is_available', true)->count(),
            'total_comments' => ProductComment::count(),
            'pending_comments' => ProductComment::where('is_approved', false)->count(),
            'total_ratings' => ProductRating::count(),
            'average_rating' => ProductRating::avg('rating') ?? 0,
        ];

        // Get recent activity (last 10 activities)
        $recentActivity = collect([]);
        
        // Recent products
        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'type' => 'product',
                    'action' => 'created',
                    'description' => 'Created product "' . $product->name . '"',
                    'user' => 'System', // You can add user relation later
                    'status' => 'success',
                    'created_at' => $product->created_at,
                ];
            });

        // Recent users
        $recentUsers = User::latest()
            ->take(3)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user',
                    'action' => 'registered',
                    'description' => 'New user "' . $user->name . '" registered',
                    'user' => 'System',
                    'status' => 'success',
                    'created_at' => $user->created_at,
                ];
            });

        // Recent categories
        $recentCategories = Category::latest()
            ->take(2)
            ->get()
            ->map(function ($category) {
                return [
                    'type' => 'category',
                    'action' => 'created',
                    'description' => 'Created category "' . $category->name . '"',
                    'user' => 'Admin',
                    'status' => 'success',
                    'created_at' => $category->created_at,
                ];
            });

        // Recent comments
        $recentComments = ProductComment::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($comment) {
                return [
                    'type' => 'comment',
                    'action' => $comment->is_approved ? 'approved' : 'pending',
                    'description' => $comment->user->name . ' commented on "' . $comment->product->name . '"',
                    'user' => $comment->user->name,
                    'status' => $comment->is_approved ? 'success' : 'warning',
                    'created_at' => $comment->created_at,
                ];
            });

        // Recent ratings
        $recentRatings = ProductRating::with(['user', 'product'])
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($rating) {
                return [
                    'type' => 'rating',
                    'action' => 'rated',
                    'description' => $rating->user->name . ' rated "' . $rating->product->name . '" (' . $rating->rating . ' stars)',
                    'user' => $rating->user->name,
                    'status' => 'success',
                    'created_at' => $rating->created_at,
                ];
            });

        // Combine and sort activities
        $recentActivity = $recentProducts
            ->concat($recentUsers)
            ->concat($recentCategories)
            ->concat($recentComments)
            ->concat($recentRatings)
            ->concat($recentCategories)
            ->sortByDesc('created_at')
            ->take(10);

        // Get analytics data
        $analytics = [
            'products_trend' => $this->getProductsTrend(),
            'users_trend' => $this->getUsersTrend(),
            'categories_trend' => $this->getCategoriesTrend(),
        ];

        return view('dashboard', compact('stats', 'recentActivity', 'analytics'));
    }

    private function getProductsTrend()
    {
        return Product::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count,
                ];
            });
    }

    private function getUsersTrend()
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count,
                ];
            });
    }

    private function getCategoriesTrend()
    {
        return Category::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count,
                ];
            });
    }
}
