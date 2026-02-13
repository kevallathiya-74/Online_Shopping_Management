@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-tags"></i> Categories Management</h2>
            <p>Manage your product categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add Category
        </a>
    </div>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> All Categories</h5>
            <span class="badge bg-primary">{{ $categories->count() }} Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        @if($categories->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No categories found</h5>
                <p class="text-muted mb-3">Start by creating your first category</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create First Category
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th class="text-center">Products</th>
                            <th class="text-center" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $category->id }}</span></td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>
                                    @if($category->description)
                                        <span class="text-muted">{{ Str::limit($category->description, 60) }}</span>
                                    @else
                                        <span class="text-muted fst-italic">No description</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $category->products_count > 0 ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $category->products_count }} product(s)
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                       class="btn btn-sm btn-warning me-1" title="Edit Category">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.delete', $category->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this category?{{ $category->products_count > 0 ? ' This category has ' . $category->products_count . ' product(s).' : '' }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Category">
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
</div>
@endsection
