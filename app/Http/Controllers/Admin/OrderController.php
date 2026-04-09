<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderItems')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'orderItems.product.category')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = ucfirst($order->status);
        $order->status = $request->status;
        $order->save();

        $newStatus = ucfirst($request->status);

        return redirect()->back()->with('success', 'Order #' . $order->id . ' status changed from "' . $oldStatus . '" to "' . $newStatus . '".');
    }
}