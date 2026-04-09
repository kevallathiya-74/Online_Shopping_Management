<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:120',
            'category_id' => 'nullable|integer|exists:categories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
            'sort' => 'nullable|in:newest,price_low_high,price_high_low',
        ]);

        $query = Product::with('category');

        if (Auth::check()) {
            $query->with(['wishlists' => function ($wishlistQuery) {
                $wishlistQuery->where('user_id', Auth::id());
            }]);
        }

        // Search by product name
        if (!empty($validated['search'])) {
            $query->where('name', 'like', '%' . trim($validated['search']) . '%');
        }

        // Category filter
        $category = null;
        if (!empty($validated['category_id'])) {
            $query->where('category_id', (int) $validated['category_id']);
            $category = Category::find((int) $validated['category_id']);
        }

        // Price Filter
        if (isset($validated['min_price'])) {
            $query->where('price', '>=', $validated['min_price']);
        }
        if (isset($validated['max_price'])) {
            $query->where('price', '<=', $validated['max_price']);
        }

        // Sorting
        if (!empty($validated['sort'])) {
            switch ($validated['sort']) {
                case 'price_low_high':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('home', compact('products', 'categories', 'category'));
    }
}
