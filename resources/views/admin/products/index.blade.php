@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="fas fa-box-open"></i> Products Management</h2>
                <p class="text-muted mb-0">Manage your product inventory</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Add New Product
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-box fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No products found</h5>
                    <p class="text-muted mb-4">Start by adding your first product</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 80px;"><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-image"></i> Image</th>
                                <th><i class="fas fa-tag"></i> Name</th>
                                <th><i class="fas fa-folder"></i> Category</th>
                                <th><i class="fas fa-rupee-sign"></i> Price</th>
                                <th><i class="fas fa-boxes"></i> Stock</th>
                                <th class="text-center" style="width: 200px;"><i class="fas fa-cog"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $product->id }}</span></td>
                                    <td>
                                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            @if($product->image)
                                                <img src="{{ $product->image }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                            @else
                                                <i class="fas fa-image text-muted"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td><strong class="text-success">₹{{ number_format($product->price, 2) }}</strong></td>
                                    <td>
                                        @if($product->stock > 10)
                                            <span class="badge bg-success">{{ $product->stock }} units</span>
                                        @elseif($product->stock > 0)
                                            <span class="badge bg-warning">{{ $product->stock }} units</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning me-1" style="border-radius: 8px;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 8px;">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
