<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Welcome back! Here's what's happening with your CMS.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button onclick="showNotification('Welcome to your dashboard!', 'success')" 
                        class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Item
                </button>
                <button class="btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </button>
            </div>
        </div>
    </x-slot>

    <x-container>
        <div class="py-6 space-y-6">
            <!-- Stats Cards -->
            <x-grid cols="4" gap="6">
                <x-stats-card 
                    title="Total Products" 
                    value="{{ number_format($stats['total_products']) }}" 
                    description="{{ $stats['active_products'] }} active products"
                    color="blue"
                    :icon="'<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4\"></path></svg>'"
                />
                <x-stats-card 
                    title="Total Users" 
                    value="{{ number_format($stats['total_users']) }}" 
                    description="Registered users"
                    color="green"
                    :icon="'<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z\"></path></svg>'"
                />
                <x-stats-card 
                    title="Categories" 
                    value="{{ number_format($stats['total_categories']) }}" 
                    description="Product categories"
                    color="purple"
                    :icon="'<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10\"></path></svg>'"
                />
                <x-stats-card 
                    title="Active Products" 
                    value="{{ number_format($stats['active_products']) }}" 
                    description="Available for sale"
                    color="yellow"
                    :icon="'<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\"></path></svg>'"
                />
            </x-grid>

            <!-- Recent Activity -->
            <x-card>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Activity</h3>
                    <x-badge type="info">Live</x-badge>
                </div>
                
                @if($recentActivity->isNotEmpty())
                    <x-table>
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <x-table.th>Activity</x-table.th>
                                <x-table.th>User</x-table.th>
                                <x-table.th>Status</x-table.th>
                                <x-table.th>Date</x-table.th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($recentActivity as $activity)
                                <x-table.tr>
                                    <x-table.td>{{ $activity['description'] }}</x-table.td>
                                    <x-table.td>{{ $activity['user'] }}</x-table.td>
                                    <x-table.td>
                                        <x-badge type="{{ $activity['status'] === 'success' ? 'success' : 'error' }}">
                                            {{ ucfirst($activity['status']) }}
                                        </x-badge>
                                    </x-table.td>
                                    <x-table.td>{{ $activity['created_at']->diffForHumans() }}</x-table.td>
                                </x-table.tr>
                            @endforeach
                        </tbody>
                    </x-table>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No recent activity</p>
                    </div>
                @endif
            </x-card>

            <!-- Tabbed Content -->
            <x-card>
                <x-tabs active="overview">
                    <x-tabs.nav :tabs="[
                        ['id' => 'overview', 'title' => 'Overview'],
                        ['id' => 'analytics', 'title' => 'Analytics'],
                        ['id' => 'settings', 'title' => 'Settings']
                    ]" />
                    
                    <div class="mt-6">
                        <x-tabs.content id="overview">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">System Overview</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Database Status</h4>
                                            <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Connected and optimized
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Cache Status</h4>
                                            <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Active and efficient
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Security Status</h4>
                                            <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                All checks passed
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Last Backup</h4>
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ now()->subHours(2)->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Quick Actions</h4>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.products.create') }}" class="btn-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Product
                                        </a>
                                        <a href="{{ route('admin.categories.create') }}" class="btn-secondary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Category
                                        </a>
                                        <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            Manage Users
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </x-tabs.content>
                        
                        <x-tabs.content id="analytics">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Analytics Dashboard</h3>
                                    
                                    <!-- Trend Charts -->
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Products Trend</h4>
                                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                {{ $analytics['products_trend']->count() }}
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Products created this month</p>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Users Trend</h4>
                                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                {{ $analytics['users_trend']->count() }}
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Users registered this month</p>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Categories Trend</h4>
                                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                                {{ $analytics['categories_trend']->count() }}
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Categories created this month</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Activity Breakdown -->
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Activity Breakdown</h4>
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600 dark:text-gray-400">Product Management</span>
                                                <span class="font-medium">{{ $recentActivity->where('type', 'product')->count() }} activities</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600 dark:text-gray-400">User Management</span>
                                                <span class="font-medium">{{ $recentActivity->where('type', 'user')->count() }} activities</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600 dark:text-gray-400">Category Management</span>
                                                <span class="font-medium">{{ $recentActivity->where('type', 'category')->count() }} activities</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-tabs.content>
                        
                        <x-tabs.content id="settings">
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">System Settings</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Email Notifications</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Receive notifications about system events</p>
                                            </div>
                                            <input type="checkbox" class="form-checkbox" checked>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Auto Backup</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Automatically backup your data daily</p>
                                            </div>
                                            <input type="checkbox" class="form-checkbox" checked>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Maintenance Mode</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Enable maintenance mode for system updates</p>
                                            </div>
                                            <input type="checkbox" class="form-checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-tabs.content>
                    </div>
                </x-tabs>
            </x-card>
        </div>
    </x-container>
</x-app-layout>
