<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Show single product detail
    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Store review
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($id);

        // Check if user already reviewed
        $existingReview = \App\Models\ProductReview::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        // Check if user has purchased the product (optional but recommended for "verified purchase")
        // For now, we allow any logged in user as per requirement "users to leave... ratings", assumes purchased but requirement says "users... rate products they have purchased".
        // I should check if they purchased it.
        $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
            ->whereHas('orderItems', function ($q) use ($id) {
                $q->where('product_id', $id);
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        \App\Models\ProductReview::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    // Filter products by category
    public function byCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = Product::where('category_id', $categoryId)->with('category')->paginate(12);
        $categories = Category::all();

        return view('home', compact('products', 'categories', 'category'));
    }
}
