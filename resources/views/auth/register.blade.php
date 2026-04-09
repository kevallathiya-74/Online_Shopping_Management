@extends('layouts.app')

@section('title', 'Register')

@section('body_class', 'auth-body')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                <div class="auth-shell">
                    <div class="row g-0">
                        <div class="col-md-5 d-none d-md-block">
                            <div class="auth-hero">
                                <h2>Create Your Account</h2>
                                <p>Join ShopEasy to save products, track orders and checkout faster every time.</p>
                                <ul>
                                    <li><i class="fas fa-check-circle"></i> One dashboard for all orders</li>
                                    <li><i class="fas fa-check-circle"></i> Wishlist and quick reorder support</li>
                                    <li><i class="fas fa-check-circle"></i> Secure profile and password management</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="auth-form-panel">
                                <h3>Create Account</h3>
                                <p class="auth-note">Use your real details for smooth checkout and delivery communication.</p>

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

                                <form action="{{ route('register') }}" method="POST">
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name') }}" placeholder="Arjun Mehta" required autofocus>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number <span class="text-muted fw-normal">(Optional)</span></label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" value="{{ old('phone') }}" placeholder="9876543210">
                                            @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="address" class="form-label">Address <span class="text-muted fw-normal">(Optional)</span></label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                id="address" name="address" rows="1" placeholder="Street, city, state">{{ old('address') }}</textarea>
                                            @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Minimum 8 characters" required>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control"
                                                id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-2 mt-4">
                                        <i class="fas fa-user-plus me-1"></i>Create Account
                                    </button>
                                </form>

                                <hr class="my-4">

                                <p class="text-center mb-0 small">
                                    Already registered?
                                    <a href="{{ route('login') }}" class="fw-bold ms-1">Login here</a>
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
