<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ShopEasy - Your one-stop online shopping destination. Browse products, manage orders, and shop with confidence.">
    <title><?php echo $__env->yieldContent('title', 'ShopEasy - Online Shopping'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0a58ca;
            --bg-light: #f0f2f5;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }
        html { height: 100%; }
        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            color: var(--text-dark);
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
            box-shadow: 0 2px 15px rgba(13, 110, 253, 0.3);
            padding: 0.6rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
        }
        .navbar .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s ease;
            border-radius: 8px;
            margin: 0 2px;
        }
        .navbar .nav-link:hover {
            background: rgba(255,255,255,0.15);
        }
        .cart-badge {
            position: relative;
        }
        .cart-badge .badge {
            position: absolute;
            top: -2px;
            right: -4px;
            font-size: 0.65rem;
            padding: 3px 6px;
            border-radius: 50%;
            background-color: #ff4757 !important;
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 600;
        }

        /* ===== PRODUCT CARDS ===== */
        .product-card {
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-4px);
        }
        .product-image-container {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
        }
        .product-image-container img {
            max-height: 180px;
            width: auto;
            object-fit: contain;
        }

        /* ===== PRICE ===== */
        .price-tag {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border: none;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0a58ca, #084298);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }

        /* ===== CATEGORY FILTER ===== */
        .category-btn {
            padding: 8px 18px;
            margin: 4px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .category-btn.active,
        .category-btn:hover {
            background-color: var(--primary);
            color: #fff;
            transform: translateY(-1px);
        }

        /* ===== BADGE ===== */
        .badge-custom {
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: #212529;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* ===== STATUS BADGES ===== */
        .badge-status-pending { background-color: #ffc107; color: #212529; }
        .badge-status-processing { background-color: #17a2b8; color: #fff; }
        .badge-status-completed { background-color: #28a745; color: #fff; }
        .badge-status-cancelled { background-color: #dc3545; color: #fff; }

        /* ===== ALERTS ===== */
        .alert {
            border: none;
            border-radius: 10px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* ===== MAIN + FOOTER ===== */
        main { flex: 1; }
        footer {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            margin-top: auto;
        }
        footer a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.2s;
        }
        footer a:hover { color: #fff; }

        /* ===== DROPDOWN ===== */
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            padding: 8px;
        }
        .dropdown-item {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: background 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f0f2f5;
        }
        .dropdown-divider {
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <!-- ===== NAVIGATION BAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-shopping-bag"></i> ShopEasy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Home Link (Always visible) -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>

                    <?php if(auth()->guard()->check()): ?>
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('user.dashboard')); ?>">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>

                        <!-- Cart with Count -->
                        <li class="nav-item">
                            <a class="nav-link cart-badge <?php echo e(request()->routeIs('cart.index') ? 'active' : ''); ?>" href="<?php echo e(route('cart.index')); ?>">
                                <i class="fas fa-shopping-cart"></i> Cart
                                <?php
                                    $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                                ?>
                                <?php if($cartCount > 0): ?>
                                    <span class="badge"><?php echo e($cartCount); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- My Orders -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('orders.*') ? 'active' : ''); ?>" href="<?php echo e(route('orders.index')); ?>">
                                <i class="fas fa-box"></i> Orders
                            </a>
                        </li>

                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> <?php echo e(Auth::user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('user.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt text-primary"></i> My Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('user.profile')); ?>">
                                        <i class="fas fa-user-edit text-info"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                        <i class="fas fa-box text-success"></i> My Orders
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <?php if(Auth::user()->isAdmin()): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                            <i class="fas fa-shield-alt text-danger"></i> Admin Panel
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Guest Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light btn-sm ms-2 px-3" href="<?php echo e(route('register')); ?>">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== ALERT MESSAGES ===== -->
    <div class="container mt-3">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

    <!-- ===== MAIN CONTENT ===== -->
    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="fw-bold"><i class="fas fa-shopping-bag"></i> ShopEasy</h6>
                    <small class="text-white-50">Your trusted online shopping destination.</small>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="fw-bold">Quick Links</h6>
                    <div class="d-flex flex-column">
                        <a href="<?php echo e(route('home')); ?>"><small>Browse Products</small></a>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>"><small>My Dashboard</small></a>
                            <a href="<?php echo e(route('orders.index')); ?>"><small>My Orders</small></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <h6 class="fw-bold">Contact</h6>
                    <small class="text-white-50">
                        <i class="fas fa-envelope"></i> support@shopeasy.com<br>
                        <i class="fas fa-phone"></i> +91-9876543210
                    </small>
                </div>
            </div>
            <hr class="my-3" style="border-color: rgba(255,255,255,0.1);">
            <p class="text-center text-white-50 mb-0">
                <small>&copy; 2026 ShopEasy - Online Shopping Management System. All rights reserved.</small>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/layouts/app.blade.php ENDPATH**/ ?>