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
                return redirect()->route('home')->with('success', 'Welcome back, ' . $user->name . '!');
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

    // =============================================
    // FORGOT PASSWORD — Step 1: Show Email Form
    // =============================================
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // =============================================
    // FORGOT PASSWORD — Step 2: Verify Email Exists
    // =============================================
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        // Check if user with this email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address. Please check and try again.'
            ])->withInput();
        }

        // Store email in session for the reset step (secure, no token needed for localhost)
        $request->session()->put('reset_email', $request->email);

        return redirect()->route('password.reset')->with('success', 'Email verified! Please set your new password.');
    }

    // =============================================
    // FORGOT PASSWORD — Step 3: Show Reset Form
    // =============================================
    public function showResetForm(Request $request)
    {
        // Security: User must have verified their email first
        if (!$request->session()->has('reset_email')) {
            return redirect()->route('password.forgot')
                ->with('error', 'Please verify your email address first.');
        }

        $email = $request->session()->get('reset_email');

        return view('auth.reset-password', compact('email'));
    }

    // =============================================
    // FORGOT PASSWORD — Step 4: Update Password
    // =============================================
    public function resetPassword(Request $request)
    {
        // Security: User must have verified their email first
        if (!$request->session()->has('reset_email')) {
            return redirect()->route('password.forgot')
                ->with('error', 'Session expired. Please verify your email again.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Please enter a new password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Passwords do not match. Please try again.',
        ]);

        $email = $request->session()->get('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.forgot')
                ->with('error', 'Something went wrong. Please try again.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear the session data
        $request->session()->forget('reset_email');

        return redirect()->route('login')
            ->with('success', 'Password reset successful! You can now login with your new password.');
    }
}
