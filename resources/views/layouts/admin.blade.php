<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Online Shopping Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}" rel="stylesheet">
</head>

<body class="admin-shell">
    <nav class="admin-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <span class="brand-mark"><i class="fas fa-shield-halved"></i></span>
                Admin Console
            </a>
        </div>

        <div class="nav-right">
            <a href="{{ route('home') }}" class="top-action" target="_blank">
                <i class="fas fa-arrow-up-right-from-square me-1"></i><span class="top-action-label">Storefront</span>
            </a>

            <span class="badge-soft d-none d-md-inline">
                <i class="fas fa-user-shield me-1"></i>{{ Auth::user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-arrow-right-from-bracket me-1"></i><span class="logout-label">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-heading">Overview</div>
        <ul class="nav-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
        </ul>

        <div class="sidebar-heading mt-3">Catalog</div>
        <ul class="nav-menu">
            <li>
                <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i> Products
                </a>
            </li>
        </ul>

        <div class="sidebar-heading mt-3">Operations</div>
        <ul class="nav-menu">
            <li>
                <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-bag-shopping"></i> Orders
                </a>
            </li>
        </ul>

        <div class="sidebar-heading mt-3">System</div>
        <ul class="nav-menu">
            <li>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> Users
                </a>
            </li>
        </ul>
    </aside>

    <main class="admin-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" data-auto-dismiss="true">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" data-auto-dismiss="true">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        setTimeout(function() {
            document.querySelectorAll('.alert[data-auto-dismiss="true"]').forEach(function(alert) {
                var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            });
        }, 5000);

        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                document.getElementById('adminSidebar').classList.remove('show');
                document.getElementById('sidebarOverlay').classList.remove('show');
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
