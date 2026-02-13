@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard Overview</h2>
            <p>Welcome back, {{ Auth::user()->name }}! Here's your store summary.</p>
        </div>
        <div>
            <span class="badge bg-success p-2">
                <i class="fas fa-circle" style="font-size: 8px;"></i> System Active
            </span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-gradient-primary">
            <div class="card-body">
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-gradient-success">
            <div class="card-body">
                <i class="fas fa-box-open stat-icon"></i>
                <div class="stat-label">Total Products</div>
                <div class="stat-value">{{ $totalProducts }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-gradient-info">
            <div class="card-body">
                <i class="fas fa-tags stat-icon"></i>
                <div class="stat-label">Total Categories</div>
                <div class="stat-value">{{ $totalCategories }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-gradient-warning">
            <div class="card-body">
                <i class="fas fa-shopping-cart stat-icon"></i>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ $totalOrders }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Info Row -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Total Revenue</h6>
                <h3 class="text-success fw-bold">₹{{ number_format($totalRevenue, 0) }}</h3>
                <small class="text-muted"><i class="fas fa-chart-line"></i> From completed & active orders</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Pending Orders</h6>
                <h3 class="text-warning fw-bold">{{ $pendingOrders }}</h3>
                <small class="text-muted"><i class="fas fa-clock"></i> Awaiting action</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Completed Orders</h6>
                <h3 class="text-success fw-bold">{{ $completedOrders }}</h3>
                <small class="text-muted"><i class="fas fa-check-circle"></i> Successfully delivered</small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add Product
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add Category
                    </a>
                    <a href="{{ route('admin.orders') }}" class="btn btn-warning">
                        <i class="fas fa-list"></i> View Orders
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-info text-white">
                        <i class="fas fa-users-cog"></i> Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-clock"></i> Recent Orders</h5>
            <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($recentOrders->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">No orders yet. Waiting for first order!</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
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
                                <td><span class="badge bg-secondary">#{{ $order->id }}</span></td>
                                <td>
                                    <strong>{{ $order->user->name }}</strong>
                                    <br><small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td><strong class="text-success">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                                <td>
                                    <span class="badge badge-status-{{ $order->status }} px-3 py-2">
                                        @if($order->status == 'completed')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($order->status == 'cancelled')
                                            <i class="fas fa-times-circle"></i>
                                        @elseif($order->status == 'processing')
                                            <i class="fas fa-spinner"></i>
                                        @else
                                            <i class="fas fa-clock"></i>
                                        @endif
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
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
