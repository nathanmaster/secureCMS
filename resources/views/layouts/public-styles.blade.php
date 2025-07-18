    <!-- Custom styles for public theme -->
    <style>
        /* Page transitions */
        .page-transition {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        
        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Dark mode utility classes */
        .dark .bg-gray-50 {
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-dark-secondary) 100%);
        }
        
        .dark .bg-white {
            background: linear-gradient(135deg, var(--bg-dark-secondary) 0%, var(--bg-dark-tertiary) 100%);
            border: 1px solid rgba(124, 58, 237, 0.2);
        }
        
        .dark .text-gray-900 {
            color: #f9fafb;
        }
        
        .dark .text-gray-700 {
            color: #d1d5db;
        }
        
        .dark .text-gray-600 {
            color: #9ca3af;
        }
        
        .dark .border-gray-300 {
            border-color: rgba(124, 58, 237, 0.3);
        }
        
        .dark .border-gray-200 {
            border-color: rgba(124, 58, 237, 0.2);
        }
    </style>
    
    @stack('styles')
