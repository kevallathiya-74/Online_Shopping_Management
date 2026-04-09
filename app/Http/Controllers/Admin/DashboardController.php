<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'pendingOrders',
            'completedOrders'
        ));
    }
}