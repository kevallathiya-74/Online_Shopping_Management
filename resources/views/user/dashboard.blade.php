@extends('layouts.app')

@section('title', 'My Dashboard - ShopEasy')

@section('content')
<div class="container">
    <div class="section-card hero-banner mb-4">
        <div class="card-body p-4 p-lg-5">
            <span class="hero-highlight mb-2"><i class="fas fa-user-check"></i>Account Overview</span>
            <h2 class="hero-title">Welcome back, {{ $user->name }}</h2>
            <p class="hero-subtitle">Track order activity, account details, and saved products from one dashboard.</p>
            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="{{ route('home') }}" class="btn btn-light"><i class="fas fa-bag-shopping me-1"></i>Continue Shopping</a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-light"><i class="fas fa-box-open me-1"></i>My Orders</a>
            </div>
        </div>
    </div>

    <div class="stats-grid mb-4">
        <div class="metric-card">
            <div class="metric-label">Total Orders</div>
            <div class="metric-value">{{ $totalOrders }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Spent</div>
            <div class="metric-value">₹{{ number_format($totalSpent, 0) }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pending Orders</div>
            <div class="metric-value">{{ $pendingOrders }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Completed Orders</div>
            <div class="metric-value">{{ $completedOrders }}</div>
        </div>
    </div>

    <div class="section-card mb-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
        </div>
        <div class="card-body d-flex flex-wrap gap-2">
            <a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-store me-1"></i>Browse Products</a>
            <a href="{{ route('cart.index') }}" class="btn btn-success"><i class="fas fa-cart-shopping me-1"></i>View Cart</a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary"><i class="fas fa-clock-rotate-left me-1"></i>Order History</a>
            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary"><i class="fas fa-user-pen me-1"></i>Edit Profile</a>
            <a href="{{ route('wishlist.index') }}" class="btn btn-outline-danger"><i class="fas fa-heart me-1"></i>Wishlist <span class="badge bg-danger ms-1">{{ $wishlistCount }}</span></a>
        </div>
    </div>

    <div class="section-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2 text-primary"></i>Recent Orders</h5>
            @if($recentOrders->isNotEmpty())
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            @endif
        </div>

        <div class="card-body p-0">
            @if($recentOrders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                <h5 class="fw-bold">No orders yet</h5>
                <p class="text-muted mb-3">Start shopping to see your recent orders here.</p>
                <a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-bag-shopping me-1"></i>Start Shopping</a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><span class="badge bg-dark-subtle text-dark border">#{{ $order->id }}</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $order->orderItems->count() }} item(s)</span></td>
                            <td class="fw-bold text-success">₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <x-payment-method-badge :method="$order->payment_method" />
                            </td>
                            <td><x-order-status-badge :status="$order->status" /></td>
                            <td><small class="text-muted">{{ $order->created_at->format('d M Y') }}</small></td>
                            <td class="text-center">
                                <div class="table-actions justify-center">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    @if($order->status == 'pending')
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Cancel Order #{{ $order->id }}?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </form>
                                    @endif
                                </div>
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

