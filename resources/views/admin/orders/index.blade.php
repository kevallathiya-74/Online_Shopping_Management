@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-shopping-cart"></i> Orders Management</h2>
            <p>View and manage all customer orders</p>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> All Orders</h5>
            <span class="badge bg-primary">{{ $orders->total() }} Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        @if($orders->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No orders found</h5>
                <p class="text-muted">Orders will appear here once customers start purchasing.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center" style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><span class="badge bg-secondary">#{{ $order->id }}</span></td>
                                <td>
                                    <strong>{{ $order->user->name }}</strong>
                                    <br><small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $order->orderItems->count() }} item(s)</span>
                                </td>
                                <td>
                                    <strong class="text-success">₹{{ number_format($order->total_amount, 2) }}</strong>
                                </td>
                                <td>
                                    @if($order->payment_method == 'online')
                                        <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> COD</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" 
                                                class="form-select form-select-sm" 
                                                style="width: 140px; font-size: 0.85rem;"
                                                onchange="if(confirm('Change order #{{ $order->id }} status to ' + this.value + '?')) this.form.submit(); else this.value='{{ $order->status }}';">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-day"></i> {{ $order->created_at->format('d M Y') }}
                                    </small>
                                    <br>
                                    <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="View Order Details">
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

    {{-- Pagination --}}
    @if($orders->isNotEmpty() && $orders->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <span class="text-muted">
                    Showing <strong>{{ $orders->firstItem() }}</strong> to <strong>{{ $orders->lastItem() }}</strong> of <strong>{{ $orders->total() }}</strong> orders
                </span>
                <div>
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
