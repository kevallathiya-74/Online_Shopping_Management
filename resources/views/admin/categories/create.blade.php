@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<x-page-header
    title="Create Category"
    subtitle="Add a new product category to keep the storefront organized."
    icon="fas fa-plus-circle">
    <x-slot name="actions">
        <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Categories
        </a>
    </x-slot>
</x-page-header>

<div class="section-card">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="fas fa-pen-to-square me-2"></i>Category Details</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            @include('components.admin.category-form-fields', ['submitLabel' => 'Create Category'])
        </form>
    </div>
</div>
@endsection
