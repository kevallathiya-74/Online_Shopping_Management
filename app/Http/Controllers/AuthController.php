<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show Registration Form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'user', // Default role is user
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle Login (Role-Based Redirect)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt authentication
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            // Check user role and redirect accordingly
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials. Please check your email and password.'])->withInput();
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Destroy session completely — prevents browser back button issue
        $request->session()->invalidate();

        // Generate new CSRF token for security
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
