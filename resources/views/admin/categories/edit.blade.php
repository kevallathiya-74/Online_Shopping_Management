@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-edit"></i> Edit Category</h2>
            <p>Update category: <strong>{{ $category->name }}</strong></p>
        </div>
        <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<!-- Edit Form -->
<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-edit"></i> Category Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $category->name) }}" 
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
                          placeholder="Enter category description (optional)">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Category
                </button>
                <a href="{{ route('admin.categories') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
