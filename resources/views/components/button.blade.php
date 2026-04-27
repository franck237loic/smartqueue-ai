{{-- Unified Button Component - Mobile First --}}
@props([
    'variant' => 'primary', // 'primary', 'secondary', 'outline', 'ghost', 'danger'
    'size' => 'normal', // 'small', 'normal', 'large'
    'disabled' => false,
    'loading' => false,
    'fullWidth' => false,
    'href' => null,
    'type' => 'button',
    'class' => ''
])

@php
    $variantClasses = match($variant) {
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2',
        'outline' => 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2',
        'ghost' => 'text-gray-700 hover:bg-gray-100 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2',
        default => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2'
    };

    $sizeClasses = match($size) {
        'small' => 'px-3 py-1.5 text-sm',
        'normal' => 'px-4 py-2 text-sm sm:text-base',
        'large' => 'px-6 py-3 text-base sm:text-lg',
        default => 'px-4 py-2 text-sm sm:text-base'
    };

    $disabledClasses = $disabled || $loading ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';
    $widthClasses = $fullWidth ? 'w-full' : '';
@endphp

@if($href)
    <a href="{{ $href }}" 
       class="inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-colors duration-200 {{ $variantClasses }} {{ $sizeClasses }} {{ $disabledClasses }} {{ $widthClasses }} {{ $class }}"
       {{ $disabled ? 'tabindex="-1" : '' }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" 
            {{ $disabled ? 'disabled' : '' }}
            class="inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-colors duration-200 {{ $variantClasses }} {{ $sizeClasses }} {{ $disabledClasses }} {{ $widthClasses }} {{ $class }}">
        @if($loading)
            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Chargement...</span>
        @else
            {{ $slot }}
        @endif
    </button>
@endif
