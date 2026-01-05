@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ $product->image }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded" 
                     style="max-height: 400px; width: 100%; object-fit: contain;"
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400?text=Image+Not+Available'; this.style.opacity='0.7';">
            @else
                <div class="bg-light p-5 text-center rounded">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">Category: {{ $product->category->name }}</p>
            <h3 class="text-primary">₹{{ number_format($product->price, 2) }}</h3>
            <p><strong>Stock Available:</strong> {{ $product->stock }}</p>
            
            <hr>
            
            <h5>Description</h5>
            <p>{{ $product->description ?? 'No description available.' }}</p>
            
            <hr>
            
            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login to Purchase</a>
            @endauth
            
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>
</div>
@endsection
