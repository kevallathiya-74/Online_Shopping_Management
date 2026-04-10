@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<x-page-header
    title="Edit Category"
    subtitle="Update category: {{ $category->name }}"
    icon="fas fa-pen-to-square">
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
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('components.admin.category-form-fields', ['category' => $category, 'submitLabel' => 'Update Category'])
        </form>
    </div>
</div>
@endsection
