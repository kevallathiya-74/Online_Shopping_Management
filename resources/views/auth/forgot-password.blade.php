@extends('layouts.app')

@section('title', 'Forgot Password - ShopEasy')

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
                <h2>Password Recovery</h2>
                <p>Forgot your password? Verify your email and set a new one in the next step.</p>
                <ul>
                  <li><i class="fas fa-check-circle"></i> Quick two-step process</li>
                  <li><i class="fas fa-check-circle"></i> Secure account verification</li>
                  <li><i class="fas fa-check-circle"></i> Works in less than a minute</li>
                </ul>
              </div>
            </div>

            <div class="col-md-7">
              <div class="auth-form-panel">
                <h3>Forgot Password</h3>
                <p class="auth-note">
                  <span class="auth-step active">1</span>Verify email
                  <span class="auth-step active">2</span>Set new password
                </p>

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

                <form action="{{ route('password.verify') }}" method="POST">
                  @csrf

                  <div class="mb-3">
                    <label for="email" class="form-label">Registered Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                      id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block mt-2">Use the same email linked to your account.</small>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="fas fa-arrow-right me-1"></i>Verify Email & Continue
                  </button>
                </form>

                <hr class="my-4">
                <p class="text-center mb-0 small">
                  Remembered your password?
                  <a href="{{ route('login') }}" class="fw-bold ms-1">Back to login</a>
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