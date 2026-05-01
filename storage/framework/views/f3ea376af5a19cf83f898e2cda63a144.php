
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'primary', // 'primary', 'secondary', 'outline', 'ghost', 'danger'
    'size' => 'normal', // 'small', 'normal', 'large'
    'disabled' => false,
    'loading' => false,
    'fullWidth' => false,
    'href' => null,
    'type' => 'button',
    'class' => ''
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'variant' => 'primary', // 'primary', 'secondary', 'outline', 'ghost', 'danger'
    'size' => 'normal', // 'small', 'normal', 'large'
    'disabled' => false,
    'loading' => false,
    'fullWidth' => false,
    'href' => null,
    'type' => 'button',
    'class' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>

<?php if($href): ?>
    <a href="<?php echo e($href); ?>" 
       class="inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-colors duration-200 <?php echo e($variantClasses); ?> <?php echo e($sizeClasses); ?> <?php echo e($disabledClasses); ?> <?php echo e($widthClasses); ?> <?php echo e($class); ?>"
       <?php echo e($disabled ? 'tabindex="-1" : ''); ?>>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" 
            <?php echo e($disabled ? 'disabled' : ''); ?>

            class="inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-colors duration-200 <?php echo e($variantClasses); ?> <?php echo e($sizeClasses); ?> <?php echo e($disabledClasses); ?> <?php echo e($widthClasses); ?> <?php echo e($class); ?>">
        <?php if($loading): ?>
            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Chargement...</span>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </button>
<?php endif; ?>
 ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\components\button.blade.php ENDPATH**/ ?>