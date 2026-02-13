@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-box-open"></i> Products Management</h2>
            <p>Manage your product inventory and pricing</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add New Product
        </a>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> All Products</h5>
            <span class="badge bg-primary">{{ $products->total() }} Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No products found</h5>
                <p class="text-muted mb-3">Start building your product catalog</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add First Product
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th style="width: 80px;">Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center" style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $product->id }}</span></td>
                                <td>
                                    <div style="width: 60px; height: 60px; background-color: #f8f9fc; border: 1px solid #e3e6f0; display: flex; align-items: center; justify-content: center; border-radius: 6px; overflow: hidden;">
                                        @if($product->image)
                                            <img src="{{ $product->image }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <i class="fas fa-image text-muted" style="display: none;"></i>
                                        @else
                                            <i class="fas fa-image text-muted"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong>
                                    @if($product->description)
                                        <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $product->category->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <strong class="text-success">₹{{ number_format($product->price, 2) }}</strong>
                                </td>
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
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-warning me-1" title="Edit Product">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.products.delete', $product->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete the product: {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Product">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Pagination --}}
    @if($products->isNotEmpty() && $products->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <span class="text-muted">
                    Showing <strong>{{ $products->firstItem() }}</strong> to <strong>{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products
                </span>
                <div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
