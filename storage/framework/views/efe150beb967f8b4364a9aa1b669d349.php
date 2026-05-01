<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'SmartQueue AI'); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Mobile Optimizations -->
    <meta name="theme-color" content="#2563eb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    
    <!-- Design System Styles -->
    <style>
        * { 
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        
        body {
            overscroll-behavior: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Mobile-first spacing */
        .container-safe {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        @media (min-width: 640px) {
            .container-safe {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
        
        @media (min-width: 1024px) {
            .container-safe {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        
        /* Touch-friendly sizing */
        .touch-target {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* Safe areas for notched devices */
        .safe-area-top {
            padding-top: env(safe-area-inset-top);
        }
        
        .safe-area-bottom {
            padding-bottom: env(safe-area-inset-bottom);
        }
        
        /* Component styles */
        .btn-primary {
            @apply bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 active:bg-blue-800 transition-colors duration-200;
        }
        
        .btn-secondary {
            @apply bg-gray-100 text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 active:bg-gray-300 transition-colors duration-200;
        }
        
        .card {
            @apply bg-white border border-gray-200 rounded-xl p-4 shadow-sm;
        }
        
        .input-field {
            @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
        }
        
        /* Animations */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.2s ease-out;
        }
        
        /* Mobile menu transitions */
        .mobile-menu-enter {
            transform: translateX(100%);
        }
        
        .mobile-menu-enter-active {
            transform: translateX(0);
            transition: transform 0.3s ease-out;
        }
        
        .mobile-menu-exit {
            transform: translateX(0);
        }
        
        .mobile-menu-exit-active {
            transform: translateX(100%);
            transition: transform 0.3s ease-in;
        }
        
        /* Status colors */
        .status-waiting { @apply text-gray-600 bg-gray-50; }
        .status-called { @apply text-blue-600 bg-blue-50; }
        .status-serving { @apply text-green-600 bg-green-50; }
        .status-missed { @apply text-red-600 bg-red-50; }
        .status-served { @apply text-gray-500 bg-gray-50; }
        
        /* Loading states */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.6;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
        <div id="mobile-menu" class="fixed right-0 top-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold">Menu</h2>
                <button id="close-mobile-menu" class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-4 space-y-2">
                <?php echo $__env->yieldContent('mobile-menu'); ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen">
        <!-- Header -->
        <?php echo $__env->yieldContent('header'); ?>
        
        <!-- Page Content -->
        <main class="pb-20 md:pb-0">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        
        <!-- Mobile Navigation -->
        <?php echo $__env->yieldContent('mobile-nav'); ?>
        
        <!-- Desktop Sidebar (hidden on mobile) -->
        <?php echo $__env->yieldContent('desktop-sidebar'); ?>
    </div>

    <!-- Notifications Container -->
    <div id="notifications" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Scripts -->
    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
        
        function openMobileMenu() {
            mobileMenuOverlay.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.classList.remove('translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileMenu() {
            mobileMenu.classList.add('translate-x-full');
            setTimeout(() => {
                mobileMenuOverlay.classList.add('hidden');
            }, 300);
            document.body.style.overflow = '';
        }
        
        mobileMenuBtn?.addEventListener('click', openMobileMenu);
        closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
        
        mobileMenuOverlay?.addEventListener('click', (e) => {
            if (e.target === mobileMenuOverlay) {
                closeMobileMenu();
            }
        });
        
        // Notification system
        window.showNotification = function(message, type = 'info', title = null) {
            const container = document.getElementById('notifications');
            const notification = document.createElement('div');
            notification.className = `notification animate-slide-up p-4 rounded-lg shadow-lg max-w-sm w-full ${
                type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' :
                type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' :
                type === 'warning' ? 'bg-amber-50 border border-amber-200 text-amber-800' :
                'bg-blue-50 border border-blue-200 text-blue-800'
            }`;
            
            notification.innerHTML = `
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' :
                              type === 'error' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>' :
                              type === 'warning' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>' :
                              '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'}
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        ${title ? `<h3 class="text-sm font-medium">${title}</h3>` : ''}
                        <p class="text-sm ${title ? 'mt-1' : ''}">${message}</p>
                    </div>
                    <button class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.closest('.notification').remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        };
        
        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !mobileMenuOverlay.classList.contains('hidden')) {
                closeMobileMenu();
            }
        });
        
        // Initialize Lucide icons if available
        if (window.lucide) {
            window.lucide.createIcons();
        }
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\layouts\mobile-first.blade.php ENDPATH**/ ?>