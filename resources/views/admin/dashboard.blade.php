@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2><i class="fas fa-gauge-high me-2"></i>Dashboard Overview</h2>
            <p>Monitor core store metrics, activity, and operational health in one place.</p>
        </div>
        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-2">
            <i class="fas fa-circle me-1 icon-dot-xs"></i>System Active
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-label">Total Users</div>
                    <span class="stat-icon primary"><i class="fas fa-users"></i></span>
                </div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-label">Total Products</div>
                    <span class="stat-icon success"><i class="fas fa-box-open"></i></span>
                </div>
                <div class="stat-value">{{ $totalProducts }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-label">Total Categories</div>
                    <span class="stat-icon info"><i class="fas fa-tags"></i></span>
                </div>
                <div class="stat-value">{{ $totalCategories }}</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-label">Total Orders</div>
                    <span class="stat-icon warning"><i class="fas fa-bag-shopping"></i></span>
                </div>
                <div class="stat-value">{{ $totalOrders }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="section-card h-100">
            <div class="card-body text-center p-4">
                <div class="small text-muted mb-1">Total Revenue</div>
                <div class="h3 fw-bold text-success mb-2">₹{{ number_format($totalRevenue, 0) }}</div>
                <small class="text-muted">From completed and active orders</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="section-card h-100">
            <div class="card-body text-center p-4">
                <div class="small text-muted mb-1">Pending Orders</div>
                <div class="h3 fw-bold text-warning mb-2">{{ $pendingOrders }}</div>
                <small class="text-muted">Require operations attention</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="section-card h-100">
            <div class="card-body text-center p-4">
                <div class="small text-muted mb-1">Completed Orders</div>
                <div class="h3 fw-bold text-success mb-2">{{ $completedOrders }}</div>
                <small class="text-muted">Successfully delivered</small>
            </div>
        </div>
    </div>
</div>

<div class="section-card mb-4">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
    </div>
    <div class="card-body d-flex flex-wrap gap-2">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Add Product</a>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i>Add Category</a>
        <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary"><i class="fas fa-list me-1"></i>View Orders</a>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary"><i class="fas fa-users me-1"></i>Manage Users</a>
    </div>
</div>

<div class="section-card admin-table">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2"></i>Recent Orders</h5>
        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>

    <div class="card-body p-0">
        @if($recentOrders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
            <p class="text-muted mb-0">No orders yet. Waiting for customer activity.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td><span class="badge bg-dark-subtle text-dark border">#{{ $order->id }}</span></td>
                        <td>
                            <strong>{{ $order->user->name }}</strong>
                            <br><small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td class="fw-bold text-success">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="badge badge-status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td><small class="text-muted">{{ $order->created_at->format('d M Y') }}</small></td>
                        <td class="text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
