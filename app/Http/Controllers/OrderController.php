<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Services\InventoryService;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    private CartService $cartService;
    private InventoryService $inventoryService;

    public function __construct(CartService $cartService, InventoryService $inventoryService)
    {
        $this->cartService = $cartService;
        $this->inventoryService = $inventoryService;
    }

    // =============================================
    // CHECKOUT PAGE
    // =============================================
    public function checkout()
    {
        $cartItems = $this->cartService->getUserCartItems(Auth::id(), true);

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
        $total = $this->cartService->calculateTotal($cartItems);

        $user = Auth::user();

        return view('orders.checkout', compact('cartItems', 'total', 'user'));
    }

    // =============================================
    // PLACE ORDER (with Transaction & Razorpay support)
    // =============================================
    public function placeOrder(Request $request)
    {
        // Validate shipping details and payment method
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:15',
            'payment_method' => 'required|in:online,offline',
        ]);

        $cartItems = $this->cartService->getUserCartItems(Auth::id());

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

        // Calculate total 
        $total = $this->cartService->calculateTotal($cartItems);

        // ---------------------------------------------------------
        // HANDLE ONLINE PAYMENT (RAZORPAY)
        // ---------------------------------------------------------
        if ($request->payment_method == 'online') {
            try {
                $api = new \Razorpay\Api\Api(config('services.razorpay.key_id'), config('services.razorpay.key_secret'));

                // Create Razorpay Order
                $razorpayOrder = $api->order->create([
                    'receipt'         => 'order_rcpt_' . time(),
                    'amount'          => $total * 100, // amount in paise
                    'currency'        => 'INR',
                    'payment_capture' => 1 // auto capture
                ]);

                // Store Razorpay Order ID and shipping details in session for verification
                session([
                    'razorpay_order_id' => $razorpayOrder['id'],
                    'shipping_address'  => $request->shipping_address,
                    'phone'             => $request->phone,
                    'checkout_user_id'  => Auth::id(),
                ]);

                // Return data for the frontend Razorpay modal
                return response()->json([
                    'success'           => true,
                    'payment_method'    => 'online',
                    'razorpay_order_id' => $razorpayOrder['id'],
                    'amount'            => $total * 100,
                    'name'              => Auth::user()->name,
                    'email'             => Auth::user()->email,
                    'contact'           => $request->phone,
                    'key_id'            => config('services.razorpay.key_id'),
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => 'Razorpay Error: ' . $e->getMessage()], 500);
            }
        }

        // ---------------------------------------------------------
        // HANDLE OFFLINE (COD) - Original Logic
        // ---------------------------------------------------------
        try {
            $order = $this->createOrderFromCart($cartItems, [
                'user_id' => Auth::id(),
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'redirect' => route('orders.confirmation', $order->id)]);
            }

            return redirect()->route('orders.confirmation', $order->id)
                ->with('success', 'Order placed successfully! Your Order ID is #' . $order->id);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Failed to place order. Error: ' . $e->getMessage());
        }
    }

    // =============================================
    // VERIFY RAZORPAY PAYMENT
    // =============================================
    public function verifyPayment(Request $request)
    {
        if ((int) session('checkout_user_id') !== Auth::id()) {
            return redirect()->route('checkout')->with('error', 'Invalid checkout session. Please try again.');
        }

        $api = new \Razorpay\Api\Api(config('services.razorpay.key_id'), config('services.razorpay.key_secret'));

        $success = true;
        $error = "Payment Verification Failed";

        if (!empty($request->razorpay_payment_id)) {
            try {
                // Verify Signature
                $attributes = [
                    'razorpay_order_id' => session('razorpay_order_id'),
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ];

                $api->utility->verifyPaymentSignature($attributes);
            } catch (\Exception $e) {
                $success = false;
                $error = "Razorpay Error: " . $e->getMessage();
            }
        } else {
            $success = false;
        }

        if ($success === true) {
            // Place the order now that payment is verified
            $cartItems = $this->cartService->getUserCartItems(Auth::id());

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty! Cannot verify payment for an empty cart.');
            }

            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product->stock) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Product "' . $item->product->name . '" is out of stock or has limited quantity. Please update your cart.');
                }
            }

            try {
                $order = $this->createOrderFromCart($cartItems, [
                    'user_id' => Auth::id(),
                    'status' => 'pending', // You can set this to 'processing' or 'completed' if paid
                    'shipping_address' => session('shipping_address'),
                    'phone' => session('phone'),
                    'payment_method' => 'online',
                ]);
                session()->forget(['razorpay_order_id', 'shipping_address', 'phone', 'checkout_user_id']);

                return redirect()->route('orders.confirmation', $order->id)
                    ->with('success', 'Payment successful! Order placed.');
            } catch (\Exception $e) {
                return redirect()->route('checkout')->with('error', 'Payment verified but order creation failed: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('checkout')->with('error', $error);
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
    // DOWNLOAD INVOICE
    // =============================================
    public function downloadInvoice($id)
    {
        $order = Order::with('orderItems.product')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
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
        // Step 1: Find order - must belong to current user
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
            $this->inventoryService->restoreStockForOrderItems($order->orderItems);

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

    private function createOrderFromCart(Collection $cartItems, array $orderData): Order
    {
        return DB::transaction(function () use ($cartItems, $orderData) {
            $orderData['total_amount'] = $this->cartService->calculateTotal($cartItems);
            $order = Order::create($orderData);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }

            $this->inventoryService->deductStockForCartItems($cartItems);
            $this->cartService->clearUserCart((int) $orderData['user_id']);

            return $order;
        });
    }
}

