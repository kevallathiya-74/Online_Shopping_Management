<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        $userStats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
        ];

        return view('admin.users.index', compact('users', 'userStats'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot change your own role. Another admin must do this.');
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'User "' . $user->name . '" role changed to "' . ucfirst($request->role) . '" successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot delete your own account!');
        }

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
