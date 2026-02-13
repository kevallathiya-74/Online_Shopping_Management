@extends('layouts.app')

@section('title', $product->name . ' - ShopEasy')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="background: white; padding: 12px 20px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category_id) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-body p-4">
                    @if($product->image)
                        <div style="height: 400px; display: flex; align-items: center; justify-content: center; background: #f8f9fc; border-radius: 12px; padding: 20px;">
                            <img src="{{ $product->image }}" 
                                 alt="{{ $product->name }}" 
                                 style="max-height: 380px; max-width: 100%; object-fit: contain;"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="display:none; align-items:center; justify-content:center; flex-direction:column; color:#adb5bd;">
                                <i class="fas fa-image fa-4x mb-3"></i>
                                <p class="mb-0">Image not available</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5" style="background: #f8f9fc; border-radius: 12px;">
                            <i class="fas fa-image fa-5x text-muted"></i>
                            <p class="mt-3 text-muted">No image available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-body p-4">
                    <!-- Category Badge -->
                    <span class="badge bg-primary mb-3 px-3 py-2">
                        <i class="fas fa-tag"></i> {{ $product->category->name }}
                    </span>

                    <!-- Product Name -->
                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

                    <!-- Price & Stock -->
                    <div class="d-flex align-items-center mb-4 flex-wrap gap-3">
                        <span class="price-tag" style="font-size: 2.2rem;">₹{{ number_format($product->price, 2) }}</span>
                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                            @if($product->stock > 0)
                                <i class="fas fa-check-circle"></i> {{ $product->stock }} in stock
                            @else
                                <i class="fas fa-times-circle"></i> Out of Stock
                            @endif
                        </span>
                    </div>

                    <hr>

                    <!-- Description -->
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle text-primary"></i> Product Description</h5>
                    <p class="text-muted" style="line-height: 1.8;">
                        {{ $product->description ?? 'No description available for this product.' }}
                    </p>

                    <hr>

                    <!-- Add to Cart / Login -->
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold"><i class="fas fa-sort-numeric-up"></i> Quantity</label>
                                        <input type="number" name="quantity" class="form-control" 
                                               value="1" min="1" max="{{ $product->stock }}">
                                    </div>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 mb-3" disabled>
                                <i class="fas fa-ban"></i> Currently Unavailable
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="fas fa-sign-in-alt"></i> Login to Purchase
                        </a>
                    @endauth

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
