@php
    $editing = isset($product);
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
        <input type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            name="name"
            value="{{ old('name', $editing ? $product->name : '') }}"
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
                <option value="{{ $category->id }}" {{ old('category_id', $editing ? $product->category_id : null) == $category->id ? 'selected' : '' }}>
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
        placeholder="Enter product description (optional)">{{ old('description', $editing ? $product->description : '') }}</textarea>
    @error('description')
        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Price (Rs) <span class="text-danger">*</span></label>
        <input type="number"
            step="0.01"
            min="0.01"
            class="form-control @error('price') is-invalid @enderror"
            id="price"
            name="price"
            value="{{ old('price', $editing ? $product->price : '') }}"
            placeholder="0.00"
            required>
        @error('price')
            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
        <input type="number"
            min="0"
            class="form-control @error('stock') is-invalid @enderror"
            id="stock"
            name="stock"
            value="{{ old('stock', $editing ? $product->stock : 0) }}"
            placeholder="0"
            required>
        @error('stock')
            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-8">
        <label for="image" class="form-label">Image URL</label>
        <input type="url"
            class="form-control @error('image') is-invalid @enderror"
            id="image"
            name="image"
            value="{{ old('image', $editing ? $product->image : '') }}"
            placeholder="https://example.com/image.jpg"
            oninput="previewImage(this.value)">
        @error('image')
            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
        <div id="imageStatus" class="mt-1"></div>

        <div class="alert alert-light border mt-2 mb-0 py-2">
            <small><i class="fas fa-info-circle text-primary me-1"></i>Use a direct image URL (.jpg, .png, .webp) for best preview.</small>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Image Preview</label>
        <div id="imagePreviewBox" class="product-preview-box">
            <div id="imagePreviewPlaceholder" class="text-center text-muted">
                <i class="fas fa-image fa-2x mb-2"></i>
                <br><small>Paste URL to preview</small>
            </div>
            <img id="imagePreviewImg" src="" alt="Preview" class="product-preview-image d-none">
        </div>
    </div>
</div>

<hr>
<div class="d-flex gap-2 flex-wrap">
    <button type="submit" class="btn btn-primary px-4">
        <i class="fas fa-save me-1"></i>{{ $submitLabel }}
    </button>
    <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
        <i class="fas fa-xmark me-1"></i>Cancel
    </a>
</div>