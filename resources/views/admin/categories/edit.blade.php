@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-pen-to-square me-2"></i>Edit Category</h2>
            <p>Update category: <strong>{{ $category->name }}</strong></p>
        </div>
        <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Categories
        </a>
    </div>
</div>

<div class="section-card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-pen-to-square me-2"></i>Category Details</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('components.admin.category-form-fields', ['category' => $category, 'submitLabel' => 'Update Category'])
        </form>
    </div>
</div>
@endsection
