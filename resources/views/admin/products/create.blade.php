@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-plus-circle me-2"></i>Create Product</h2>
            <p>Add a new product to your store catalog with complete listing details.</p>
        </div>
        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Products
        </a>
    </div>
</div>

<div class="section-card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-pen-to-square me-2"></i>Product Details</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            @include('components.admin.product-form-fields', ['submitLabel' => 'Create Product'])
        </form>
    </div>
</div>
@endsection

@section('scripts')
    @include('components.admin.image-preview-script')
@endsection
