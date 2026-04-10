@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<x-page-header
    title="Categories Management"
    subtitle="Create and organize product groups for better catalog navigation."
    icon="fas fa-tags"
    badge="{{ $categories->count() }} Categories">
    <x-slot name="actions">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i>Add Category
        </a>
    </x-slot>
</x-page-header>

<div class="section-card admin-table">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>All Categories</h5>
        <span class="badge bg-primary">{{ $categories->count() }} Total</span>
    </div>

    <div class="card-body p-0">
        @if($categories->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-tags"></i></div>
            <h5 class="fw-bold">No categories found</h5>
            <p class="text-muted mb-3">Create your first category to organize inventory.</p>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create First Category</a>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th class="text-center">Products</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td><span class="badge bg-dark-subtle text-dark border">{{ $category->id }}</span></td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>
                            @if($category->description)
                            <span class="text-muted">{{ Str::limit($category->description, 70) }}</span>
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
                            <div class="table-actions justify-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this category?{{ $category->products_count > 0 ? ' It has ' . $category->products_count . ' product(s).' : '' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
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
