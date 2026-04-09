@extends('layouts.app')

@section('title', 'Shopping Cart - ShopEasy')

@section('content')
<div class="container">
    <div class="section-header mb-4">
        <div>
            <h2 class="section-title mb-1"><i class="fas fa-cart-shopping text-primary me-2"></i>Shopping Cart</h2>
            <p class="section-subtitle">
                @if($cartItems->isNotEmpty())
                You have {{ $cartItems->count() }} item(s) ready for checkout.
                @else
                Your cart is currently empty.
                @endif
            </p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i>Continue Shopping
        </a>
    </div>

    @if($cartItems->isEmpty())
    <div class="section-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-cart-shopping"></i></div>
            <h4 class="mb-2 fw-bold">Your cart is empty</h4>
            <p class="text-muted mb-4">Add products from the catalog and return here to checkout.</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-bag-shopping me-1"></i>Start Shopping
            </a>
        </div>
    </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="section-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Cart Items ({{ $cartItems->count() }})</h5>
                </div>
                <div class="card-body p-4">
                    @foreach($cartItems as $item)
                    <div class="row g-3 align-items-center py-2 {{ !$loop->last ? 'border-bottom mb-3 pb-4' : '' }}">
                        <div class="col-md-2 col-3">
                            <div class="admin-table thumb-box thumb-square-86 mx-auto mx-md-0">
                                @if($item->product->image)
                                <img src="{{ $item->product->image }}"
                                    alt="{{ $item->product->name }}"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-image fa-2x text-muted d-none"></i>
                                @else
                                <i class="fas fa-image fa-2x text-muted"></i>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 col-9">
                            <h6 class="mb-1 fw-bold product-title product-title-tight">
                                <a href="{{ route('products.show', $item->product->id) }}" class="text-dark">
                                    {{ $item->product->name }}
                                </a>
                            </h6>
                            <span class="badge bg-light text-dark border mb-1">
                                {{ $item->product->category->name ?? 'N/A' }}
                            </span>
                            <p class="text-success mb-0 fw-bold">₹{{ number_format($item->product->price, 2) }} each</p>
                        </div>

                        <div class="col-md-3 col-6">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="form-label small">Quantity</label>
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control"
                                        value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                                    <button type="submit" class="btn btn-outline-primary" title="Update Quantity">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1">Max: {{ $item->product->stock }}</small>
                            </form>
                        </div>

                        <div class="col-md-2 col-6 text-center">
                            <p class="small text-muted mb-1">Subtotal</p>
                            <h6 class="fw-bold text-success mb-0">
                                ₹{{ number_format($item->product->price * $item->quantity, 2) }}
                            </h6>
                        </div>

                        <div class="col-md-1 col-12 text-end">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                onsubmit="return confirm('Remove {{ $item->product->name }} from cart?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove Item">
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
            <div class="section-card summary-card sticky-top summary-sticky">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-1"></i>Order Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Items:</span>
                        <strong>{{ $cartItems->count() }} product(s)</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Quantity:</span>
                        <strong>{{ $cartItems->sum('quantity') }} unit(s)</strong>
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
                        <h5 class="fw-bold">Total:</h5>
                        <h5 class="text-success fw-bold">₹{{ number_format($total, 2) }}</h5>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-success w-100 mb-3 btn-lg">
                        <i class="fas fa-check-circle me-1"></i>Proceed to Checkout
                    </a>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-bag-shopping me-1"></i>Add More Items
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection