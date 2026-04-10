@extends('layouts.app')

@section('title', 'My Wishlist - ShopEasy')

@section('content')
<div class="container">
    <x-page-header
        title="My Wishlist"
        subtitle="Save favorite products and move them to cart whenever you are ready."
        icon="fas fa-heart">
        <x-slot name="actions">
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>Continue Shopping
            </a>
        </x-slot>
    </x-page-header>

    @if($wishlistItems->isEmpty())
    <div class="section-card">
        <x-empty-state
            icon="fas fa-heart-crack"
            title="Your wishlist is empty"
            description="Tap the heart icon on any product to save it here.">
            <a href="{{ route('home') }}" class="btn btn-primary">Browse Products</a>
        </x-empty-state>
    </div>
    @else
    <div class="row g-4">
        @foreach($wishlistItems as $item)
        @php $product = $item->product; @endphp
        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="card product-card h-100">
                <div class="product-thumb">
                    @if($product->image)
                    <img src="{{ $product->image }}"
                        alt="{{ $product->name }}"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="d-none h-100 w-100 align-items-center justify-content-center flex-column text-muted">
                        <i class="fas fa-image fa-2x mb-2"></i>
                        <small>Image unavailable</small>
                    </div>
                    @else
                    <div class="d-flex h-100 w-100 align-items-center justify-content-center flex-column text-muted">
                        <i class="fas fa-image fa-2x mb-2"></i>
                        <small>No image</small>
                    </div>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-dark border mb-2">{{ $product->category->name }}</span>
                    <h6 class="product-title mb-2">
                        <a href="{{ route('products.show', $product->id) }}" class="text-dark">{{ Str::limit($product->name, 42) }}</a>
                    </h6>

                    <div class="d-flex justify-content-between align-items-center mt-auto mb-3">
                        <span class="price-tag">₹{{ number_format($product->price, 0) }}</span>
                        @if($product->stock > 0)
                        <span class="stock-badge in-stock">In Stock</span>
                        @else
                        <span class="stock-badge out-of-stock">Out of Stock</span>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>View Product
                        </a>

                        @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-cart-plus me-1"></i>Add to Cart
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-1"></i>Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $wishlistItems->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

