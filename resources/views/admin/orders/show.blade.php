@extends('layouts.admin')

@section('title', 'Order Details - #' . $order->id)

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2><i class="fas fa-receipt me-2"></i>Order Details - #{{ $order->id }}</h2>
            <p>Review customer information, line items, and update order status.</p>
        </div>
        <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Orders
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="section-card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i>Customer Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted fw-semibold meta-label-col">Name</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Email</td>
                        <td class="text-wrap-anywhere">{{ $order->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Phone</td>
                        <td>{{ $order->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Shipping Address</td>
                        <td class="text-wrap-anywhere">{{ $order->shipping_address ?? 'N/A' }}</td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="section-card h-100">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="fas fa-circle-info me-2"></i>Order Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted fw-semibold meta-label-col">Order ID</td>
                        <td><span class="badge bg-dark-subtle text-dark border">#{{ $order->id }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Order Date</td>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Status</td>
                        <td><span class="badge badge-status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Total Amount</td>
                        <td><strong class="text-success fs-5">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Payment</td>
                        <td>
                            @if($order->payment_method == 'online')
                            <span class="badge bg-primary">Online Payment</span>
                            @else
                            <span class="badge bg-secondary">Cash on Delivery</span>
                            @endif
                        </td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-card mb-4">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-arrows-rotate me-2"></i>Update Order Status</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="row g-3 align-items-end">
            @csrf
            @method('PUT')
            <div class="col-md-4">
                <label for="status" class="form-label">Change Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to update this order status?')">
                    <i class="fas fa-save me-1"></i>Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<div class="section-card admin-table">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-box me-2"></i>Order Items</h5>
        <span class="badge bg-primary">{{ $order->orderItems->count() }} item(s)</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Unit Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $index => $item)
                <tr>
                    <td><span class="badge bg-dark-subtle text-dark border">{{ $index + 1 }}</span></td>
                    <td><strong class="text-wrap-anywhere d-inline-block">{{ $item->product->name ?? 'Product Deleted' }}</strong></td>
                    <td>
                        @if($item->product && $item->product->category)
                        <span class="badge bg-light text-dark border">{{ $item->product->category->name }}</span>
                        @else
                        <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-center"><span class="badge bg-info">{{ $item->quantity }}</span></td>
                    <td class="text-end fw-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="5" class="text-end fw-bold">Grand Total</td>
                    <td class="text-end"><strong class="text-success fs-5">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
