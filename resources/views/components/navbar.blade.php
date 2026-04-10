@props(['cartCount' => 0])

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
                    @if($cartCount > 0)
                    <span class="cart-count">{{ $cartCount }}</span>
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
