@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-users-cog"></i> User Management</h2>
            <p>View and manage all registered users, change roles and control access</p>
        </div>
    </div>
</div>

<!-- User Statistics -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Total Users</h6>
                <h3 class="fw-bold text-primary">{{ $users->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Admins</h6>
                <h3 class="fw-bold text-danger">{{ $users->where('role', 'admin')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Regular Users</h6>
                <h3 class="fw-bold text-success">{{ $users->where('role', 'user')->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> All Users</h5>
            <span class="badge bg-primary">{{ $users->total() }} Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        @if($users->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No users found</h5>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th class="text-center">Current Role</th>
                            <th class="text-center">Change Role</th>
                            <th>Registered</th>
                            <th class="text-center" style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="{{ $user->id === Auth::id() ? 'table-info' : '' }}">
                                <td><span class="badge bg-secondary">{{ $user->id }}</span></td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === Auth::id())
                                        <span class="badge bg-info ms-1">You</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-shield-alt"></i> Admin
                                        </span>
                                    @else
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-user"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($user->id === Auth::id())
                                        <span class="text-muted fst-italic" title="You cannot change your own role">
                                            <i class="fas fa-lock"></i> Protected
                                        </span>
                                    @else
                                        <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" 
                                                    class="form-select form-select-sm" 
                                                    style="width: 130px; display: inline-block;"
                                                    onchange="if(confirm('Change {{ $user->name }}\'s role to ' + this.value + '?')) this.form.submit(); else this.value='{{ $user->role }}';">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>👤 User</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-day"></i> {{ $user->created_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    @if($user->id === Auth::id())
                                        <span class="text-muted" title="You cannot delete your own account">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    @else
                                        <form action="{{ route('admin.users.delete', $user->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete user: {{ $user->name }}? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Pagination --}}
    @if($users->isNotEmpty() && $users->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <span class="text-muted">
                    Showing <strong>{{ $users->firstItem() }}</strong> to <strong>{{ $users->lastItem() }}</strong> of <strong>{{ $users->total() }}</strong> users
                </span>
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
