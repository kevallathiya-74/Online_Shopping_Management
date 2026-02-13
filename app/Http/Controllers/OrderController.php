<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;

class OrderController extends Controller
{
    // =============================================
    // CHECKOUT PAGE
    // =============================================
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();

        // Redirect if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty! Add products before checking out.');
        }

        // Check stock availability before checkout
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', 'Product "' . $item->product->name . '" has only ' . $item->product->stock . ' units in stock. Please update your cart.');
            }
        }

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $user = Auth::user();

        return view('orders.checkout', compact('cartItems', 'total', 'user'));
    }

    // =============================================
    // PLACE ORDER (with Transaction)
    // =============================================
    public function placeOrder(Request $request)
    {
        // Validate shipping details and payment method
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:15',
            'payment_method' => 'required|in:online,offline',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty! Cannot place order.');
        }

        // Re-check stock availability
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', 'Product "' . $item->product->name . '" is out of stock or has limited quantity. Please update your cart.');
            }
        }

        // Calculate total from cart (not from form — prevents price manipulation)
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Start database transaction (either all succeed or all fail)
        DB::beginTransaction();

        try {
            // Step 1: Create the Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
            ]);

            // Step 2: Create Order Items + Deduct Stock
            foreach ($cartItems as $cartItem) {
                // Save each item at current price (price is locked at order time)
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Deduct stock
                $product = Product::find($cartItem->product_id);
                $product->stock -= $cartItem->quantity;
                $product->save();
            }

            // Step 3: Clear the cart after successful order
            Cart::where('user_id', Auth::id())->delete();

            // Commit all changes to database
            DB::commit();

            // Redirect to order confirmation page
            return redirect()->route('orders.confirmation', $order->id)
                ->with('success', 'Order placed successfully! Your Order ID is #' . $order->id);

        } catch (\Exception $e) {
            // Rollback all changes if anything fails
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }
    }

    // =============================================
    // ORDER CONFIRMATION
    // =============================================
    public function confirmation($id)
    {
        // Only show order if it belongs to current user
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('orderItems.product')
            ->firstOrFail();

        return view('orders.confirmation', compact('order'));
    }

    // =============================================
    // ORDER HISTORY
    // =============================================
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // =============================================
    // VIEW SINGLE ORDER
    // =============================================
    public function show($id)
    {
        // Security: Only show order if it belongs to current user
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('orderItems.product.category')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    // =============================================
    // CANCEL ORDER (User can cancel only pending orders)
    // =============================================
    public function cancelOrder($id)
    {
        // Step 1: Find order — must belong to current user
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('orderItems.product')
            ->firstOrFail();

        // Step 2: Check if order can be cancelled
        // Only "pending" orders are allowed to be cancelled
        if ($order->status == 'cancelled') {
            return back()->with('error', 'This order is already cancelled.');
        }

        if ($order->status == 'completed') {
            return back()->with('error', 'Cannot cancel this order because it has already been completed and delivered.');
        }

        if ($order->status == 'processing') {
            return back()->with('error', 'Cannot cancel this order because it is already being processed. Please contact support for help.');
        }

        if ($order->status != 'pending') {
            return back()->with('error', 'This order cannot be cancelled at this stage.');
        }

        // Step 3: Cancel order + Restore stock (using transaction)
        DB::beginTransaction();

        try {
            // Restore stock for each order item
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            // Update order status to cancelled
            $order->status = 'cancelled';
            $order->save();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order #' . $order->id . ' has been cancelled successfully. Product stock has been restored.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order. Please try again later.');
        }
    }
}
