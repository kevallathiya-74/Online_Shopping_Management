@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2><i class="fas fa-bag-shopping me-2"></i>Orders Management</h2>
            <p>Review customer orders, update statuses, and monitor fulfillment flow.</p>
        </div>
    </div>
</div>

<div class="section-card admin-table">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>All Orders</h5>
        <span class="badge bg-primary">{{ $orders->total() }} Total</span>
    </div>

    <div class="card-body p-0">
        @if($orders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-bag-shopping"></i></div>
            <h5 class="fw-bold">No orders found</h5>
            <p class="text-muted mb-0">Orders will appear here once customers start purchasing.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><span class="badge bg-dark-subtle text-dark border">#{{ $order->id }}</span></td>
                        <td>
                            <strong>{{ $order->user->name }}</strong>
                            <br><small class="text-muted text-wrap-anywhere d-inline-block">{{ $order->user->email }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $order->orderItems->count() }} item(s)</span></td>
                        <td class="fw-bold text-success">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @if($order->payment_method == 'online')
                            <span class="badge bg-primary"><i class="fas fa-credit-card me-1"></i>Online</span>
                            @else
                            <span class="badge bg-secondary"><i class="fas fa-money-bill-wave me-1"></i>COD</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm select-compact"
                                    onchange="if(confirm('Change order #{{ $order->id }} status to ' + this.value + '?')) this.form.submit(); else this.value='{{ $order->status }}';">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small><br>
                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    @if($orders->isNotEmpty() && $orders->hasPages())
    <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted">
            Showing <strong>{{ $orders->firstItem() }}</strong> to <strong>{{ $orders->lastItem() }}</strong> of <strong>{{ $orders->total() }}</strong> orders
        </span>
        <div>{{ $orders->links('pagination::bootstrap-5') }}</div>
    </div>
    @endif
</div>
@endsection
