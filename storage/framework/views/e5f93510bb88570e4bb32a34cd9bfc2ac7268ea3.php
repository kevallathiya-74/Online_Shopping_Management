<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ShopEasy - Your one-stop online shopping destination. Browse products, manage orders, and shop with confidence.">
    <title><?php echo $__env->yieldContent('title', 'ShopEasy - Online Shopping'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('css/theme.css')); ?>?v=<?php echo e(filemtime(public_path('css/theme.css'))); ?>" rel="stylesheet">
</head>

<body class="app-shell <?php echo $__env->yieldContent('body_class'); ?>">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => ['cartCount' => $layoutCartCount ?? 0]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cart-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($layoutCartCount ?? 0)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="container component-alerts mt-3">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.flash-messages','data' => ['suppressErrors' => request()->routeIs('user.profile') || request()->routeIs('checkout') || request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('flash-messages'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['suppress-errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('user.profile') || request()->routeIs('checkout') || request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>

    <main class="site-main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="site-footer mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6><i class="fas fa-bag-shopping me-2"></i>ShopEasy</h6>
                    <small>Your trusted shopping destination for quality products and smooth order tracking.</small>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6>Quick Links</h6>
                    <div class="d-flex flex-column">
                        <a href="<?php echo e(route('home')); ?>"><small>Browse Products</small></a>
                        <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('user.dashboard')); ?>"><small>My Dashboard</small></a>
                        <a href="<?php echo e(route('cart.index')); ?>"><small>My Cart</small></a>
                        <a href="<?php echo e(route('orders.index')); ?>"><small>My Orders</small></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <h6>Contact</h6>
                    <small>
                        <i class="fas fa-envelope"></i> support@shopeasy.com<br>
                        <i class="fas fa-phone"></i> +91-9876543210
                    </small>
                </div>
            </div>
            <hr class="my-3 footer-divider">
            <p class="text-center mb-0 footer-note">
                <small>&copy; 2026 ShopEasy - Online Shopping Management System. All rights reserved.</small>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            document.querySelectorAll('.alert[data-auto-dismiss="true"]').forEach(function(alert) {
                var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/layouts/app.blade.php ENDPATH**/ ?>