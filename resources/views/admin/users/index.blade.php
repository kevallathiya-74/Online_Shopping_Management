@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<x-page-header
    title="User Management"
    subtitle="Manage account roles and maintain secure platform access control."
    icon="fas fa-users-cog"
    badge="{{ $userStats['total'] }} Users" />

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="section-card h-100">
            <div class="card-body text-center p-4">
                <div class="small text-muted mb-1">Total Users</div>
                <div class="h3 fw-bold text-primary mb-0">{{ $userStats['total'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="section-card h-100">
            <div class="card-body text-center p-4">
                <div class="small text-muted mb-1">Admins</div>
                <div class="h3 fw-bold text-danger mb-0">{{ $userStats['admins'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="section-card h-100">
            <div class="card-body text-center p-4">
                <div class="small text-muted mb-1">Regular Users</div>
                <div class="h3 fw-bold text-success mb-0">{{ $userStats['users'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="section-card admin-table">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>All Users</h5>
        <span class="badge bg-primary">{{ $users->total() }} Total</span>
    </div>

    <div class="card-body p-0">
        @if($users->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-users"></i></div>
            <h5 class="fw-bold">No users found</h5>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Current Role</th>
                        <th class="text-center">Change Role</th>
                        <th>Registered</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="{{ $user->id === Auth::id() ? 'table-info' : '' }}">
                        <td><span class="badge bg-dark-subtle text-dark border">{{ $user->id }}</span></td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if($user->id === Auth::id())
                            <span class="badge bg-info ms-1">You</span>
                            @endif
                        </td>
                        <td class="text-wrap-anywhere">{{ $user->email }}</td>
                        <td class="text-center">
                            @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                            @else
                            <span class="badge bg-success">User</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->id === Auth::id())
                            <span class="text-muted fst-italic"><i class="fas fa-lock me-1"></i>Protected</span>
                            @else
                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="role" class="form-select form-select-sm select-compact"
                                    onchange="if(confirm('Change {{ $user->name }}\'s role to ' + this.value + '?')) this.form.submit(); else this.value='{{ $user->role }}';">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $user->created_at->format('d M Y') }}</small></td>
                        <td class="text-center">
                            @if($user->id === Auth::id())
                            <span class="text-muted"><i class="fas fa-lock"></i></span>
                            @else
                            <div class="table-actions justify-center">
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete user: {{ $user->name }}? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    @if($users->isNotEmpty() && $users->hasPages())
    <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted">
            Showing <strong>{{ $users->firstItem() }}</strong> to <strong>{{ $users->lastItem() }}</strong> of <strong>{{ $users->total() }}</strong> users
        </span>
        <div>{{ $users->links('pagination::bootstrap-5') }}</div>
    </div>
    @endif
</div>
@endsection
