<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Show Cart Page
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();

        // Calculate total dynamically
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Count total items for badge
        $cartCount = $cartItems->sum('quantity');

        return view('cart.index', compact('cartItems', 'total', 'cartCount'));
    }

    // Add to Cart
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Check if product is in stock
        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry! This product is currently out of stock.');
        }

        // Check if product already in cart (prevent duplicates)
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        $requestedQty = $request->input('quantity', 1);

        if ($cartItem) {
            // Product already in cart — update quantity
            $newQty = $cartItem->quantity + $requestedQty;

            // Check stock availability
            if ($newQty > $product->stock) {
                return back()->with('error', 'Cannot add more! Only ' . $product->stock . ' units available. You already have ' . $cartItem->quantity . ' in cart.');
            }

            $cartItem->quantity = $newQty;
            $cartItem->save();

            return redirect()->route('cart.index')
                ->with('success', $product->name . ' quantity updated in cart! (Total: ' . $newQty . ')');
        } else {
            // Check stock for new item
            if ($requestedQty > $product->stock) {
                return back()->with('error', 'Cannot add ' . $requestedQty . ' units. Only ' . $product->stock . ' available.');
            }

            // Create new cart entry
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $requestedQty,
            ]);

            return redirect()->route('cart.index')
                ->with('success', $product->name . ' added to cart successfully!');
        }
    }

    // Update Cart Quantity
    public function update(Request $request, $id)
    {
        // Validate quantity input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find cart item belonging to current user only
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        // Check stock availability
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Cannot set quantity to ' . $request->quantity . '. Only ' . $product->stock . ' units available.');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated! ' . $product->name . ' quantity set to ' . $request->quantity . '.');
    }

    // Remove Item from Cart
    public function remove($id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $productName = $cartItem->product->name;
        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', $productName . ' removed from cart.');
    }
}
