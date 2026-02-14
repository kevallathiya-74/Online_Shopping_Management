@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="min-height: calc(100vh - 250px); display: flex; align-items: center;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5 col-lg-4">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="fas fa-sign-in-alt fa-3x mb-3"></i>
                    <h3 class="mb-0">Welcome Back</h3>
                    <p class="mb-0 mt-2">Login to your account</p>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">

                    <!-- Error Messages -->
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}"
                                placeholder="your@email.com"
                                required autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-2">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password"
                                placeholder="Enter your password"
                                required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mb-3"
                            style="border-radius: 10px; padding: 14px; font-weight: 600;">
                            <i class="fas fa-sign-in-alt"></i> Login to Account
                        </button>
                        
                        <div class="text-end mb-3">
                            <a href="{{ route('password.forgot') }}" style="color: #6c757d; font-size: 0.85rem; text-decoration: none;">
                                <i class="fas fa-key"></i> Forgot Password?
                            </a>
                        </div>
                    </form>

                    <hr style="margin: 25px 0;">

                    <!-- Register Link -->
                    <p class="text-center mb-0">
                        Don't have an account?
                        <a href="{{ route('register') }}" style="color: #4f46e5; font-weight: 600; text-decoration: none;">
                            <i class="fas fa-user-plus"></i> Register Now
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection