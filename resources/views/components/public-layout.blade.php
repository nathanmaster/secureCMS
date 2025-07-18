@props(['title' => null, 'description' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'SecureCMS') : config('app.name', 'SecureCMS') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Enable error reporting in console
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
            console.error('Stack trace:', e.error ? e.error.stack : 'No stack trace');
            console.error('File:', e.filename);
            console.error('Line:', e.lineno);
            console.error('Column:', e.colno);
            
            // Also show on page for debugging
            const errorDiv = document.createElement('div');
            errorDiv.style.cssText = 'position: fixed; top: 10px; left: 10px; z-index: 9999; background: red; color: white; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 12px; max-width: 80vw; word-wrap: break-word;';
            errorDiv.innerHTML = `<strong>JavaScript Error:</strong><br>${e.error ? e.error.message : 'Unknown error'}<br><strong>File:</strong> ${e.filename}<br><strong>Line:</strong> ${e.lineno}`;
            document.body.appendChild(errorDiv);
        });
        
        window.addEventListener('unhandledrejection', function(e) {
            console.error('Unhandled Promise Rejection:', e.reason);
            
            // Also show on page for debugging
            const errorDiv = document.createElement('div');
            errorDiv.style.cssText = 'position: fixed; top: 10px; left: 10px; z-index: 9999; background: orange; color: white; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 12px; max-width: 80vw; word-wrap: break-word;';
            errorDiv.innerHTML = `<strong>Promise Rejection:</strong><br>${e.reason}`;
            document.body.appendChild(errorDiv);
        });
        
        // Log when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded');
            console.log('Public layout loaded successfully');
        });
        
        // Add console logging for Alpine.js
        window.Alpine = window.Alpine || {};
        window.Alpine.start = function() {
            console.log('Alpine.js is starting');
        };
    </script>
    
    <style>
        /* Simple purple theme that will definitely work */
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            color: white !important;
            min-height: 100vh !important;
        }
        
        /* Debug - ensure we can see this test div */
        .debug-test {
            background: #ff0000 !important;
            color: #ffffff !important;
            padding: 20px !important;
            margin: 20px !important;
            border: 3px solid #00ff00 !important;
            font-size: 20px !important;
            font-weight: bold !important;
            text-align: center !important;
        }
        
        .nav-bg {
            background: rgba(26, 26, 46, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(139, 92, 246, 0.3) !important;
        }
        
        .btn-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important;
            color: white !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }
        
        .btn-purple:hover {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
            transform: translateY(-1px);
        }
        
        .product-card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 0.75rem;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            border-color: #8b5cf6;
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.2);
        }
        
        .filter-panel {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 0.75rem;
            padding: 1.5rem;
        }
        
        .text-purple {
            color: #a78bfa;
        }
        
        .text-purple-light {
            color: #c4b5fd;
        }
        
        .bg-purple {
            background: #8b5cf6;
        }
        
        .border-purple {
            border-color: #8b5cf6;
        }
        
        /* Ensure text is visible */
        .text-gray-300 {
            color: #d1d5db;
        }
        
        .text-gray-400 {
            color: #9ca3af;
        }
        
        .text-white {
            color: white;
        }
        
        /* Form styling */
        select, input[type="text"], input[type="number"] {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(139, 92, 246, 0.3);
            color: white;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
        }
        
        select:focus, input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        /* Test visibility class */
        .test-visible {
            background: red !important;
            color: white !important;
            padding: 1rem !important;
            border: 2px solid yellow !important;
        }
    </style>
    
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <!-- Simple Navigation -->
    <nav class="nav-bg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('menu') }}" class="text-2xl font-bold text-purple">
                        {{ config('app.name', 'SecureCMS') }}
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('menu') }}" class="text-gray-300 hover:text-purple transition-colors">
                        Menu
                    </a>
                    
                    @auth
                        <a href="{{ route('wishlist.index') }}" class="text-gray-300 hover:text-purple transition-colors">
                            Wishlist
                        </a>
                        
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-purple transition-colors">
                                Admin
                            </a>
                        @endif
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" 
                                    class="text-gray-300 hover:text-purple transition-colors">
                                {{ auth()->user()->name }}
                            </button>
                            
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-purple">
                                    Edit Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:text-red-400">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-purple transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-purple">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @php
            // Enable error reporting for debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
        @endphp
        
        <!-- DEBUG: Test visibility -->
        <div class="debug-test">
            DEBUG: Layout is working. Current time: {{ date('Y-m-d H:i:s') }}
        </div>
        
        {{ $slot }}
    </main>

    <!-- Simple Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'SecureCMS') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
