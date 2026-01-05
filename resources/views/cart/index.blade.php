@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0"><i class="fas fa-shopping-cart"></i> Shopping Cart</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Continue Shopping
        </a>
    </div>

    @if($cartItems->isEmpty())
        <div class="card shadow-lg" style="border-radius: 20px; border: none;">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                <h4 class="mb-3">Your cart is empty</h4>
                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Start Shopping
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-lg" style="border-radius: 20px; border: none;">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> Cart Items ({{ $cartItems->count() }})</h5>
                    </div>
                    <div class="card-body p-4">
                        @foreach($cartItems as $item)
                            <div class="row mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }} align-items-center">
                                <div class="col-md-2">
                                    <div style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border-radius: 12px; padding: 10px; display: flex; align-items: center; justify-content: center; height: 100px;">
                                        @if($item->product->image)
                                            <img src="{{ $item->product->image }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 style="max-height: 80px; max-width: 100%; object-fit: contain;"
                                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100?text=No+Image';">
                                        @else
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold mb-2">{{ $item->product->name }}</h6>
                                    <span class="badge bg-secondary mb-2" style="font-size: 10px;">{{ $item->product->category->name }}</span>
                                    <p class="price-tag mb-0" style="font-size: 20px;">₹{{ number_format($item->product->price, 2) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <label class="form-label fw-bold small">Quantity</label>
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" style="border-radius: 8px 0 0 8px;">
                                            <button type="submit" class="btn btn-outline-primary" style="border-radius: 0 8px 8px 0;">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2 text-center">
                                    <p class="small text-muted mb-1">Subtotal</p>
                                    <h5 class="fw-bold text-success mb-0">₹{{ number_format($item->product->price * $item->quantity, 2) }}</h5>
                                </div>
                                <div class="col-md-1 text-end">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-lg sticky-top" style="border-radius: 20px; border: none; top: 20px;">
                    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); border-radius: 20px 20px 0 0;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-receipt"></i> Order Summary</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Items:</span>
                            <strong>{{ $cartItems->sum('quantity') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal:</span>
                            <strong>₹{{ number_format($total, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Shipping:</span>
                            <strong class="text-success">FREE</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold">Total Amount:</h5>
                            <h5 class="price-tag mb-0">₹{{ number_format($total, 2) }}</h5>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-success w-100 btn-lg mb-3" style="border-radius: 10px; padding: 15px;">
                            <i class="fas fa-check-circle"></i> Proceed to Checkout
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100" style="border-radius: 10px;">
                            <i class="fas fa-shopping-bag"></i> Add More Items
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
