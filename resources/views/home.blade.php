@extends('layouts.app')

@section('title', isset($category) ? $category->name . ' - ShopEasy' : 'Home - ShopEasy')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); border: none; border-radius: 16px; overflow: hidden;">
        <div class="card-body text-white text-center py-5">
            <h1 class="fw-bold mb-2"><i class="fas fa-shopping-bag"></i> Welcome to ShopEasy</h1>
            <p class="mb-3 opacity-75 fs-5">Discover amazing products at great prices!</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            @endguest
        </div>
    </div>

    <!-- Category Filter -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <h5 class="fw-bold mb-3"><i class="fas fa-filter text-primary"></i> Shop by Category</h5>
            <div class="d-flex flex-wrap">
                <a href="{{ route('home') }}" 
                   class="btn btn-outline-primary category-btn {{ !isset($category) ? 'active' : '' }}">
                    <i class="fas fa-th"></i> All Products
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.category', $cat->id) }}" 
                       class="btn btn-outline-primary category-btn {{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
                        <i class="fas fa-tag"></i> {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-boxes text-primary"></i> 
            {{ isset($category) ? $category->name : 'All Products' }}
        </h3>
        <span class="badge-custom">{{ $products->total() }} Products</span>
    </div>

    <!-- Products Grid -->
    @if($products->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No products available</h5>
                <p class="text-muted">
                    @if(isset($category))
                        No products found in "{{ $category->name }}" category.
                        <br><a href="{{ route('home') }}" class="text-primary">View all products</a>
                    @else
                        Products will appear here once they are added.
                    @endif
                </p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100">
                        <div class="card-body p-3">
                            <!-- Product Image -->
                            <div class="product-image-container">
                                @if($product->image)
                                    <img src="{{ $product->image }}" 
                                         alt="{{ $product->name }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display:none; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#adb5bd;">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <small>Image not available</small>
                                    </div>
                                @else
                                    <div style="display:flex; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#adb5bd;">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <small>No image</small>
                                    </div>
                                @endif
                            </div>

                            <!-- Category Badge -->
                            <span class="badge bg-primary mb-2" style="font-size: 0.7rem;">
                                {{ $product->category->name }}
                            </span>

                            <!-- Product Name -->
                            <h6 class="card-title fw-bold mb-2" style="height: 38px; overflow: hidden; line-height: 1.4;">
                                {{ Str::limit($product->name, 35) }}
                            </h6>

                            <!-- Price & Stock -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="price-tag" style="font-size: 1.3rem;">₹{{ number_format($product->price, 0) }}</span>
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}" style="font-size: 0.65rem;">
                                    @if($product->stock > 0)
                                        <i class="fas fa-check-circle"></i> In Stock
                                    @else
                                        <i class="fas fa-times-circle"></i> Out of Stock
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
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
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif
</div>
@endsection
