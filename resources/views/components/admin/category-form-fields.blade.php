@php
    $editing = isset($category);
@endphp

<div class="mb-3">
    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
    <input type="text"
        class="form-control @error('name') is-invalid @enderror"
        id="name"
        name="name"
        value="{{ old('name', $editing ? $category->name : '') }}"
        placeholder="Enter category name"
        required>
    @error('name')
        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror"
        id="description"
        name="description"
        rows="3"
        placeholder="Enter category description (optional)">{{ old('description', $editing ? $category->description : '') }}</textarea>
    @error('description')
        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2 flex-wrap">
    <button type="submit" class="btn btn-primary px-4">
        <i class="fas fa-save me-1"></i>{{ $submitLabel }}
    </button>
    <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary">
        <i class="fas fa-xmark me-1"></i>Cancel
    </a>
</div>