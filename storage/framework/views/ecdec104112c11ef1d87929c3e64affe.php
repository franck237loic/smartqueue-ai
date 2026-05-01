
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'subtitle' => null,
    'actions' => [],
    'padding' => 'normal', // 'tight', 'normal', 'loose'
    'elevation' => 'normal', // 'none', 'normal', 'high'
    'border' => true,
    'hover' => false,
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
    'title' => null,
    'subtitle' => null,
    'actions' => [],
    'padding' => 'normal', // 'tight', 'normal', 'loose'
    'elevation' => 'normal', // 'none', 'normal', 'high'
    'border' => true,
    'hover' => false,
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
?>

<div class="bg-white rounded-xl <?php echo e($border ? 'border border-gray-200' : ''); ?> <?php echo e($elevationClasses); ?> <?php echo e($hoverClasses); ?> <?php echo e($paddingClasses); ?> <?php echo e($class); ?>">
    <?php if($title || $actions): ?>
        <div class="flex items-start justify-between mb-4">
            <?php if($title): ?>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900"><?php echo e($title); ?></h3>
                    <?php if($subtitle): ?>
                        <p class="text-sm text-gray-500 mt-1"><?php echo e($subtitle); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if($actions && count($actions) > 0): ?>
                <div class="flex items-center gap-2">
                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($action); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php echo e($slot); ?>

</div>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\components\card.blade.php ENDPATH**/ ?>