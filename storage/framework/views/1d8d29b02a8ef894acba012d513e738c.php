<!DOCTYPE html>
<html>
<head>
    <title>Debug Error</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .error { color: #d32f2f; background: #ffebee; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .file { color: #1976d2; }
        .line { color: #388e3c; }
        .trace { background: #f5f5f5; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 12px; white-space: pre-wrap; max-height: 200px; overflow-y: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Debug Information</h1>
        
        <div class="error">
            <strong>Error:</strong> <?php echo e($error); ?>

        </div>
        
        <p><strong>File:</strong> <span class="file"><?php echo e($file); ?></span></p>
        <p><strong>Line:</strong> <span class="line"><?php echo e($line); ?></span></p>
        
        <h3>Stack Trace:</h3>
        <div class="trace"><?php echo e($trace); ?></div>
        
        <p><a href="<?php echo e(url('/test-debug')); ?>">Test Debug Route</a></p>
        <p><a href="<?php echo e(url('/test-agent')); ?>">Test Agent Route</a></p>
        <p><a href="<?php echo e(url('/test-dashboard-simple')); ?>">Test Dashboard Simple</a></p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\errors\debug.blade.php ENDPATH**/ ?>