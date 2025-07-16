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
                {{-- TODO: Uncomment when reports functionality is implemented --}}
                {{-- <button onclick="switchToAnalytics()" 
                        class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    View Reports
                </button> --}}
                <button onclick="toggleSystemHealth()" 
                        class="btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    System Health
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
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>'
                />
                <x-stats-card 
                    title="Total Users" 
                    value="{{ number_format($stats['total_users']) }}" 
                    description="Registered users"
                    color="green"
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>'
                />
                <x-stats-card 
                    title="Comments" 
                    value="{{ number_format($stats['total_comments']) }}" 
                    description="{{ $stats['pending_comments'] }} pending approval"
                    color="yellow"
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>'
                />
                <x-stats-card 
                    title="Average Rating" 
                    value="{{ number_format($stats['average_rating'], 1) }}" 
                    description="From {{ number_format($stats['total_ratings']) }} ratings"
                    color="purple"
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'
                />
            </x-grid>

            <!-- Additional Stats Grid -->
            <x-grid cols="2" gap="6">
                <x-stats-card 
                    title="Categories" 
                    value="{{ number_format($stats['total_categories']) }}" 
                    description="Product categories"
                    color="indigo"
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'
                />
                <x-stats-card 
                    title="Active Products" 
                    value="{{ number_format($stats['active_products']) }}" 
                    description="Available for sale"
                    color="teal"
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
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
                                        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Category
                                        </a>
                                        <a href="{{ route('admin.users.index') }}" class="btn-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            Manage Users
                                        </a>
                                        <a href="{{ route('admin.comments.index') }}" class="btn-primary">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            Manage Comments
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

    <!-- System Health Modal -->
    <div id="systemHealthModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">System Health Status</h3>
                        <button onclick="toggleSystemHealth()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Database</span>
                            </div>
                            <span class="text-sm text-green-600 dark:text-green-400">Online</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Cache System</span>
                            </div>
                            <span class="text-sm text-green-600 dark:text-green-400">Active</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Storage</span>
                            </div>
                            <span class="text-sm text-green-600 dark:text-green-400">Available</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Last Backup</span>
                            </div>
                            <span class="text-sm text-yellow-600 dark:text-yellow-400">{{ now()->subHours(2)->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button onclick="refreshSystemHealth()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh
                        </button>
                        <button onclick="toggleSystemHealth()" class="btn-primary">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchToAnalytics() {
            // Find the tabs container and switch to analytics tab
            const tabsContainer = document.querySelector('[x-data*="activeTab"]');
            if (tabsContainer) {
                // Use Alpine.js to switch tab
                tabsContainer.__x.$data.activeTab = 'analytics';
                
                // Scroll to the tabs section
                document.querySelector('[x-data*="activeTab"]').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start' 
                });
            }
        }

        function toggleSystemHealth() {
            const modal = document.getElementById('systemHealthModal');
            modal.classList.toggle('hidden');
        }

        function refreshSystemHealth() {
            // Add a loading state
            const refreshBtn = document.querySelector('button[onclick="refreshSystemHealth()"]');
            const originalText = refreshBtn.innerHTML;
            refreshBtn.disabled = true;
            refreshBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Refreshing...';
            
            // Simulate refresh delay
            setTimeout(() => {
                refreshBtn.disabled = false;
                refreshBtn.innerHTML = originalText;
                showNotification('System health refreshed successfully!', 'success');
            }, 1000);
        }

        // Close modal when clicking outside
        document.getElementById('systemHealthModal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleSystemHealth();
            }
        });
    </script>
</x-app-layout>
