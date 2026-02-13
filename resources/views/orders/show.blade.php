@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - ShopEasy')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-receipt text-primary"></i> Order #{{ $order->id }}</h2>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8 mb-4">
            <!-- Order Status Card -->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle text-primary"></i> Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-muted" style="width: 120px;">Order ID:</td>
                                    <td><span class="badge bg-secondary">#{{ $order->id }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Date:</td>
                                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status:</td>
                                    <td>
                                        <span class="badge badge-status-{{ $order->status }} px-3 py-1">
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
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-muted" style="width: 120px;">Payment:</td>
                                    <td>
                                        @if($order->payment_method == 'online')
                                            <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online Payment</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> Cash on Delivery</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Address:</td>
                                    <td>{{ $order->shipping_address }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Phone:</td>
                                    <td><i class="fas fa-phone text-muted"></i> {{ $order->phone }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-box text-success"></i> Products Ordered ({{ $order->orderItems->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
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
                                                <a href="{{ route('products.show', $item->product->id) }}" class="text-decoration-none fw-bold">
                                                    {{ $item->product->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Product Deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->product && $item->product->category)
                                                <span class="badge bg-primary" style="font-size: 0.7rem;">
                                                    {{ $item->product->category->name }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">₹{{ number_format($item->price, 2) }}</td>
                                        <td class="text-center"><span class="badge bg-info">{{ $item->quantity }}</span></td>
                                        <td class="text-end"><strong>₹{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <td colspan="5" class="text-end fw-bold fs-6">Grand Total:</td>
                                    <td class="text-end">
                                        <strong class="text-success fs-5">₹{{ number_format($order->total_amount, 2) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); color: white;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt"></i> Order Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Items:</span>
                        <strong>{{ $order->orderItems->count() }} product(s)</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Quantity:</span>
                        <strong>{{ $order->orderItems->sum('quantity') }} units</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping:</span>
                        <strong class="text-success">FREE</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="fw-bold mb-0">Total:</h5>
                        <h4 class="text-success fw-bold mb-0">₹{{ number_format($order->total_amount, 2) }}</h4>
                    </div>

                    <hr>

                    <!-- Order Status Info -->
                    <div class="text-center">
                        @if($order->status == 'pending')
                            <div class="alert alert-warning mb-3 py-2">
                                <i class="fas fa-clock"></i> Your order is <strong>pending</strong> and will be processed soon.
                            </div>
                            <!-- Cancel Button — Only for Pending Orders -->
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to cancel Order #{{ $order->id }}?\n\nThis action cannot be undone.\nProduct stock will be restored.');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger w-100 mb-2">
                                    <i class="fas fa-times-circle"></i> Cancel This Order
                                </button>
                            </form>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> You can only cancel orders that are still pending.
                            </small>
                        @elseif($order->status == 'processing')
                            <div class="alert alert-info mb-3 py-2">
                                <i class="fas fa-spinner fa-spin"></i> Your order is being <strong>processed</strong>.
                            </div>
                            <div class="alert alert-light border mb-0 py-2">
                                <small><i class="fas fa-info-circle text-muted"></i> Orders being processed cannot be cancelled. Please contact support if needed.</small>
                            </div>
                        @elseif($order->status == 'completed')
                            <div class="alert alert-success mb-3 py-2">
                                <i class="fas fa-check-circle"></i> Your order has been <strong>completed</strong>!
                            </div>
                            <div class="alert alert-light border mb-0 py-2">
                                <small><i class="fas fa-info-circle text-muted"></i> Completed orders cannot be cancelled.</small>
                            </div>
                        @elseif($order->status == 'cancelled')
                            <div class="alert alert-danger mb-3 py-2">
                                <i class="fas fa-times-circle"></i> This order was <strong>cancelled</strong>.
                            </div>
                            <div class="alert alert-light border mb-0 py-2">
                                <small><i class="fas fa-info-circle text-muted"></i> Product stock has been restored to inventory.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card mt-3">
                <div class="card-body">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list"></i> All Orders
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
