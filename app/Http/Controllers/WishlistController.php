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
    $wishlistItems = Wishlist::with('product.category')->where('user_id', Auth::id())->paginate(12);
    return view('user.wishlist', compact('wishlistItems'));
  }

  // Toggle wishlist item
  public function toggle(Request $request, $productId)
  {
    $userId = Auth::id();
    $wishlistItem = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

    if ($wishlistItem) {
      $wishlistItem->delete();
      return back()->with('success', 'Removed from wishlist.');
    } else {
      Wishlist::create([
        'user_id' => $userId,
        'product_id' => $productId
      ]);
      return back()->with('success', 'Added to wishlist.');
    }
  }
}
