@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; border-radius: 20px;">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 fw-bold mb-3"><i class="fas fa-shopping-bag"></i> Welcome to ShopEasy</h1>
                    <p class="lead mb-0">Discover amazing products at great prices!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Filter -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h4 class="mb-3 fw-bold"><i class="fas fa-filter"></i> Shop by Category</h4>
            <div class="d-flex flex-wrap">
                <a href="{{ route('home') }}" class="btn btn-outline-primary category-btn {{ !isset($category) ? 'active' : '' }}">
                    <i class="fas fa-th"></i> All Products
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.category', $cat->id) }}" 
                       class="btn btn-outline-primary category-btn {{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
                        @if($cat->name == 'Electronics')<i class="fas fa-laptop"></i>
                        @elseif($cat->name == 'Clothing')<i class="fas fa-tshirt"></i>
                        @elseif($cat->name == 'Books')<i class="fas fa-book"></i>
                        @elseif($cat->name == 'Home & Kitchen')<i class="fas fa-home"></i>
                        @elseif($cat->name == 'Sports')<i class="fas fa-basketball-ball"></i>
                        @else<i class="fas fa-tag"></i>@endif
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-boxes"></i> {{ isset($category) ? $category->name : 'All Products' }}
        </h3>
        <span class="badge badge-custom">{{ $products->total() }} Products</span>
    </div>
    
    @if($products->isEmpty())
        <div class="alert alert-info" style="border-radius: 12px; border-left: 4px solid #3b82f6;">
            <i class="fas fa-info-circle"></i> No products available in this category.
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body p-3">
                            <div class="product-image-container">
                                @if($product->image)
                                    <img src="{{ $product->image }}" 
                                         alt="{{ $product->name }}" 
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/200x200?text=No+Image'; this.style.opacity='0.5';">
                                @else
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                @endif
                            </div>
                            
                            <span class="badge bg-secondary mb-2" style="font-size: 10px;">
                                {{ $product->category->name }}
                            </span>
                            
                            <h6 class="card-title fw-bold mb-2" style="height: 40px; overflow: hidden;">
                                {{ Str::limit($product->name, 30) }}
                            </h6>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="price-tag">₹{{ number_format($product->price, 2) }}</span>
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}" style="font-size: 10px;">
                                    @if($product->stock > 0)
                                        <i class="fas fa-check-circle"></i> In Stock
                                    @else
                                        <i class="fas fa-times-circle"></i> Out of Stock
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-0 p-3 pt-0">
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                @auth
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-ban"></i> Unavailable
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sign-in-alt"></i> Login to Buy
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
