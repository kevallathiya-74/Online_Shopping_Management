<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->route('admin.categories')
                ->with('error', 'Cannot delete category "' . $category->name . '" because it has ' . $category->products_count . ' product(s). Please remove or reassign products first.');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }
}