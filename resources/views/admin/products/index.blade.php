@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2><i class="fas fa-box-open me-2"></i>Products Management</h2>
            <p>Manage inventory, pricing, and product quality across your catalog.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i>Add New Product
        </a>
    </div>
</div>

<div class="section-card admin-table">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>All Products</h5>
        <span class="badge bg-primary">{{ $products->total() }} Total</span>
    </div>

    <div class="card-body p-0">
        @if($products->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
            <h5 class="fw-bold">No products found</h5>
            <p class="text-muted mb-3">Start building your product catalog.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add First Product</a>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td><span class="badge bg-dark-subtle text-dark border">{{ $product->id }}</span></td>
                        <td>
                            <div class="thumb-box">
                                @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-image text-muted d-none"></i>
                                @else
                                <i class="fas fa-image text-muted"></i>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            @if($product->description)
                            <br><small class="text-muted">{{ Str::limit($product->description, 70) }}</small>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $product->category->name ?? 'N/A' }}</span></td>
                        <td><strong class="text-success">₹{{ number_format($product->price, 2) }}</strong></td>
                        <td class="text-center">
                            @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }} units</span>
                            @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $product->stock }} units</span>
                            @else
                            <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                            <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete product: {{ $product->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    @if($products->isNotEmpty() && $products->hasPages())
    <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted">
            Showing <strong>{{ $products->firstItem() }}</strong> to <strong>{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products
        </span>
        <div>{{ $products->links('pagination::bootstrap-5') }}</div>
    </div>
    @endif
</div>
@endsection
