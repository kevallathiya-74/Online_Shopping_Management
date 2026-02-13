<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // =============================================
    // DASHBOARD
    // =============================================
    public function dashboard()
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

    // =============================================
    // CATEGORY MANAGEMENT
    // =============================================
    public function categories()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        // Prevent deletion if category has products
        if ($category->products_count > 0) {
            return redirect()->route('admin.categories')
                ->with('error', 'Cannot delete category "' . $category->name . '" because it has ' . $category->products_count . ' product(s). Please remove or reassign products first.');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }

    // =============================================
    // PRODUCT MANAGEMENT
    // =============================================
    public function products()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')
                ->with('error', 'Please create at least one category before adding products.');
        }

        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|url|max:500',
        ], [
            'price.min'       => 'Price must be a positive number greater than zero.',
            'category_id.exists' => 'Selected category does not exist.',
        ]);

        Product::create($request->only('category_id', 'name', 'description', 'price', 'stock', 'image'));

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|url|max:500',
        ], [
            'price.min'       => 'Price must be a positive number greater than zero.',
            'category_id.exists' => 'Selected category does not exist.',
        ]);

        $product->update($request->only('category_id', 'name', 'description', 'price', 'stock', 'image'));

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product "' . $product->name . '" deleted successfully!');
    }

    // =============================================
    // ORDER MANAGEMENT
    // =============================================
    public function orders()
    {
        $orders = Order::with('user', 'orderItems')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('user', 'orderItems.product.category')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
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

    // =============================================
    // USER MANAGEMENT
    // =============================================
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);

        // Prevent admin from changing their own role
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot change your own role. Another admin must do this.');
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'User "' . $user->name . '" role changed to "' . ucfirst($request->role) . '" successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot delete your own account!');
        }

        // Check if user has orders
        $orderCount = Order::where('user_id', $user->id)->count();
        if ($orderCount > 0) {
            return redirect()->route('admin.users')
                ->with('error', 'Cannot delete user "' . $user->name . '" because they have ' . $orderCount . ' order(s). Manage their orders first.');
        }

        $user->delete();
        return redirect()->route('admin.users')
            ->with('success', 'User "' . $user->name . '" deleted successfully!');
    }
}
