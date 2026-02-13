@extends('layouts.app')

@section('title', 'My Profile - ShopEasy')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-user-circle text-primary"></i> My Profile</h2>
            <p class="text-muted mb-0">Manage your account information and password</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-edit text-primary"></i> Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Validation Errors for Profile -->
                    @if($errors->any() && !$errors->has('current_password') && !$errors->has('new_password'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <strong>Please fix the following:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $error)
                                    @if(!str_contains($error, 'password'))
                                        <li>{{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-user"></i> Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       placeholder="Enter your full name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       placeholder="your@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">
                                <i class="fas fa-phone"></i> Phone Number
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="e.g., 9876543210">
                            @error('phone')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt"></i> Address
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3" 
                                      placeholder="Enter your delivery address">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-5">
            <!-- Account Info Card -->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle text-info"></i> Account Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold text-muted" style="width: 130px;">
                                <i class="fas fa-user"></i> Name:
                            </td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-envelope"></i> Email:
                            </td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-phone"></i> Phone:
                            </td>
                            <td>{{ $user->phone ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-shield-alt"></i> Role:
                            </td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-success' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-calendar"></i> Joined:
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-lock text-warning"></i> Change Password</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Password Errors -->
                    @if($errors->has('current_password') || $errors->has('new_password'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <strong>Password Error:</strong>
                            <ul class="mb-0 mt-1">
                                @error('current_password')
                                    <li>{{ $message }}</li>
                                @enderror
                                @error('new_password')
                                    <li>{{ $message }}</li>
                                @enderror
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.password.change') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">
                                <i class="fas fa-key"></i> Current Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   placeholder="Enter current password"
                                   required>
                            @error('current_password')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">
                                <i class="fas fa-lock"></i> New Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" 
                                   name="new_password" 
                                   placeholder="Minimum 8 characters"
                                   required>
                            @error('new_password')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-bold">
                                <i class="fas fa-lock"></i> Confirm New Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation" 
                                   placeholder="Re-enter new password"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
