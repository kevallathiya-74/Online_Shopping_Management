@extends('layouts.app')

@section('title', 'Reset Password - ShopEasy')

@section('body_class', 'auth-body')

@section('content')
<div class="auth-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-xl-8">
        <div class="auth-shell">
          <div class="row g-0">
            <div class="col-md-5 d-none d-md-block">
              <div class="auth-hero">
                <h2>Set New Password</h2>
                <p>Your email is verified. Create a strong password to secure your account.</p>
                <ul>
                  <li><i class="fas fa-check-circle"></i> Minimum 8 characters</li>
                  <li><i class="fas fa-check-circle"></i> Keep it unique and private</li>
                  <li><i class="fas fa-check-circle"></i> Instant access after reset</li>
                </ul>
              </div>
            </div>

            <div class="col-md-7">
              <div class="auth-form-panel">
                <h3>Reset Password</h3>
                <p class="auth-note">
                  <span class="auth-step done"><i class="fas fa-check"></i></span>Email verified
                  <span class="auth-step active">2</span>Set new password
                </p>

                <div class="alert alert-info py-2">
                  <i class="fas fa-user-circle me-1"></i> Resetting password for: <strong>{{ $email }}</strong>
                </div>

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

                <form action="{{ route('password.update') }}" method="POST">
                  @csrf

                  <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                      id="password" name="password" placeholder="Minimum 8 characters" autocomplete="new-password" required autofocus>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control"
                      id="password_confirmation" name="password_confirmation" placeholder="Re-enter your new password" autocomplete="new-password" required>
                  </div>

                  <button type="submit" class="btn btn-success w-100 py-2">
                    <i class="fas fa-key me-1"></i>Reset Password
                  </button>
                </form>

                <hr class="my-4">

                <div class="text-center small">
                  <a href="{{ route('password.forgot') }}" class="text-muted">Use a different email</a>
                  <span class="mx-2 text-muted">|</span>
                  <a href="{{ route('login') }}" class="fw-bold">Back to Login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
