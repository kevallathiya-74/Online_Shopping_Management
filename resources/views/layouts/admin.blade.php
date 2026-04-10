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
            <button class="sidebar-toggle" type="button" onclick="toggleSidebar()" aria-controls="adminSidebar" aria-expanded="false" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <span class="brand-mark"><i class="fas fa-shield-halved"></i></span>
                <span class="brand-copy">
                    <span>Admin Console</span>
                    <small>Operations center</small>
                </span>
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

    <x-sidebar />

    <main class="admin-content">
        <div class="component-alerts">
            <x-flash-messages />
        </div>

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarToggleButton = document.querySelector('.sidebar-toggle');

        function toggleSidebar() {
            const isOpen = adminSidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show', isOpen);
            document.body.classList.toggle('sidebar-open', isOpen);

            if (sidebarToggleButton) {
                sidebarToggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        }

        setTimeout(function() {
            document.querySelectorAll('.alert[data-auto-dismiss="true"]').forEach(function(alert) {
                var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            });
        }, 5000);

        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                adminSidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
                if (sidebarToggleButton) {
                    sidebarToggleButton.setAttribute('aria-expanded', 'false');
                }
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
