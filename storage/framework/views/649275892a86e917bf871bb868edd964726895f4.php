

<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-users-cog"></i> User Management</h2>
            <p>View and manage all registered users, change roles, and control access</p>
        </div>
    </div>
</div>

<!-- User Statistics -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Total Users</h6>
                <h3 class="fw-bold text-primary"><?php echo e($users->total()); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Admins</h6>
                <h3 class="fw-bold text-danger"><?php echo e($users->where('role', 'admin')->count()); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Regular Users</h6>
                <h3 class="fw-bold text-success"><?php echo e($users->where('role', 'user')->count()); ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> All Users</h5>
            <span class="badge bg-primary"><?php echo e($users->total()); ?> Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if($users->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No users found</h5>
            </div>
        <?php else: ?>
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
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($user->id === Auth::id() ? 'table-info' : ''); ?>">
                                <td><span class="badge bg-secondary"><?php echo e($user->id); ?></span></td>
                                <td>
                                    <strong><?php echo e($user->name); ?></strong>
                                    <?php if($user->id === Auth::id()): ?>
                                        <span class="badge bg-info ms-1">You</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($user->email); ?></td>
                                <td class="text-center">
                                    <?php if($user->role === 'admin'): ?>
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-shield-alt"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-user"></i> User
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($user->id === Auth::id()): ?>
                                        <span class="text-muted fst-italic" title="You cannot change your own role">
                                            <i class="fas fa-lock"></i> Protected
                                        </span>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('admin.users.role', $user->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <select name="role" 
                                                    class="form-select form-select-sm" 
                                                    style="width: 130px; display: inline-block;"
                                                    onchange="if(confirm('Change <?php echo e($user->name); ?>\'s role to ' + this.value + '?')) this.form.submit(); else this.value='<?php echo e($user->role); ?>';">
                                                <option value="user" <?php echo e($user->role === 'user' ? 'selected' : ''); ?>>👤 User</option>
                                                <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>🛡️ Admin</option>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-day"></i> <?php echo e($user->created_at->format('d M Y')); ?>

                                    </small>
                                </td>
                                <td class="text-center">
                                    <?php if($user->id === Auth::id()): ?>
                                        <span class="text-muted" title="You cannot delete your own account">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('admin.users.delete', $user->id)); ?>" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete user: <?php echo e($user->name); ?>? This action cannot be undone.')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if($users->isNotEmpty() && $users->hasPages()): ?>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <span class="text-muted">
                    Showing <strong><?php echo e($users->firstItem()); ?></strong> to <strong><?php echo e($users->lastItem()); ?></strong> of <strong><?php echo e($users->total()); ?></strong> users
                </span>
                <div>
                    <?php echo e($users->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Important Notes -->
<div class="card mt-4">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle"></i> Important Notes</h5>
    </div>
    <div class="card-body">
        <ul class="mb-0">
            <li class="mb-2"><strong>Role Change:</strong> Select a new role from the dropdown to immediately change a user's role. Admin role grants full access to this admin panel.</li>
            <li class="mb-2"><strong>Self Protection:</strong> You cannot change your own role or delete your own account for security reasons.</li>
            <li class="mb-2"><strong>Delete User:</strong> Users with existing orders cannot be deleted. You must handle their orders first.</li>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/admin/users/index.blade.php ENDPATH**/ ?>