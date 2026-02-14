<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;

class UserController extends Controller
{
    // =============================================
    // USER DASHBOARD
    // =============================================
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get user's order statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Get recent orders (last 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->latest()
            ->take(5)
            ->get();

        // Wishlist Count
        $wishlistCount = \App\Models\Wishlist::where('user_id', $user->id)->count();

        return view('user.dashboard', compact(
            'user',
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'completedOrders',
            'recentOrders',
            'wishlistCount'
        ));
    }

    // =============================================
    // PROFILE MANAGEMENT
    // =============================================

    // Show Profile Page
    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Update Profile (Name, Email, Phone, Address)
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validate input - email must be unique except for current user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully!');
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        // Prevent setting same password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'New password must be different from current password.']);
        }

        // Update password (auto-hashed via User model cast)
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.profile')
            ->with('success', 'Password changed successfully!');
    }
}
