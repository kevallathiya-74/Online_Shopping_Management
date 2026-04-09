<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ShopEasy - Your one-stop online shopping destination. Browse products, manage orders, and shop with confidence.">
    <title>@yield('title', 'ShopEasy - Online Shopping')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}" rel="stylesheet">
</head>

<body class="app-shell @yield('body_class')">
    <nav class="navbar navbar-expand-lg site-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="brand-badge"><i class="fas fa-bag-shopping"></i></span>
                <span>ShopEasy</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavbarNav" aria-controls="siteNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="siteNavbarNav">
                <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" title="Home">
                            <i class="fas fa-house me-1"></i>Home
                        </a>
                    </li>

                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-chart-line me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                            <i class="fas fa-box-open me-1"></i>Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}" href="{{ route('wishlist.index') }}">
                            <i class="fas fa-heart me-1"></i>Wishlist
                        </a>
                    </li>
                    @endauth
                </ul>

                <div class="site-nav-actions ms-lg-auto">
                    @auth
                    <a class="btn btn-outline-primary cart-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                        <i class="fas fa-cart-shopping"></i>
                        <span class="ms-1">Cart</span>
                        @if(($layoutCartCount ?? 0) > 0)
                        <span class="cart-count">{{ $layoutCartCount }}</span>
                        @endif
                    </a>

                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-shield-halved"></i>
                        <span class="ms-1">Admin</span>
                    </a>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <span class="ms-1 nav-user-name">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="fas fa-chart-line me-2 text-primary"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user-pen me-2 text-info"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-box-open me-2 text-success"></i>Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-arrow-right-from-bracket me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-right-to-bracket me-1"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-auto-dismiss="true">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" data-auto-dismiss="true">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any() && !request()->routeIs('user.profile') && !request()->routeIs('checkout'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>

    <main class="site-main">
        @yield('content')
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
                        <a href="{{ route('home') }}"><small>Browse Products</small></a>
                        @auth
                        <a href="{{ route('user.dashboard') }}"><small>My Dashboard</small></a>
                        <a href="{{ route('cart.index') }}"><small>My Cart</small></a>
                        <a href="{{ route('orders.index') }}"><small>My Orders</small></a>
                        @endauth
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
    @yield('scripts')
</body>

</html>