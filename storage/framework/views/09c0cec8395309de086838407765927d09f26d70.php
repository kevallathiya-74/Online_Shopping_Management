

<?php $__env->startSection('title', 'My Dashboard - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Welcome Header -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border: none;">
        <div class="card-body text-white py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="fas fa-hand-wave"></i> Welcome back, <?php echo e($user->name); ?>!
                    </h2>
                    <p class="mb-0 opacity-75">Here's your shopping summary and recent activity.</p>
                </div>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-light btn-sm mt-2 mt-md-0">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-2">
                        <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-primary mb-1"><?php echo e($totalOrders); ?></h3>
                    <p class="text-muted mb-0 small">Total Orders</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-2">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-1">₹<?php echo e(number_format($totalSpent, 0)); ?></h3>
                    <p class="text-muted mb-0 small">Total Spent</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-2">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                    <h3 class="fw-bold text-warning mb-1"><?php echo e($pendingOrders); ?></h3>
                    <p class="text-muted mb-0 small">Pending Orders</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body text-center py-4">
                    <div class="mb-2">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-1"><?php echo e($completedOrders); ?></h3>
                    <p class="text-muted mb-0 small">Completed Orders</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-bolt text-warning"></i> Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Browse Products
                </a>
                <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-success">
                    <i class="fas fa-shopping-cart"></i> View Cart
                </a>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-info text-white">
                    <i class="fas fa-box"></i> Order History
                </a>
                <a href="<?php echo e(route('user.profile')); ?>" class="btn btn-warning">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-clock text-primary"></i> Recent Orders</h5>
                <?php if($recentOrders->isNotEmpty()): ?>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if($recentOrders->isEmpty()): ?>
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No orders yet</h5>
                    <p class="text-muted mb-3">Start shopping to see your orders here!</p>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><span class="badge bg-secondary">#<?php echo e($order->id); ?></span></td>
                                    <td><span class="badge bg-info"><?php echo e($order->orderItems->count()); ?> item(s)</span></td>
                                    <td><strong class="text-success">₹<?php echo e(number_format($order->total_amount, 2)); ?></strong></td>
                                    <td>
                                        <?php if($order->payment_method == 'online'): ?>
                                            <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> COD</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-status-<?php echo e($order->status); ?> px-2 py-1">
                                            <?php if($order->status == 'completed'): ?>
                                                <i class="fas fa-check-circle"></i>
                                            <?php elseif($order->status == 'cancelled'): ?>
                                                <i class="fas fa-times-circle"></i>
                                            <?php elseif($order->status == 'processing'): ?>
                                                <i class="fas fa-spinner"></i>
                                            <?php else: ?>
                                                <i class="fas fa-clock"></i>
                                            <?php endif; ?>
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td><small class="text-muted"><?php echo e($order->created_at->format('d M Y')); ?></small></td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <?php if($order->status == 'pending'): ?>
                                                <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST"
                                                      onsubmit="return confirm('Cancel Order #<?php echo e($order->id); ?>?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel Order">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/user/dashboard.blade.php ENDPATH**/ ?>