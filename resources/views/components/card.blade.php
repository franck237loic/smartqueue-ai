{{-- Unified Card Component - Mobile First --}}
@props([
    'title' => null,
    'subtitle' => null,
    'actions' => [],
    'padding' => 'normal', // 'tight', 'normal', 'loose'
    'elevation' => 'normal', // 'none', 'normal', 'high'
    'border' => true,
    'hover' => false,
    'class' => ''
])

@php
    $paddingClasses = match($padding) {
        'tight' => 'p-3 sm:p-4',
        'normal' => 'p-4 sm:p-6',
        'loose' => 'p-6 sm:p-8',
        default => 'p-4 sm:p-6'
    };

    $elevationClasses = match($elevation) {
        'none' => '',
        'normal' => 'shadow-sm',
        'high' => 'shadow-lg',
        default => 'shadow-sm'
    };

    $hoverClasses = $hover ? 'hover:shadow-md hover:-translate-y-0.5 transition-all duration-200' : '';
@endphp

<div class="bg-white rounded-xl {{ $border ? 'border border-gray-200' : '' }} {{ $elevationClasses }} {{ $hoverClasses }} {{ $paddingClasses }} {{ $class }}">
    @if($title || $actions)
        <div class="flex items-start justify-between mb-4">
            @if($title)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                    @if($subtitle)
                        <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif
            
            @if($actions && count($actions) > 0)
                <div class="flex items-center gap-2">
                    @foreach($actions as $action)
                        {{ $action }}
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
