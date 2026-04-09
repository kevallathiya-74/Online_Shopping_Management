@extends('layouts.app')

@section('title', 'Login')

@section('body_class', 'auth-body')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="auth-shell">
                    <div class="row g-0">
                        <div class="col-md-5 d-none d-md-block">
                            <div class="auth-hero">
                                <h2>Secure Sign In</h2>
                                <p>Access your orders, wishlist, saved addresses, and account settings from one clean dashboard.</p>
                                <ul>
                                    <li><i class="fas fa-check-circle"></i> Real-time order tracking</li>
                                    <li><i class="fas fa-check-circle"></i> Faster checkout with saved details</li>
                                    <li><i class="fas fa-check-circle"></i> Easy returns and invoice access</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="auth-form-panel">
                                <h3>Welcome Back</h3>
                                <p class="auth-note">Login to continue shopping with your existing account.</p>

                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <i class="fas fa-circle-exclamation me-1"></i>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-2">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Enter your password" required>
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-end mb-3">
                                        <a href="{{ route('password.forgot') }}" class="small text-muted">
                                            <i class="fas fa-key me-1"></i>Forgot Password?
                                        </a>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="fas fa-right-to-bracket me-1"></i>Login to Account
                                    </button>
                                </form>

                                <hr class="my-4">

                                <p class="text-center mb-0 small">
                                    New to ShopEasy?
                                    <a href="{{ route('register') }}" class="fw-bold ms-1">Create an account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection