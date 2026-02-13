@extends('layouts.admin')

@section('title', 'Order Details - #' . $order->id)

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-receipt"></i> Order Details - #{{ $order->id }}</h2>
            <p>View complete order information</p>
        </div>
        <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row">
    <!-- Customer Information -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-user"></i> Customer Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="fw-bold text-muted" style="width: 140px;">Name:</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Email:</td>
                        <td>{{ $order->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Phone:</td>
                        <td>{{ $order->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Shipping Address:</td>
                        <td>{{ $order->shipping_address ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Information -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle"></i> Order Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="fw-bold text-muted" style="width: 140px;">Order ID:</td>
                        <td><span class="badge bg-secondary">#{{ $order->id }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Order Date:</td>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Status:</td>
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
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Total Amount:</td>
                        <td><strong class="text-success fs-5">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-muted">Payment:</td>
                        <td>
                            @if($order->payment_method == 'online')
                                <span class="badge bg-primary px-3 py-1"><i class="fas fa-credit-card"></i> Online Payment</span>
                            @else
                                <span class="badge bg-secondary px-3 py-1"><i class="fas fa-money-bill-wave"></i> Cash on Delivery</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Update Status -->
<div class="card mb-4">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-sync-alt"></i> Update Order Status</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-flex align-items-center gap-3 flex-wrap">
            @csrf
            @method('PUT')
            <label class="form-label mb-0 fw-bold">Change Status:</label>
            <select name="status" class="form-select" style="width: 200px;">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
            </select>
            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to update this order status?')">
                <i class="fas fa-save"></i> Update Status
            </button>
        </form>
    </div>
</div>

<!-- Order Items -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-box"></i> Order Items</h5>
            <span class="badge bg-primary">{{ $order->orderItems->count() }} item(s)</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
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
                            <td><span class="badge bg-secondary">{{ $index + 1 }}</span></td>
                            <td>
                                <strong>{{ $item->product->name ?? 'Product Deleted' }}</strong>
                            </td>
                            <td>
                                @if($item->product && $item->product->category)
                                    <span class="badge bg-primary">{{ $item->product->category->name }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $item->quantity }}</span>
                            </td>
                            <td class="text-end">
                                <strong>₹{{ number_format($item->price * $item->quantity, 2) }}</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-light">
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
@endsection
