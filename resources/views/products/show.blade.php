@extends('layouts.app')

@section('title', $product->name . ' - ShopEasy')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="breadcrumb-shell mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-house me-1"></i>Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category_id) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 48) }}</li>
        </ol>
    </nav>

    @php
    $avgRating = $product->reviews->avg('rating') ?: 0;
    @endphp

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="section-card h-100">
                <div class="card-body p-4">
                    @if($product->image)
                    <div class="product-detail-media">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="d-none align-items-center justify-content-center flex-column text-muted">
                            <i class="fas fa-image fa-4x mb-3"></i>
                            <p class="mb-0">Image not available</p>
                        </div>
                    </div>
                    @else
                    <div class="product-detail-media text-center">
                        <div>
                            <i class="fas fa-image fa-5x text-muted"></i>
                            <p class="mt-3 text-muted mb-0">No image available</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="section-card h-100">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-light text-dark border mb-2">
                        <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                    </span>

                    <h1 class="h3 fw-bold mb-2">{{ $product->name }}</h1>

                    <div class="d-flex align-items-center flex-wrap gap-3 mb-3">
                        <span class="price-tag product-price-lg">₹{{ number_format($product->price, 2) }}</span>
                        <span class="stock-badge {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                            @if($product->stock > 0)
                            <i class="fas fa-check-circle me-1"></i>{{ $product->stock }} in stock
                            @else
                            <i class="fas fa-times-circle me-1"></i>Out of Stock
                            @endif
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= round($avgRating) ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-muted small">{{ number_format($avgRating, 1) }} / 5 ({{ $product->reviews->count() }} reviews)</span>
                    </div>

                    <h5 class="fw-bold mb-2">Product Description</h5>
                    <p class="text-muted mb-4 text-relaxed">
                        {{ $product->description ?? 'No description available for this product.' }}
                    </p>

                    <div class="section-card p-3 mb-4 bg-light-subtle">
                        <div class="row g-2 small">
                            <div class="col-sm-6"><i class="fas fa-truck text-success me-2"></i>Fast dispatch support</div>
                            <div class="col-sm-6"><i class="fas fa-shield text-primary me-2"></i>Quality checked listings</div>
                            <div class="col-sm-6"><i class="fas fa-rotate-left text-warning me-2"></i>Simple cancellation for pending orders</div>
                            <div class="col-sm-6"><i class="fas fa-file-invoice text-info me-2"></i>Invoice available after purchase</div>
                        </div>
                    </div>

                    @auth
                    @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <button class="btn btn-secondary btn-lg w-100 mb-3" disabled>
                        <i class="fas fa-ban me-1"></i>Currently Unavailable
                    </button>
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="fas fa-right-to-bracket me-1"></i>Login to Purchase
                    </a>
                    @endauth

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-1"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section-card mt-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-star text-warning me-1"></i>Customer Reviews ({{ $product->reviews->count() }})</h5>
        </div>
        <div class="card-body p-4">
            <div class="mb-4">
                <h2 class="fw-bold mb-1">{{ number_format($avgRating, 1) }} <small class="text-muted fs-6">/ 5</small></h2>
                <div class="text-warning">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= round($avgRating) ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>
                <small class="text-muted">Based on {{ $product->reviews->count() }} reviews</small>
            </div>

            <hr class="my-4">

            @auth
            @php
            $userReview = $product->reviews->where('user_id', auth()->id())->first();
            @endphp

            @if(!$userReview)
            <h6 class="fw-bold mb-3">Write a Review</h6>
            <form action="{{ route('reviews.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="mb-3">
                    <label class="form-label">Your Rating</label>
                    <div class="btn-group" role="group" aria-label="Rating selector">
                        @for($i = 1; $i <= 5; $i++)
                        <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ (int) old('rating', 5) === $i ? 'checked' : '' }}>
                        <label class="btn btn-outline-warning" for="rating{{ $i }}">{{ $i }} <i class="fas fa-star"></i></label>
                        @endfor
                    </div>
                    @error('rating')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Your Review</label>
                    <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience...">{{ old('comment') }}</textarea>
                    @error('comment')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
            <hr class="my-4">
            @else
            <div class="alert alert-info">
                <i class="fas fa-check-circle me-1"></i>You have already reviewed this product.
            </div>
            @endif
            @else
            <div class="alert alert-light border">
                Please <a href="{{ route('login') }}">login</a> to leave a review.
            </div>
            @endauth

            @forelse($product->reviews as $review)
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mb-1">{{ $review->user->name }}</h6>
                    <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                </div>
                <div class="text-warning mb-2 rating-stars-sm">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                </div>
                <p class="text-muted mb-0">{{ $review->comment ?? $review->review }}</p>
            </div>
            @if(!$loop->last)
            <hr class="my-3">
            @endif
            @empty
            <p class="text-muted text-center py-3">No reviews yet. Be the first to review!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection