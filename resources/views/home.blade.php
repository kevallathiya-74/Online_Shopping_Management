@extends('layouts.app')

@section('title', isset($category) ? $category->name . ' - ShopEasy' : 'Home - ShopEasy')

@section('content')
<div class="container">
    <div class="section-card hero-banner mb-4">
        <div class="card-body p-4 p-lg-5">
            <span class="hero-highlight mb-3"><i class="fas fa-bolt"></i> New arrivals every week</span>
            <h1 class="hero-title mt-3">Premium picks for everyday shopping</h1>
            <p class="hero-subtitle">Discover trusted products with transparent pricing, simple checkout, and fast order updates from one clean shopping experience.</p>

            <form action="{{ route('home') }}" method="GET" class="search-strip mt-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text"><i class="fas fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search products by name or category" value="{{ request('search') }}">
                    <button class="btn btn-light fw-bold" type="submit">Search</button>
                </div>
            </form>

            @guest
            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="{{ route('register') }}" class="btn btn-light">
                    <i class="fas fa-user-plus me-1"></i>Create Account
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light">
                    <i class="fas fa-right-to-bracket me-1"></i>Login
                </a>
            </div>
            @endguest
        </div>
    </div>

    <div class="section-card mb-4">
        <div class="card-body">
            <div class="section-header">
                <div>
                    <h3 class="section-title"><i class="fas fa-layer-group me-2 text-primary"></i>Shop by Category</h3>
                    <p class="section-subtitle">Pick a category to quickly narrow your results.</p>
                </div>
            </div>

            <div>
                <a href="{{ route('home', request()->except(['category_id', 'page'])) }}" class="category-pill {{ !request('category_id') ? 'active' : '' }}">
                    <i class="fas fa-grid-2"></i>All Products
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('home', array_merge(request()->except(['category_id', 'page']), ['category_id' => $cat->id])) }}"
                    class="category-pill {{ (string) request('category_id') === (string) $cat->id ? 'active' : '' }}">
                    <i class="fas fa-tag"></i>{{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="section-card filter-panel">
                <div class="card-body">
                    <h5 class="section-title mb-2"><i class="fas fa-sliders me-2 text-primary"></i>Filters</h5>
                    <p class="section-subtitle mb-3">Refine results by category, price, and sorting.</p>

                    <form action="{{ route('home') }}" method="GET">
                        @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (string) request('category_id') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sort" class="form-label">Sort By</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                                <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="section-header mb-3">
                <div>
                    <h3 class="section-title mb-1">{{ isset($category) ? $category->name : 'All Products' }}</h3>
                    <p class="section-subtitle">Curated listing with clean product details and fast actions.</p>
                </div>
                <span class="badge-soft">{{ $products->total() }} products</span>
            </div>

            @if($products->isEmpty())
            <div class="section-card">
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                    <h5 class="fw-bold">No products found</h5>
                    <p class="text-muted mb-3">
                        @if(isset($category))
                        Nothing is available in "{{ $category->name }}" right now.
                        @elseif(request('search') || request('min_price') || request('max_price'))
                        No results match your search or filter combination.
                        @else
                        Products will appear here as soon as inventory is added.
                        @endif
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">View all products</a>
                </div>
            </div>
            @else
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-xl-4 col-md-6">
                    <div class="card product-card h-100">
                        <div class="product-thumb">
                            @auth
                            <form action="{{ $product->inWishlist() ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id) }}" method="POST">
                                @csrf
                                @if($product->inWishlist())
                                @method('DELETE')
                                @endif
                                <button type="submit" class="wishlist-fab" title="Wishlist">
                                    <i class="{{ $product->inWishlist() ? 'fas text-danger' : 'far' }} fa-heart"></i>
                                </button>
                            </form>
                            @endauth

                            @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
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
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark border">{{ $product->category->name }}</span>
                                @if($product->stock > 0)
                                <span class="stock-badge in-stock">In Stock</span>
                                @else
                                <span class="stock-badge out-of-stock">Out of Stock</span>
                                @endif
                            </div>

                            <h6 class="product-title">{{ Str::limit($product->name, 44) }}</h6>

                            <p class="product-meta mb-3">{{ Str::limit($product->description ?? 'Quality product with verified listing details.', 70) }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-auto mb-3">
                                <span class="price-tag">₹{{ number_format($product->price, 0) }}</span>
                                <small class="text-muted">{{ max((int) $product->stock, 0) }} left</small>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>

                                @auth
                                @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                    </button>
                                </form>
                                @else
                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                    Unavailable
                                </button>
                                @endif
                                @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-right-to-bracket me-1"></i>Login to Buy
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
            @endif
            @endif
        </div>
    </div>

    @php
    $featuredProducts = $products->take(3);
    @endphp

    @if($featuredProducts->isNotEmpty())
    <div class="section-card mt-4">
        <div class="card-body">
            <div class="section-header">
                <div>
                    <h4 class="section-title"><i class="fas fa-star me-2 text-warning"></i>Featured This Week</h4>
                    <p class="section-subtitle">A few highlighted products customers are currently exploring.</p>
                </div>
            </div>

            <div class="row g-3">
                @foreach($featuredProducts as $featured)
                <div class="col-md-4">
                    <a href="{{ route('products.show', $featured->id) }}" class="section-card d-block p-3 h-100 text-dark">
                        <div class="d-flex align-items-center gap-3">
                            <div class="admin-table thumb-box thumb-square-64">
                                @if($featured->image)
                                <img src="{{ $featured->image }}" alt="{{ $featured->name }}">
                                @else
                                <i class="fas fa-image text-muted"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-bold">{{ Str::limit($featured->name, 30) }}</div>
                                <div class="small text-muted">{{ $featured->category->name }}</div>
                                <div class="fw-bold mt-1">₹{{ number_format($featured->price, 0) }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection