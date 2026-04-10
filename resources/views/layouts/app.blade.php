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
    <x-navbar :cart-count="$layoutCartCount ?? 0" />

    <div class="container component-alerts mt-3">
        <x-flash-messages :suppress-errors="request()->routeIs('user.profile') || request()->routeIs('checkout') || request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*')" />
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
