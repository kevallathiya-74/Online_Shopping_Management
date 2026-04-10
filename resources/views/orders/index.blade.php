@extends('layouts.app')

@section('title', 'My Orders - ShopEasy')

@section('content')
<div class="container">
    <x-page-header
        title="My Orders"
        subtitle="Track order status, payment details, and delivery information from one place."
        icon="fas fa-box-open">
        <x-slot name="actions">
        <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Dashboard
            </a>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-bag-shopping me-1"></i>Shop More
            </a>
        </div>
        </x-slot>
    </x-page-header>

    @if($orders->isEmpty())
    <div class="section-card">
        <x-empty-state
            icon="fas fa-box-open"
            title="No orders yet"
            description="Your placed orders will appear here with live status updates.">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg"><i class="fas fa-bag-shopping me-1"></i>Start Shopping</a>
        </x-empty-state>
    </div>
    @else
    @foreach($orders as $order)
    <div class="section-card mb-3">
        <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-dark-subtle text-dark border">Order #{{ $order->id }}</span>
                        <x-order-status-badge :status="$order->status" />
                        <x-payment-method-badge :method="$order->payment_method" />
                    </div>
                    <small class="text-muted"><i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('d M Y, h:i A') }}</small>
                </div>
        </div>

        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <h6 class="fw-bold mb-2">Items</h6>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        @foreach($order->orderItems as $item)
                        <span class="badge bg-light text-dark border text-wrap-anywhere">
                            {{ $item->product?->name ?? 'Deleted Product' }} x {{ $item->quantity }}
                        </span>
                        @endforeach
                    </div>
                    <div class="small text-muted d-flex flex-wrap gap-3">
                        <span class="text-wrap-anywhere"><i class="fas fa-location-dot me-1"></i>{{ Str::limit($order->shipping_address, 58) }}</span>
                        <span><i class="fas fa-phone me-1"></i>{{ $order->phone }}</span>
                    </div>
                </div>

                <div class="col-md-4 text-md-end">
                    <div class="h4 text-success fw-bold mb-3">₹{{ number_format($order->total_amount, 2) }}</div>
                    <div class="table-actions">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Details
                        </a>
                        <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-file-invoice me-1"></i>Invoice
                        </a>
                        @if($order->status == 'pending')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel Order #{{ $order->id }}? This action cannot be undone.');">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-xmark me-1"></i>Cancel
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($orders->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
    @endif
    @endif
</div>
@endsection

