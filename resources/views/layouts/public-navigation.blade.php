<nav class="sticky top-0 z-50 border-b border-gray-600" style="background: rgba(26, 26, 46, 0.9); backdrop-filter: blur(15px);" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('menu') }}" class="text-2xl font-bold text-purple-400 hover:text-purple-300 transition-colors">
                    {{ config('app.name', 'SecureCMS') }}
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('menu') }}" 
                   class="text-gray-300 hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('menu') ? 'text-purple-400' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Menu
                    </div>
                </a>
                
                @auth
                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" 
                       class="text-gray-300 hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors relative {{ request()->routeIs('wishlist.*') ? 'text-purple-400' : '' }}">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Wishlist
                            <span id="wishlist-count" class="ml-2 bg-purple-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ auth()->user()->wishlist_count > 0 ? '' : 'hidden' }}">
                                {{ auth()->user()->wishlist_count }}
                            </span>
                        </div>
                    </a>
                    
                    <!-- Admin Dashboard (if admin) -->
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" 
                           class="text-gray-300 hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Admin
                            </div>
                        </a>
                    @endif
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center text-gray-300 hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ auth()->user()->name }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 z-50"
                             style="display: none; background: rgba(26, 26, 46, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(124, 58, 237, 0.2);">
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-4 py-2 text-sm text-gray-300 hover:text-purple-400 transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profile
                                </div>
                            </a>
                            <hr class="my-1 border-gray-600">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:text-red-400 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login/Register -->
                    <a href="{{ route('login') }}" 
                       class="text-gray-300 hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Login
                        </div>
                    </a>
                    
                    <a href="{{ route('register') }}" 
                       class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Register
                        </div>
                    </a>
                @endauth
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="open = !open" 
                        class="text-gray-300 hover:text-purple-primary focus:outline-none focus:text-purple-primary transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="md:hidden glass-effect border-t border-purple-primary/20"
         style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('menu') }}" 
               class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-purple-primary hover:bg-purple-primary/10 rounded-md transition-colors {{ request()->routeIs('menu') ? 'text-purple-primary bg-purple-primary/10' : '' }}">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Menu
                </div>
            </a>
            
            @auth
                <a href="{{ route('wishlist.index') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-purple-primary hover:bg-purple-primary/10 rounded-md transition-colors {{ request()->routeIs('wishlist.*') ? 'text-purple-primary bg-purple-primary/10' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Wishlist
                        <span id="wishlist-count-mobile" class="ml-2 bg-purple-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ auth()->user()->wishlist_count > 0 ? '' : 'hidden' }}">
                            {{ auth()->user()->wishlist_count }}
                        </span>
                    </div>
                </a>
                
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-purple-primary hover:bg-purple-primary/10 rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Admin Dashboard
                        </div>
                    </a>
                @endif
                
                <a href="{{ route('profile.edit') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-purple-primary hover:bg-purple-primary/10 rounded-md transition-colors">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Profile
                    </div>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left px-3 py-2 text-base font-medium text-gray-300 hover:text-red-400 hover:bg-red-400/10 rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </div>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-purple-primary hover:bg-purple-primary/10 rounded-md transition-colors">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Login
                    </div>
                </a>
                
                <a href="{{ route('register') }}" 
                   class="block px-3 py-2 text-base font-medium bg-purple-primary text-white hover:bg-purple-dark rounded-md transition-colors">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Register
                    </div>
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Progress Bar -->
<div id="progress-bar" class="fixed top-0 left-0 h-1 bg-purple-primary z-50 transition-all duration-300 ease-out" style="width: 0%"></div>

<script>
    // Enhanced page transitions and navigation
    document.addEventListener('DOMContentLoaded', function() {
        const progressBar = document.getElementById('progress-bar');
        
        // Add smooth page transition class to body
        document.body.classList.add('page-transition');
        
        // Handle navigation clicks with smooth transitions
        document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]').forEach(link => {
            link.addEventListener('click', function(e) {
                // Skip if it's a same-page link or external link
                if (this.getAttribute('href').startsWith('#') || 
                    this.getAttribute('href').includes('logout') ||
                    this.hasAttribute('download') ||
                    this.target === '_blank') {
                    return;
                }
                
                // Start progress bar
                progressBar.style.width = '30%';
                
                // Add fade-out effect
                const main = document.querySelector('main');
                if (main) {
                    main.style.opacity = '0.7';
                    main.style.transform = 'translateY(10px)';
                }
            });
        });
        
        // Show progress on navigation
        window.addEventListener('beforeunload', function() {
            progressBar.style.width = '70%';
        });
        
        // Complete progress on load
        window.addEventListener('load', function() {
            progressBar.style.width = '100%';
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 500);
        });
        
        // Smooth scroll for hash links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add hover animations to navigation items
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Add ripple effect to buttons
        document.querySelectorAll('.btn-purple, .hover-lift').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    pointer-events: none;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Add CSS animation for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            .nav-link {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .nav-link:hover {
                transform: translateY(-1px);
                text-shadow: 0 0 8px rgba(124, 58, 237, 0.5);
            }
            
            main {
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            
            .page-transition {
                animation: fadeInUp 0.6s ease-out;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
