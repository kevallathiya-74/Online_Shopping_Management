@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
<x-page-header
    title="Create Product"
    subtitle="Add a new product to your catalog with complete listing details and a clean preview."
    icon="fas fa-plus-circle">
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
