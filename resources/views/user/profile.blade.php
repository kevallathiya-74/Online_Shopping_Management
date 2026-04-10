@extends('layouts.app')

@section('title', 'My Profile - ShopEasy')

@section('content')
<div class="container">
    <x-page-header
        title="My Profile"
        subtitle="Manage your account details, delivery contact information, and password securely."
        icon="fas fa-user-circle">
        <x-slot name="actions">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
            </a>
        </x-slot>
    </x-page-header>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="section-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-pen text-primary me-2"></i>Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any() && !$errors->has('current_password') && !$errors->has('new_password'))
                    <div class="alert alert-danger">
                        <i class="fas fa-circle-exclamation me-1"></i>
                        <ul class="mb-0 mt-2">
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

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" autocomplete="name" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="9876543210" autocomplete="tel">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" rows="2" placeholder="Street, city, state" autocomplete="street-address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="fas fa-save me-1"></i>Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="section-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-circle-info text-info me-2"></i>Account Information</h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless meta-table">
                        <tr>
                            <td class="text-muted fw-semibold meta-label-col">Name</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Email</td>
                            <td class="text-wrap-anywhere">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Phone</td>
                            <td>{{ $user->phone ?? 'Not provided' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">Joined</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="section-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-key text-warning me-2"></i>Change Password</h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->has('current_password') || $errors->has('new_password'))
                    <div class="alert alert-danger">
                        <i class="fas fa-circle-exclamation me-1"></i>
                        <ul class="mb-0 mt-2">
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
                            <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" required>
                            @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password" name="new_password" placeholder="Minimum 8 characters" required>
                            @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control"
                                id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-lock me-1"></i>Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
