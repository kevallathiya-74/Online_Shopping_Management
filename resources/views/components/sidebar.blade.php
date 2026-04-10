<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<aside class="admin-sidebar" id="adminSidebar" aria-label="Admin sidebar">
    <div class="sidebar-branding d-lg-none">
        <span class="sidebar-brand-mark"><i class="fas fa-shield-halved"></i></span>
        <div>
            <div class="sidebar-brand-title">Admin Console</div>
            <div class="sidebar-brand-subtitle">Store operations</div>
        </div>
    </div>

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

    <div class="sidebar-footer">
        <div class="sidebar-footer-label">Signed in as</div>
        <div class="sidebar-footer-user">{{ Auth::user()->name }}</div>
        <a href="{{ route('home') }}" class="sidebar-footer-link" target="_blank">
            <i class="fas fa-arrow-up-right-from-square me-1"></i>Open storefront
        </a>
    </div>
</aside>
