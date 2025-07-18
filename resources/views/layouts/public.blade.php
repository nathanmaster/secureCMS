<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'SecureCMS') : config('app.name', 'SecureCMS') }}</title>
    
    <!-- Meta Description -->
    <meta name="description" content="{{ $description ?? 'SecureCMS - A modern content management system' }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom styles for public theme -->
    <style>
        /* Custom Purple Theme */
        :root {
            --primary-purple: #7c3aed;
            --primary-purple-dark: #6d28d9;
            --primary-purple-light: #8b5cf6;
            --secondary-purple: #a855f7;
            --accent-purple: #c084fc;
            --bg-dark: #0f0f23;
            --bg-dark-secondary: #1a1a2e;
            --bg-dark-tertiary: #16213e;
            --purple-glow: 0 0 20px rgba(124, 58, 237, 0.3);
            --purple-subtle: rgba(124, 58, 237, 0.1);
        }

        /* Enhanced Dark Mode Styles */
        .dark {
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-dark-secondary) 100%);
            color: #f9fafb;
        }
        
        .dark .bg-gray-50 {
            background-color: var(--bg-dark);
        }
        
        .dark .bg-white {
            background-color: var(--bg-dark-secondary);
            border: 1px solid rgba(124, 58, 237, 0.1);
        }
        
        .dark .bg-gray-800 {
            background-color: var(--bg-dark-secondary);
            border: 1px solid rgba(124, 58, 237, 0.1);
        }
        
        .dark .bg-gray-900 {
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-dark-secondary) 100%);
        }
        
        .dark .text-gray-900 {
            color: #f9fafb;
        }
        
        .dark .text-gray-800 {
            color: #f3f4f6;
        }
        
        .dark .text-gray-700 {
            color: #d1d5db;
        }
        
        .dark .text-gray-600 {
            color: #9ca3af;
        }
        
        .dark .text-gray-500 {
            color: #6b7280;
        }
        
        .dark .text-gray-400 {
            color: #9ca3af;
        }
        
        .dark .border-gray-300 {
            border-color: rgba(124, 58, 237, 0.3);
        }
        
        .dark .border-gray-200 {
            border-color: rgba(124, 58, 237, 0.2);
        }
        
        .dark .border-gray-700 {
            border-color: rgba(124, 58, 237, 0.2);
        }
        
        .dark .bg-gray-100 {
            background-color: rgba(124, 58, 237, 0.1);
        }
        
        .dark .bg-gray-200 {
            background-color: rgba(124, 58, 237, 0.15);
        }

        /* Enhanced Purple Theme Classes */
        .text-purple-primary {
            color: var(--primary-purple);
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.3);
        }
        
        .text-purple-secondary {
            color: var(--secondary-purple);
        }
        
        .text-purple-accent {
            color: var(--accent-purple);
        }
        
        .text-purple-light {
            color: var(--primary-purple-light);
        }
        
        .bg-purple-primary {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-purple-dark) 100%);
            box-shadow: var(--purple-glow);
        }
        
        .bg-purple-secondary {
            background: linear-gradient(135deg, var(--secondary-purple) 0%, var(--primary-purple) 100%);
        }
        
        .bg-purple-accent {
            background: linear-gradient(135deg, var(--accent-purple) 0%, var(--secondary-purple) 100%);
        }
        
        .hover\:bg-purple-primary:hover {
            background: linear-gradient(135deg, var(--primary-purple-light) 0%, var(--primary-purple) 100%);
            box-shadow: var(--purple-glow);
        }
        
        .hover\:bg-purple-dark:hover {
            background: linear-gradient(135deg, var(--primary-purple-dark) 0%, #581c87 100%);
        }
        
        .hover\:text-purple-primary:hover {
            color: var(--primary-purple);
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.5);
        }
        
        .hover\:text-purple-light:hover {
            color: var(--primary-purple-light);
            text-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
        }
        
        .border-purple-primary {
            border-color: var(--primary-purple);
        }
        
        .focus\:ring-purple-primary:focus {
            --tw-ring-color: var(--primary-purple);
            box-shadow: 0 0 0 3px var(--purple-subtle);
        }

        /* Enhanced transitions and animations */
        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Page transitions */
        .page-transition {
            opacity: 1;
            transform: translateY(0);
            animation: fadeInUp 0.6s ease-out forwards;
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
        
        /* Enhanced hover effects */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(124, 58, 237, 0.2);
        }
        
        /* Custom scrollbar with purple theme */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--secondary-purple) 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-purple-light) 0%, var(--primary-purple) 100%);
        }

        /* Enhanced gradient backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-dark-secondary) 50%, var(--bg-dark-tertiary) 100%);
        }
        
        .gradient-purple {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--secondary-purple) 100%);
        }
        
        /* Enhanced glass effect */
        .glass-effect {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(124, 58, 237, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        /* Enhanced navigation styles */
        .nav-link {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(124, 58, 237, 0.3), transparent);
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link:hover::before {
            left: 100%;
        }
        
        .nav-link:hover {
            transform: translateY(-1px);
            text-shadow: 0 0 8px rgba(124, 58, 237, 0.5);
        }
        
        /* Enhanced button styles */
        .btn-purple {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-purple-dark) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-purple::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }
        
        .btn-purple:hover::before {
            left: 100%;
        }
        
        .btn-purple:hover {
            background: linear-gradient(135deg, var(--primary-purple-light) 0%, var(--primary-purple) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        }
        
        /* Enhanced card styles */
        .card-purple {
            background: linear-gradient(135deg, var(--bg-dark-secondary) 0%, var(--bg-dark-tertiary) 100%);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-purple:hover {
            border-color: var(--primary-purple);
            box-shadow: 0 8px 30px rgba(124, 58, 237, 0.2);
            transform: translateY(-2px);
        }
        
        /* Enhanced input styles */
        .input-purple {
            background: linear-gradient(135deg, var(--bg-dark-secondary) 0%, var(--bg-dark-tertiary) 100%);
            border: 1px solid rgba(124, 58, 237, 0.3);
            color: #f9fafb;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .input-purple:focus {
            outline: none;
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px var(--purple-subtle), 0 0 20px rgba(124, 58, 237, 0.2);
        }
        
        .input-purple::placeholder {
            color: #9ca3af;
        }

        /* Dual Range Slider */
        .dual-range-slider {
            position: relative;
            width: 100%;
            height: 6px;
            background: #374151;
            border-radius: 3px;
            outline: none;
        }
        
        .dual-range-slider input[type="range"] {
            position: absolute;
            width: 100%;
            height: 6px;
            background: transparent;
            -webkit-appearance: none;
            appearance: none;
            pointer-events: none;
            outline: none;
        }
        
        .dual-range-slider input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary-purple);
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            pointer-events: auto;
            position: relative;
            z-index: 2;
        }
        
        .dual-range-slider input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary-purple);
            cursor: pointer;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            pointer-events: auto;
        }
        
        .dual-range-slider input[type="range"]:hover::-webkit-slider-thumb {
            background: var(--primary-purple-dark);
        }
        
        .dual-range-slider input[type="range"]:hover::-moz-range-thumb {
            background: var(--primary-purple-dark);
        }
        
        .dual-range-slider .slider-track {
            position: absolute;
            height: 6px;
            background: var(--primary-purple);
            border-radius: 3px;
            pointer-events: none;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Loading animation */
        .loading-spinner {
            border: 2px solid rgba(124, 58, 237, 0.3);
            border-top: 2px solid var(--primary-purple);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }
        
        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        .notification.success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .notification.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .notification.info {
            background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple));
            color: white;
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased gradient-bg text-white dark min-h-screen">
    <div class="page-transition">
        <!-- Public Navigation -->
        @include('layouts.public-navigation')
        
        <!-- Main Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>
        
        <!-- Footer -->
        @include('layouts.public-footer')
    </div>
    
    <!-- Notification Container -->
    <div id="notification-container"></div>
    
    @stack('scripts')
    
    <!-- Global JavaScript -->
    <script>
        // Page transition effect
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="/"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.hostname !== window.location.hostname) return;
                    
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    
                    // Fade out current page
                    document.querySelector('.page-transition').style.opacity = '0';
                    document.querySelector('.page-transition').style.transform = 'translateY(-20px)';
                    
                    // Navigate after transition
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300);
                });
            });
        });
        
        // Notification system
        function showNotification(message, type = 'info', duration = 5000) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="flex items-center justify-between">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto remove
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, duration);
        }
        
        // Global error handling
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
        });
        
        // CSRF token setup for AJAX requests
        window.axios = window.axios || {};
        window.axios.defaults = window.axios.defaults || {};
        window.axios.defaults.headers = window.axios.defaults.headers || {};
        window.axios.defaults.headers.common = window.axios.defaults.headers.common || {};
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }
    </script>
</body>
</html>
