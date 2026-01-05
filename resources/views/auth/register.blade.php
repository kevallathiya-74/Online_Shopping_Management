@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container" style="min-height: calc(100vh - 250px); display: flex; align-items: center; padding: 40px 0;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg" style="border-radius: 20px; border: none; overflow: hidden;">
                <!-- Card Header -->
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); border: none;">
                    <i class="fas fa-user-plus fa-3x mb-3"></i>
                    <h3 class="fw-bold mb-0">Create Account</h3>
                    <p class="mb-0 mt-2">Join us and start shopping today!</p>
                </div>
                
                <!-- Card Body -->
                <div class="card-body p-5">
                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger" style="border-radius: 10px; border-left: 4px solid #ef4444;">
                            <i class="fas fa-exclamation-circle"></i> <strong>Please fix the following:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Registration Form -->
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-user"></i> Full Name
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Enter your full name" 
                                   style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;" 
                                   required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope"></i> Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="your@email.com" 
                                   style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone (Optional) -->
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">
                                <i class="fas fa-phone"></i> Phone Number <span class="text-muted">(Optional)</span>
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                   placeholder="e.g., 9876543210" 
                                   style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address (Optional) -->
                        <div class="mb-4">
                            <label for="address" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt"></i> Address <span class="text-muted">(Optional)</span>
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2" 
                                      placeholder="Your delivery address" 
                                      style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;">{{ old('address') }}</textarea>
                            @error('address')
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
                                   placeholder="Minimum 8 characters" 
                                   style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Use at least 8 characters
                            </small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">
                                <i class="fas fa-lock"></i> Confirm Password
                            </label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Re-enter your password" 
                                   style="border-radius: 10px; padding: 12px 20px; border: 2px solid #e5e7eb;" 
                                   required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mb-3" 
                                style="border-radius: 10px; padding: 14px; font-weight: 600;">
                            <i class="fas fa-user-plus"></i> Create Account
                        </button>
                    </form>

                    <hr style="margin: 25px 0;">
                    
                    <!-- Login Link -->
                    <p class="text-center mb-0">
                        Already have an account? 
                        <a href="{{ route('login') }}" style="color: #4f46e5; font-weight: 600; text-decoration: none;">
                            <i class="fas fa-sign-in-alt"></i> Login Here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
