@extends('layouts.app')

@section('title', 'Shopping Cart - ShopEasy')

@section('content')
<div class="container">
    <x-page-header
        title="Shopping Cart"
        subtitle="{{ $cartItems->isNotEmpty() ? 'You have ' . $cartItems->count() . ' item(s) ready for checkout.' : 'Your cart is currently empty.' }}"
        icon="fas fa-cart-shopping">
        <x-slot name="actions">
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>Continue Shopping
            </a>
        </x-slot>
    </x-page-header>

    @if($cartItems->isEmpty())
    <div class="section-card">
        <x-empty-state
            icon="fas fa-cart-shopping"
            title="Your cart is empty"
            description="Add products from the catalog and return here to checkout.">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-bag-shopping me-1"></i>Start Shopping
            </a>
        </x-empty-state>
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
                    @php($product = $item->product)
                    <div class="row g-3 align-items-center py-2 {{ !$loop->last ? 'border-bottom mb-3 pb-4' : '' }}">
                        <div class="col-md-2 col-3">
                            <div class="thumb-box thumb-square-86 mx-auto mx-md-0">
                                @if($product?->image)
                                <img src="{{ $product->image }}"
                                    alt="{{ $product->name }}"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-image fa-2x text-muted d-none"></i>
                                @else
                                <i class="fas fa-image fa-2x text-muted"></i>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 col-9">
                            <h6 class="mb-1 fw-bold product-title product-title-tight">
                                @if($product)
                                <a href="{{ route('products.show', $product->id) }}" class="text-dark">
                                    {{ $product->name }}
                                </a>
                                @else
                                <span class="text-muted">Product unavailable</span>
                                @endif
                            </h6>
                            <span class="badge bg-light text-dark border mb-1">
                                {{ $product?->category?->name ?? 'Uncategorized' }}
                            </span>
                            <p class="text-success mb-0 fw-bold">₹{{ number_format($product?->price ?? 0, 2) }} each</p>
                        </div>

                        <div class="col-md-3 col-6">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="form-label small">Quantity</label>
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control"
                                        value="{{ $item->quantity }}" min="1" max="{{ $product?->stock ?? $item->quantity }}">
                                    <button type="submit" class="btn btn-outline-primary" title="Update Quantity">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1">Max: {{ $product?->stock ?? $item->quantity }}</small>
                            </form>
                        </div>

                        <div class="col-md-2 col-6 text-center">
                            <p class="small text-muted mb-1">Subtotal</p>
                            <h6 class="fw-bold text-success mb-0">
                                ₹{{ number_format(($product?->price ?? 0) * $item->quantity, 2) }}
                            </h6>
                        </div>

                        <div class="col-md-1 col-12 text-end">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                onsubmit="return confirm('Remove {{ $product?->name ?? 'this item' }} from cart?')">
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
                    <div class="summary-list">
                        <div class="summary-row">
                            <span class="text-muted">Items:</span>
                            <strong>{{ $cartItems->count() }} product(s)</strong>
                        </div>
                        <div class="summary-row">
                            <span class="text-muted">Total Quantity:</span>
                            <strong>{{ $cartItems->sum('quantity') }} unit(s)</strong>
                        </div>
                        <div class="summary-row">
                            <span class="text-muted">Subtotal:</span>
                            <strong>₹{{ number_format($total, 2) }}</strong>
                        </div>
                        <div class="summary-row">
                            <span class="text-muted">Shipping:</span>
                            <strong class="text-success">FREE</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="summary-row mb-4">
                        <h5 class="fw-bold mb-0">Total:</h5>
                        <h5 class="text-success fw-bold mb-0">₹{{ number_format($total, 2) }}</h5>
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

