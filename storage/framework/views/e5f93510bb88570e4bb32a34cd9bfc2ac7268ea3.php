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
    <nav class="navbar navbar-expand-lg site-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <span class="brand-badge"><i class="fas fa-bag-shopping"></i></span>
                <span>ShopEasy</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavbarNav" aria-controls="siteNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="siteNavbarNav">
                <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>" title="Home">
                            <i class="fas fa-house me-1"></i>Home
                        </a>
                    </li>

                    <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('user.dashboard')); ?>">
                            <i class="fas fa-chart-line me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('orders.*') ? 'active' : ''); ?>" href="<?php echo e(route('orders.index')); ?>">
                            <i class="fas fa-box-open me-1"></i>Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('wishlist.*') ? 'active' : ''); ?>" href="<?php echo e(route('wishlist.index')); ?>">
                            <i class="fas fa-heart me-1"></i>Wishlist
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <div class="site-nav-actions ms-lg-auto">
                    <?php if(auth()->guard()->check()): ?>
                    <a class="btn btn-outline-primary cart-link <?php echo e(request()->routeIs('cart.index') ? 'active' : ''); ?>" href="<?php echo e(route('cart.index')); ?>">
                        <i class="fas fa-cart-shopping"></i>
                        <span class="ms-1">Cart</span>
                        <?php if(($layoutCartCount ?? 0) > 0): ?>
                        <span class="cart-count"><?php echo e($layoutCartCount); ?></span>
                        <?php endif; ?>
                    </a>

                    <?php if(Auth::user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-shield-halved"></i>
                        <span class="ms-1">Admin</span>
                    </a>
                    <?php endif; ?>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <span class="ms-1 nav-user-name"><?php echo e(Auth::user()->name); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo e(route('user.dashboard')); ?>"><i class="fas fa-chart-line me-2 text-primary"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('user.profile')); ?>"><i class="fas fa-user-pen me-2 text-info"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>"><i class="fas fa-box-open me-2 text-success"></i>Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-arrow-right-from-bracket me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-right-to-bracket me-1"></i>Login
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-auto-dismiss="true">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" data-auto-dismiss="true">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if($errors->any() && !request()->routeIs('user.profile') && !request()->routeIs('checkout')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
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

</html><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/layouts/app.blade.php ENDPATH**/ ?>