<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - Online Shopping Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* ===== TOP NAVBAR ===== */
        .admin-navbar {
            background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
            padding: 0 20px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .admin-navbar .brand {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-navbar .brand i {
            font-size: 1.4rem;
        }
        .admin-navbar .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .admin-navbar .nav-right .admin-name {
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
        }
        .admin-navbar .nav-right .admin-name i {
            margin-right: 5px;
        }
        .admin-navbar .btn-logout {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 6px 15px;
            border-radius: 5px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .admin-navbar .btn-logout:hover {
            background: rgba(255,255,255,0.25);
        }
        .admin-navbar .visit-site {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .admin-navbar .visit-site:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .sidebar-toggle {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.3rem;
            cursor: pointer;
            display: none;
            padding: 5px 10px;
        }

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1a237e 0%, #0d47a1 50%, #1565c0 100%);
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 1030;
            transition: transform 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .admin-sidebar .sidebar-header {
            padding: 20px 20px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-sidebar .sidebar-header h6 {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0;
        }
        .admin-sidebar .nav-menu {
            list-style: none;
            padding: 10px 0;
            margin: 0;
        }
        .admin-sidebar .nav-menu li {
            margin: 2px 10px;
        }
        .admin-sidebar .nav-menu a {
            display: flex;
            align-items: center;
            padding: 11px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.2s;
            gap: 12px;
        }
        .admin-sidebar .nav-menu a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }
        .admin-sidebar .nav-menu a:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }
        .admin-sidebar .nav-menu a.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .admin-sidebar .nav-divider {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin: 10px 15px;
        }
        .admin-sidebar .nav-section-label {
            padding: 10px 25px 5px;
            color: rgba(255,255,255,0.4);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* ===== MAIN CONTENT ===== */
        .admin-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 25px;
            min-height: calc(100vh - 60px);
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e3e6f0;
            box-shadow: 0 1px 5px rgba(0,0,0,0.05);
        }
        .page-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 3px;
        }
        .page-header p {
            color: #6c757d;
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        /* ===== CARDS ===== */
        .card {
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.05);
        }
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border: none;
            border-radius: 10px;
            color: #fff;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-card .card-body {
            padding: 20px;
            position: relative;
        }
        .stat-card .stat-icon {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 2.5rem;
            opacity: 0.3;
        }
        .stat-card .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
        }
        .stat-card.bg-gradient-primary {
            background: linear-gradient(135deg, #1a237e, #1565c0);
        }
        .stat-card.bg-gradient-success {
            background: linear-gradient(135deg, #1b5e20, #43a047);
        }
        .stat-card.bg-gradient-info {
            background: linear-gradient(135deg, #01579b, #0288d1);
        }
        .stat-card.bg-gradient-warning {
            background: linear-gradient(135deg, #e65100, #fb8c00);
        }

        /* ===== TABLE STYLES ===== */
        .table thead th {
            background-color: #f8f9fc;
            border-bottom: 2px solid #e3e6f0;
            color: #1a237e;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.78rem;
            padding: 12px 15px;
            letter-spacing: 0.5px;
        }
        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            color: #333;
        }
        .table-hover tbody tr:hover {
            background-color: #f0f4ff;
        }

        /* ===== STATUS BADGES ===== */
        .badge-status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
        }
        .badge-status-processing {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #007bff;
        }
        .badge-status-completed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #28a745;
        }
        .badge-status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #dc3545;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, #1a237e, #1565c0);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0d1b6e, #0d47a1);
        }

        /* ===== ALERT STYLES ===== */
        .alert {
            border-radius: 8px;
            border: none;
            font-size: 0.9rem;
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
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        /* ===== PAGINATION ===== */
        .pagination .page-link {
            color: #1a237e;
            border: 1px solid #dee2e6;
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #1a237e, #1565c0);
            border-color: #1a237e;
        }

        /* ===== FORM STYLES ===== */
        .form-control:focus, .form-select:focus {
            border-color: #1565c0;
            box-shadow: 0 0 0 0.2rem rgba(21,101,192,0.15);
        }
        .form-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        /* ===== VALIDATION ERROR ===== */
        .invalid-feedback {
            font-size: 0.85rem;
        }

        /* ===== SIDEBAR OVERLAY FOR MOBILE ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1025;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .admin-content {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: inline-block;
            }
        }

        /* ===== SCROLLBAR ===== */
        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="admin-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand">
                <i class="fas fa-shield-alt"></i>
                Admin Panel
            </a>
        </div>
        <div class="nav-right">
            <a href="<?php echo e(route('home')); ?>" class="visit-site" target="_blank">
                <i class="fas fa-external-link-alt"></i> Visit Site
            </a>
            <span class="admin-name d-none d-md-inline">
                <i class="fas fa-user-shield"></i> <?php echo e(Auth::user()->name); ?>

            </span>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <h6>Main Navigation</h6>
        </div>
        <ul class="nav-menu">
            <li>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <div class="nav-divider"></div>
            <div class="nav-section-label">Management</div>

            <li>
                <a href="<?php echo e(route('admin.categories')); ?>" class="<?php echo e(request()->routeIs('admin.categories*') ? 'active' : ''); ?>">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.products')); ?>" class="<?php echo e(request()->routeIs('admin.products*') ? 'active' : ''); ?>">
                    <i class="fas fa-box-open"></i> Products
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.orders')); ?>" class="<?php echo e(request()->routeIs('admin.orders*') ? 'active' : ''); ?>">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>

            <div class="nav-divider"></div>
            <div class="nav-section-label">System</div>

            <li>
                <a href="<?php echo e(route('admin.users')); ?>" class="<?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
                    <i class="fas fa-users-cog"></i> User Management
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/layouts/admin.blade.php ENDPATH**/ ?>