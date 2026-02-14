@extends('layouts.app')

@section('title', 'Forgot Password - ShopEasy')

@section('content')
<div class="container" style="min-height: calc(100vh - 250px); display: flex; align-items: center;">
  <div class="row justify-content-center w-100">
    <div class="col-md-5 col-lg-4">
      <div class="card">
        <!-- Card Header -->
        <div class="card-header bg-warning text-dark text-center py-4">
          <i class="fas fa-key fa-3x mb-3"></i>
          <h3 class="mb-0">Forgot Password?</h3>
          <p class="mb-0 mt-2">Enter your email to reset your password</p>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
          <!-- Step Indicator -->
          <div class="d-flex justify-content-center mb-4">
            <div class="text-center">
              <span class="badge bg-primary rounded-circle" style="width: 30px; height: 30px; line-height: 22px; font-size: 0.85rem;">1</span>
              <br><small class="text-primary fw-bold">Enter Email</small>
            </div>
            <div class="mx-3 pt-2"><i class="fas fa-arrow-right text-muted"></i></div>
            <div class="text-center">
              <span class="badge bg-secondary rounded-circle" style="width: 30px; height: 30px; line-height: 22px; font-size: 0.85rem;">2</span>
              <br><small class="text-muted">New Password</small>
            </div>
          </div>

          <!-- Error Messages -->
          @if($errors->any())
          <div class="alert alert-danger py-2">
            <i class="fas fa-exclamation-circle"></i>
            <ul class="mb-0 mt-1">
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <!-- Forgot Password Form -->
          <form action="{{ route('password.verify') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Email Address
              </label>
              <input type="email" class="form-control @error('email') is-invalid @enderror"
                id="email" name="email" value="{{ old('email') }}"
                placeholder="Enter your registered email"
                required autofocus>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="text-muted mt-1 d-block">
                <i class="fas fa-info-circle"></i> We'll check if this email is registered in our system.
              </small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-warning w-100 mb-3 text-dark fw-bold"
              style="border-radius: 10px; padding: 14px;">
              <i class="fas fa-search"></i> Verify Email & Continue
            </button>
          </form>

          <hr style="margin: 25px 0;">

          <!-- Back to Login Link -->
          <p class="text-center mb-0">
            Remember your password?
            <a href="{{ route('login') }}" style="color: #4f46e5; font-weight: 600; text-decoration: none;">
              <i class="fas fa-sign-in-alt"></i> Back to Login
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection