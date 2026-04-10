@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<x-page-header
    title="Edit Product"
    subtitle="Update product: {{ $product->name }}"
    icon="fas fa-pen-to-square">
    <x-slot name="actions">
        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Products
        </a>
    </x-slot>
</x-page-header>

<div class="section-card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-pen-to-square me-2"></i>Product Details</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('components.admin.product-form-fields', ['product' => $product, 'submitLabel' => 'Update Product'])
        </form>
    </div>
</div>
@endsection

@section('scripts')
    @include('components.admin.image-preview-script')
@endsection
