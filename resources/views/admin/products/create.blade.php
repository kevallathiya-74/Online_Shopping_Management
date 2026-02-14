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

            </div>

            <!-- Image URL with Live Preview -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="image" class="form-label">Image URL</label>
                    <input type="url" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           value="{{ old('image') }}" 
                           placeholder="https://example.com/image.jpg"
                           oninput="previewImage(this.value)">
                    @error('image')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div id="imageStatus" class="mt-1"></div>
                    
                    <div class="alert alert-light border mt-2 mb-0 py-2">
                        <small class="fw-bold"><i class="fas fa-info-circle text-primary"></i> How to get the correct Image URL:</small>
                        <ol class="mb-0 mt-1 small text-muted" style="padding-left: 18px;">
                            <li>Search for a product image on Google</li>
                            <li><strong>Right-click</strong> on the image → <strong>"Open image in new tab"</strong></li>
                            <li>Copy the URL from the new tab (it should end with <code>.jpg</code>, <code>.png</code>, <code>.webp</code>)</li>
                            <li>Paste it here and check the preview</li>
                        </ol>
                        <small class="text-danger mt-1 d-block"><i class="fas fa-times-circle"></i> Don't paste the Google search page URL — paste the direct image URL only.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Image Preview</label>
                    <div id="imagePreviewBox" style="width: 100%; height: 160px; background: #f8f9fc; border: 2px dashed #dee2e6; border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <div id="imagePreviewPlaceholder" style="text-align: center; color: #adb5bd;">
                            <i class="fas fa-image fa-2x mb-2"></i>
                            <br><small>Paste URL to see preview</small>
                        </div>
                        <img id="imagePreviewImg" src="" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                    </div>
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

@section('scripts')
<script>
    // Live Image Preview when admin pastes a URL
    function previewImage(url) {
        var img = document.getElementById('imagePreviewImg');
        var placeholder = document.getElementById('imagePreviewPlaceholder');
        var previewBox = document.getElementById('imagePreviewBox');
        var status = document.getElementById('imageStatus');

        // If URL is empty, show placeholder
        if (!url || url.trim() === '') {
            img.style.display = 'none';
            placeholder.style.display = 'block';
            previewBox.style.borderColor = '#dee2e6';
            status.innerHTML = '';
            return;
        }

        // Try to load the image
        status.innerHTML = '<small class="text-info"><i class="fas fa-spinner fa-spin"></i> Loading image...</small>';
        
        img.onload = function() {
            // Image loaded successfully
            img.style.display = 'block';
            placeholder.style.display = 'none';
            previewBox.style.borderColor = '#198754';
            previewBox.style.borderStyle = 'solid';
            status.innerHTML = '<small class="text-success"><i class="fas fa-check-circle"></i> Image loaded successfully!</small>';
        };

        img.onerror = function() {
            // Image failed to load
            img.style.display = 'none';
            placeholder.style.display = 'block';
            placeholder.innerHTML = '<i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i><br><small class="text-danger">Could not load image</small>';
            previewBox.style.borderColor = '#dc3545';
            previewBox.style.borderStyle = 'solid';
            status.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle"></i> Could not load this URL. Make sure it is a direct image link (ending with .jpg, .png, .webp).</small>';
        };

        img.src = url;
    }

    // Auto-preview if URL already filled (e.g. after validation error)
    document.addEventListener('DOMContentLoaded', function() {
        var imageInput = document.getElementById('image');
        if (imageInput && imageInput.value) {
            previewImage(imageInput.value);
        }
    });
</script>
@endsection
