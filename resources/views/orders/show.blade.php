@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - ShopEasy')

@section('content')
<div class="container">
    <div class="section-header mb-4">
        <div>
            <h2 class="section-title mb-1"><i class="fas fa-receipt text-primary me-2"></i>Order #{{ $order->id }}</h2>
            <p class="section-subtitle">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Orders
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="section-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-circle-info text-primary me-2"></i>Order Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted fw-semibold meta-label-col">Order ID</td>
                                    <td><span class="badge bg-dark-subtle text-dark border">#{{ $order->id }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Date</td>
                                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Status</td>
                                    <td>
                                        <span class="badge badge-status-{{ $order->status }}">
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
                                </tr>
                            </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted fw-semibold meta-label-col">Payment</td>
                                    <td>
                                        @if($order->payment_method == 'online')
                                        <span class="badge bg-primary"><i class="fas fa-credit-card me-1"></i>Online Payment</span>
                                        @else
                                        <span class="badge bg-secondary"><i class="fas fa-money-bill-wave me-1"></i>Cash on Delivery</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Address</td>
                                    <td class="text-wrap-anywhere">{{ $order->shipping_address }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Phone</td>
                                    <td>{{ $order->phone }}</td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-box text-success me-2"></i>Products Ordered ({{ $order->orderItems->count() }})</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->product)
                                    <a href="{{ route('products.show', $item->product->id) }}" class="fw-bold text-wrap-anywhere d-inline-block">
                                        {{ $item->product->name }}
                                    </a>
                                    @else
                                    <span class="text-muted">Product Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->product && $item->product->category)
                                    <span class="badge bg-light text-dark border">{{ $item->product->category->name }}</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">₹{{ number_format($item->price, 2) }}</td>
                                <td class="text-center"><span class="badge bg-info">{{ $item->quantity }}</span></td>
                                <td class="text-end fw-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="5" class="text-end fw-bold">Grand Total</td>
                                <td class="text-end text-success fw-bold fs-5">₹{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="section-card summary-card sticky-top summary-sticky">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-file-invoice me-1"></i>Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Items</span>
                        <strong>{{ $order->orderItems->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Quantity</span>
                        <strong>{{ $order->orderItems->sum('quantity') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <strong class="text-success">FREE</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="fw-bold mb-0">Total</h5>
                        <h4 class="text-success fw-bold mb-0">₹{{ number_format($order->total_amount, 2) }}</h4>
                    </div>

                    @if($order->status == 'pending')
                    <div class="alert alert-warning py-2">
                        <i class="fas fa-clock me-1"></i>Your order is pending and can be cancelled.
                    </div>
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to cancel Order #{{ $order->id }}? This action cannot be undone.');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-danger w-100 mb-2">
                            <i class="fas fa-xmark me-1"></i>Cancel Order
                        </button>
                    </form>
                    @elseif($order->status == 'processing')
                    <div class="alert alert-info py-2 mb-3">
                        <i class="fas fa-spinner me-1"></i>Your order is currently being processed.
                    </div>
                    @elseif($order->status == 'completed')
                    <div class="alert alert-success py-2 mb-3">
                        <i class="fas fa-check-circle me-1"></i>This order has been completed.
                    </div>
                    @else
                    <div class="alert alert-danger py-2 mb-3">
                        <i class="fas fa-times-circle me-1"></i>This order was cancelled.
                    </div>
                    @endif

                    <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-dark w-100 mb-2">
                        <i class="fas fa-file-pdf me-1"></i>Download Invoice
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-bag-shopping me-1"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
