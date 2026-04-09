<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // List wishlist items
    public function index()
    {
        $wishlistItems = Wishlist::with('product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('user.wishlist', compact('wishlistItems'));
    }

    public function add(Request $request, $productId)
    {
        Product::findOrFail($productId);

        $wishlistItem = Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        if (!$wishlistItem->wasRecentlyCreated) {
            return back()->with('info', 'Product is already in your wishlist.');
        }

        return back()->with('success', 'Added to wishlist.');
    }

    public function remove(Request $request, $productId)
    {
        Product::findOrFail($productId);

        $deleted = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        if (!$deleted) {
            return back()->with('info', 'Product was not in your wishlist.');
        }

        return back()->with('success', 'Removed from wishlist.');
    }

    // Backward-compatible endpoint
    public function toggle(Request $request, $productId)
    {
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return $this->remove($request, $productId);
        }

        return $this->add($request, $productId);
    }
}
