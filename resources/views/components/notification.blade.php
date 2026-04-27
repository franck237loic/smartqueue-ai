{{-- Notification Component - Mobile First --}}
@props([
    'type' => 'info', // 'success', 'error', 'warning', 'info'
    'title' => null,
    'message' => '',
    'dismissible' => true,
    'timeout' => null
])

@php
    $typeClasses = match($type) {
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
        default => 'bg-blue-50 border-blue-200 text-blue-800'
    };

    $iconClasses = match($type) {
        'success' => 'text-green-600',
        'error' => 'text-red-600',
        'warning' => 'text-amber-600',
        'info' => 'text-blue-600',
        default => 'text-blue-600'
    };

    $iconSvg = match($type) {
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
        'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    };
@endphp

<div class="notification-container fixed top-4 right-4 z-50 max-w-sm w-full sm:max-w-md">
    <div class="notification {{ $typeClasses }} border rounded-lg p-4 shadow-lg animate-slide-in-right" 
         @if($timeout) data-timeout="{{ $timeout }}" @endif>
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 {{ $iconClasses }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {{ $iconSvg }}
                </svg>
            </div>
            <div class="ml-3 flex-1">
                @if($title)
                    <h3 class="text-sm font-medium">{{ $title }}</h3>
                @endif
                <p class="text-sm {{ $title ? 'mt-1' : '' }}">{{ $message }}</p>
            </div>
            @if($dismissible)
                <div class="ml-4 flex-shrink-0">
                    <button class="notification-close inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .notification {
        animation: slideInRight 0.3s ease-out;
    }
    
    .notification.removing {
        animation: slideOutRight 0.3s ease-out forwards;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>
