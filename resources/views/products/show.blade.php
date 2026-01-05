@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category_id) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-4">
                    @if($product->image)
                        <div style="height: 450px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border-radius: 15px; padding: 30px;">
                            <img src="{{ $product->image }}" 
                                 alt="{{ $product->name }}" 
                                 style="max-height: 420px; max-width: 100%; object-fit: contain;"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400?text=Image+Not+Available';">
                        </div>
                    @else
                        <div class="text-center p-5" style="background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border-radius: 15px;">
                            <i class="fas fa-image fa-5x text-muted"></i>
                            <p class="mt-3 text-muted">No image available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <span class="badge bg-secondary mb-3">{{ $product->category->name }}</span>
                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
                    
                    <div class="d-flex align-items-center mb-4">
                        <h3 class="price-tag mb-0" style="font-size: 36px;">₹{{ number_format($product->price, 2) }}</h3>
                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} ms-3 p-2">
                            @if($product->stock > 0)
                                <i class="fas fa-check-circle"></i> {{ $product->stock }} in stock
                            @else
                                <i class="fas fa-times-circle"></i> Out of Stock
                            @endif
                        </span>
                    </div>
                    
                    <hr>
                    
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle"></i> Product Description</h5>
                    <p class="text-muted" style="line-height: 1.8;">
                        {{ $product->description ?? 'Experience premium quality with this amazing product. Perfect for your needs!' }}
                    </p>
                    
                    <hr>
                    
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold"><i class="fas fa-sort-numeric-up"></i> Quantity</label>
                                        <input type="number" name="quantity" class="form-control form-control-lg" value="1" min="1" max="{{ $product->stock }}" style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary btn-lg w-100" style="border-radius: 10px; padding: 15px;">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 mb-3" disabled style="border-radius: 10px;">
                                <i class="fas fa-ban"></i> Currently Unavailable
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3" style="border-radius: 10px; padding: 15px;">
                            <i class="fas fa-sign-in-alt"></i> Login to Purchase
                        </a>
                    @endauth
                    
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100" style="border-radius: 10px;">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
