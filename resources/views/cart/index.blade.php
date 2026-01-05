@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container">
    <h2 class="mb-4">Shopping Cart</h2>

    @if($cartItems->isEmpty())
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('home') }}">Continue Shopping</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="row mb-3 pb-3 border-bottom">
                                <div class="col-md-2">
                                    @if($item->product->image)
                                        <img src="{{ $item->product->image }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="img-fluid rounded"
                                             style="max-height: 100px; object-fit: contain;"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100?text=No+Image';">
                                    @else
                                        <div class="bg-light p-3 text-center">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ $item->product->name }}</h6>
                                    <p class="text-muted small">{{ $item->product->category->name }}</p>
                                    <p class="text-primary">₹{{ number_format($item->product->price, 2) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <strong>₹{{ number_format($item->product->price * $item->quantity, 2) }}</strong>
                                </div>
                                <div class="col-md-1">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Cart Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Items:</span>
                            <strong>{{ $cartItems->sum('quantity') }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total Amount:</h5>
                            <h5 class="text-primary">₹{{ number_format($total, 2) }}</h5>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-success w-100 btn-lg">
                            <i class="fas fa-check"></i> Proceed to Checkout
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
