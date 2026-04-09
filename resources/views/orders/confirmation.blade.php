@extends('layouts.app')

@section('title', 'Order Confirmed - ShopEasy')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="section-card hero-banner mb-4">
                <div class="card-body text-center py-5">
                    <div class="hero-highlight mx-auto mb-3"><i class="fas fa-circle-check"></i> Order Confirmed</div>
                    <h1 class="hero-title mb-2">Order Placed Successfully</h1>
                    <p class="hero-subtitle mx-auto">Thank you for your purchase. We have received your order and will start processing it shortly.</p>
                    <div class="mt-4">
                        <span class="badge bg-light text-dark border px-3 py-2 fs-6">Order #{{ $order->id }}</span>
                    </div>
                </div>
            </div>

            <div class="section-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-circle-info text-primary me-2"></i>Order Details</h5>
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
                                    <td><span class="badge badge-status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
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
                                    <td class="text-muted fw-semibold">Shipping</td>
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

            <div class="section-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-box text-success me-2"></i>Items Ordered</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong class="text-wrap-anywhere d-inline-block">{{ $item->product->name ?? 'Product Deleted' }}</strong></td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td class="text-center"><span class="badge bg-info">{{ $item->quantity }}</span></td>
                                <td class="text-end fw-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="4" class="text-end fw-bold">Grand Total</td>
                                <td class="text-end text-success fw-bold fs-5">₹{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-eye me-1"></i>View Order Details
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-box-open me-1"></i>My Orders
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-bag-shopping me-1"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
