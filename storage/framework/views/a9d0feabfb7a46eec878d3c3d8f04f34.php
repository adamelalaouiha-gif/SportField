<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>TerrainBooking</title>
    
    <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.jsx'); ?>
</head>
<body style="margin: 0; background-color: #f3f4f6;">
    <div id="app"></div>
</body>
</html><?php /**PATH D:\xamppp\htdocs\PF\resources\views/welcome.blade.php ENDPATH**/ ?>