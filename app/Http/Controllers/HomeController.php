<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Get all products with their categories from database
        $products = Product::with('category')->latest()->paginate(12);
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }
}
