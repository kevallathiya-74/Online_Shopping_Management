@extends('layouts.app')

@section('title', 'Reset Password - ShopEasy')

@section('content')
<div class="container" style="min-height: calc(100vh - 250px); display: flex; align-items: center;">
  <div class="row justify-content-center w-100">
    <div class="col-md-5 col-lg-4">
      <div class="card">
        <!-- Card Header -->
        <div class="card-header bg-success text-white text-center py-4">
          <i class="fas fa-lock-open fa-3x mb-3"></i>
          <h3 class="mb-0">Reset Password</h3>
          <p class="mb-0 mt-2">Create a new password for your account</p>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
          <!-- Step Indicator -->
          <div class="d-flex justify-content-center mb-4">
            <div class="text-center">
              <span class="badge bg-success rounded-circle" style="width: 30px; height: 30px; line-height: 22px; font-size: 0.85rem;"><i class="fas fa-check" style="font-size: 0.7rem;"></i></span>
              <br><small class="text-success fw-bold">Email Verified</small>
            </div>
            <div class="mx-3 pt-2"><i class="fas fa-arrow-right text-muted"></i></div>
            <div class="text-center">
              <span class="badge bg-primary rounded-circle" style="width: 30px; height: 30px; line-height: 22px; font-size: 0.85rem;">2</span>
              <br><small class="text-primary fw-bold">New Password</small>
            </div>
          </div>

          <!-- Account Info -->
          <div class="alert-info py-2 mb-3">
            <i class="fas fa-user-circle"></i> Resetting password for: <strong>{{ $email }}</strong>
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

          <!-- Reset Password Form -->
          <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <!-- New Password -->
            <div class="mb-3">
              <label for="password" class="form-label">
                <i class="fas fa-lock"></i> New Password
              </label>
              <input type="password" class="form-control @error('password') is-invalid @enderror"
                id="password" name="password"
                placeholder="Enter new password (min 8 characters)"
                required autofocus>
              @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock"></i> Confirm New Password
              </label>
              <input type="password" class="form-control"
                id="password_confirmation" name="password_confirmation"
                placeholder="Re-enter your new password"
                required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success w-100 mb-3 fw-bold"
              style="border-radius: 10px; padding: 14px;">
              <i class="fas fa-save"></i> Reset Password
            </button>
          </form>

          <hr style="margin: 25px 0;">

          <!-- Links -->
          <div class="text-center">
            <a href="{{ route('password.forgot') }}" class="text-decoration-none" style="color: #6c757d;">
              <i class="fas fa-arrow-left"></i> Use different email
            </a>
            <span class="mx-2 text-muted">|</span>
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #4f46e5; font-weight: 600;">
              <i class="fas fa-sign-in-alt"></i> Back to Login
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection