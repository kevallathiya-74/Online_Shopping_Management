@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <!-- Categories Filter -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h4>Categories</h4>
            <div class="btn-group" role="group">
                <a href="{{ route('home') }}" class="btn btn-outline-primary {{ !isset($category) ? 'active' : '' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.category', $cat->id) }}" 
                       class="btn btn-outline-primary {{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <h3 class="mb-4">{{ isset($category) ? $category->name : 'All Products' }}</h3>
    
    @if($products->isEmpty())
        <div class="alert alert-info">No products available.</div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                @if($product->image)
                                    <img src="{{ $product->image }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-fluid" 
                                         style="max-height: 150px; object-fit: contain;"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/150x150?text=No+Image'; this.style.opacity='0.5';">
                                @else
                                    <div class="bg-light p-5">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="text-muted small">{{ $product->category->name }}</p>
                            <h5 class="text-primary">₹{{ number_format($product->price, 2) }}</h5>
                            <p class="small text-muted">Stock: {{ $product->stock }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                @auth
                                    @if($product->stock > 0)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Out of Stock</button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login to Buy</a>
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
