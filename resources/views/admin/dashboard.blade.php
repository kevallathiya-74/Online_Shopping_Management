@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="fas fa-chart-line"></i> Dashboard Overview</h2>
                <p class="text-muted mb-0">Welcome back, Admin! Here's what's happening today.</p>
            </div>
            <div>
                <span class="badge bg-success p-2">
                    <i class="fas fa-circle" style="font-size: 8px;"></i> System Active
                </span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Products</h6>
                        <h2 class="fw-bold mb-0">{{ $totalProducts }}</h2>
                        <small><i class="fas fa-boxes"></i> In Stock</small>
                    </div>
                    <i class="fas fa-box-open"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Orders</h6>
                        <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
                        <small><i class="fas fa-shopping-cart"></i> Processed</small>
                    </div>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Users</h6>
                        <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                        <small><i class="fas fa-users"></i> Registered</small>
                    </div>
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Revenue</h6>
                        <h2 class="fw-bold mb-0">₹{{ number_format($totalRevenue, 0) }}</h2>
                        <small><i class="fas fa-chart-line"></i> Earnings</small>
                    </div>
                    <i class="fas fa-rupee-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header bg-white border-0 py-3">
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> Order ID</th>
                                <th><i class="fas fa-user"></i> Customer</th>
                                <th><i class="fas fa-rupee-sign"></i> Amount</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                                <th><i class="fas fa-calendar"></i> Date</th>
                                <th class="text-center"><i class="fas fa-cog"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td><span class="badge bg-secondary">#{{ $order->id }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                {{ substr($order->user->name, 0, 1) }}
                                            </div>
                                            <strong>{{ $order->user->name }}</strong>
                                        </div>
                                    </td>
                                    <td><strong class="text-success">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} px-3 py-2">
                                            @if($order->status == 'completed')
                                                <i class="fas fa-check-circle"></i>
                                            @elseif($order->status == 'cancelled')
                                                <i class="fas fa-times-circle"></i>
                                            @else
                                                <i class="fas fa-clock"></i>
                                            @endif
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-day"></i> {{ $order->created_at->format('d M Y') }}
                                        </small>
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
</div>
@endsection
