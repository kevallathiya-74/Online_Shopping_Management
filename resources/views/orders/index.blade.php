@extends('layouts.app')

@section('title', 'My Orders - ShopEasy')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-box text-primary"></i> My Orders</h2>
            <p class="text-muted mb-0">View and track all your orders</p>
        </div>
        <div>
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Shop More
            </a>
        </div>
    </div>

    @if($orders->isEmpty())
        <!-- Empty State -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h4 class="mb-3">No orders yet</h4>
                <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Start Shopping
                </a>
            </div>
        </div>
    @else
        <!-- Orders List -->
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-secondary px-3 py-2">Order #{{ $order->id }}</span>
                            <span class="badge badge-status-{{ $order->status }} px-2 py-1">
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
                            @if($order->payment_method == 'online')
                                <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> COD</span>
                            @endif
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y, h:i A') }}
                        </small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="fw-bold mb-2"><i class="fas fa-shopping-bag text-primary"></i> Items Ordered:</h6>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @foreach($order->orderItems as $item)
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        {{ $item->product->name ?? 'Deleted Product' }} 
                                        × {{ $item->quantity }}
                                        — ₹{{ number_format($item->price * $item->quantity, 2) }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="d-flex gap-4 text-muted small">
                                <span><i class="fas fa-map-marker-alt"></i> {{ Str::limit($order->shipping_address, 50) }}</span>
                                <span><i class="fas fa-phone"></i> {{ $order->phone }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <h4 class="text-success fw-bold mb-3">₹{{ number_format($order->total_amount, 2) }}</h4>
                            <div class="d-flex gap-2 justify-content-md-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                @if($order->status == 'pending')
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to cancel Order #{{ $order->id }}?\n\nThis action cannot be undone.');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif
</div>
@endsection
