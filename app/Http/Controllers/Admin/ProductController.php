<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')
                ->with('error', 'Please create at least one category before adding products.');
        }

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->validated());

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product "' . $product->name . '" deleted successfully!');
    }
}