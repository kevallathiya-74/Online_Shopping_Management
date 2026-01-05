@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="min-height: calc(100vh - 250px); display: flex; align-items: center;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg" style="border-radius: 20px; border: none; overflow: hidden;">
                <!-- Card Header -->
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); border: none;">
                    <i class="fas fa-sign-in-alt fa-3x mb-3"></i>
                    <h3 class="fw-bold mb-0">Welcome Back</h3>
                    <p class="mb-0 mt-2">Login to your account</p>
                </div>
                
                <!-- Card Body -->
                <div class="card-body p-5">
                    <!-- Info Message -->
                    <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #3b82f6;">
                        <i class="fas fa-info-circle"></i> 
                        <small>
                            <strong>Single Login for All Users</strong><br>
                            Admins and users login here - you'll be redirected based on your role
                        </small>
                    </div>

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger" style="border-radius: 10px; border-left: 4px solid #ef4444;">
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
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope"></i> Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="your@email.com" 
                                   style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;" 
                                   required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Enter your password" 
                                   style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mb-3" 
                                style="border-radius: 10px; padding: 14px; font-weight: 600;">
                            <i class="fas fa-sign-in-alt"></i> Login to Account
                        </button>
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
            
            <!-- Test Credentials -->
            <div class="card mt-3" style="border-radius: 15px; border: 2px dashed #e5e7eb;">
                <div class="card-body p-3">
                    <small class="text-muted">
                        <strong><i class="fas fa-key"></i> Test Credentials:</strong><br>
                        <strong>Admin:</strong> admin@admin.com / admin123<br>
                        <strong>User:</strong> Register a new account
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
