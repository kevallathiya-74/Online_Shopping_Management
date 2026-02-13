@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-plus-circle"></i> Create Product</h2>
            <p>Add a new product to your store catalog</p>
        </div>
        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<!-- Create Form -->
<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-edit"></i> Product Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Enter product name"
                           required>
                    @error('name')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" 
                            name="category_id" 
                            required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" 
                          name="description" 
                          rows="3" 
                          placeholder="Enter product description (optional)">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="price" class="form-label">Price (₹) <span class="text-danger">*</span></label>
                    <input type="number" 
                           step="0.01" 
                           min="0.01"
                           class="form-control @error('price') is-invalid @enderror" 
                           id="price" 
                           name="price" 
                           value="{{ old('price') }}" 
                           placeholder="0.00"
                           required>
                    @error('price')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                    <input type="number" 
                           min="0"
                           class="form-control @error('stock') is-invalid @enderror" 
                           id="stock" 
                           name="stock" 
                           value="{{ old('stock', 0) }}" 
                           placeholder="0"
                           required>
                    @error('stock')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="image" class="form-label">Image URL</label>
                    <input type="url" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           value="{{ old('image') }}" 
                           placeholder="https://example.com/image.jpg">
                    @error('image')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Paste any public image URL</small>
                </div>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Product
                </button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
