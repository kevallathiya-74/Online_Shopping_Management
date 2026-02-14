@extends('layouts.app')

@section('title', 'My Wishlist - ShopEasy')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="fas fa-heart text-danger"></i> My Wishlist</h2>
    <a href="{{ route('home') }}" class="btn btn-outline-primary">
      <i class="fas fa-arrow-left"></i> Continue Shopping
    </a>
  </div>

  @if($wishlistItems->isEmpty())
  <div class="card">
    <div class="card-body text-center py-5">
      <i class="fas fa-heart-broken fa-3x text-muted mb-3"></i>
      <h5 class="text-muted">Your wishlist is empty</h5>
      <p class="text-muted">Start saving your favorite items!</p>
      <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Products</a>
    </div>
  </div>
  @else
  <div class="row g-4">
    @foreach($wishlistItems as $item)
    @php $product = $item->product; @endphp
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
            <a href="{{ route('products.show', $product->id) }}" class="text-dark text-decoration-none">
              {{ Str::limit($product->name, 35) }}
            </a>
          </h6>

          <!-- Price -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="price-tag" style="font-size: 1.3rem;">₹{{ number_format($product->price, 0) }}</span>
          </div>

          <!-- Remove Button -->
          <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
              <i class="fas fa-trash"></i> Remove
            </button>
          </form>
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