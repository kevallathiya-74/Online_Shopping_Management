@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container">
    <h2 class="mb-4">My Orders</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info">
            You haven't placed any orders yet. <a href="{{ route('home') }}">Start Shopping</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Order #{{ $order->id }}</strong>
                        <span class="ms-3 text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Products:</h6>
                            <ul>
                                @foreach($order->orderItems as $item)
                                    <li>{{ $item->product->name }} - Qty: {{ $item->quantity }} - ₹{{ number_format($item->price, 2) }}</li>
                                @endforeach
                            </ul>
                            <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                            <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <h4 class="text-primary">₹{{ number_format($order->total_amount, 2) }}</h4>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
