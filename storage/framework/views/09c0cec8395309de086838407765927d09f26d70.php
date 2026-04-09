

<?php $__env->startSection('title', 'My Dashboard - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="section-card hero-banner mb-4">
        <div class="card-body p-4 p-lg-5">
            <span class="hero-highlight mb-2"><i class="fas fa-user-check"></i>Account Overview</span>
            <h2 class="hero-title">Welcome back, <?php echo e($user->name); ?></h2>
            <p class="hero-subtitle">Track order activity, account details, and saved products from one dashboard.</p>
            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="<?php echo e(route('home')); ?>" class="btn btn-light"><i class="fas fa-bag-shopping me-1"></i>Continue Shopping</a>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-light"><i class="fas fa-box-open me-1"></i>My Orders</a>
            </div>
        </div>
    </div>

    <div class="stats-grid mb-4">
        <div class="metric-card">
            <div class="metric-label">Total Orders</div>
            <div class="metric-value"><?php echo e($totalOrders); ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Spent</div>
            <div class="metric-value">₹<?php echo e(number_format($totalSpent, 0)); ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pending Orders</div>
            <div class="metric-value"><?php echo e($pendingOrders); ?></div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Completed Orders</div>
            <div class="metric-value"><?php echo e($completedOrders); ?></div>
        </div>
    </div>

    <div class="section-card mb-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold"><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
        </div>
        <div class="card-body d-flex flex-wrap gap-2">
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary"><i class="fas fa-store me-1"></i>Browse Products</a>
            <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-success"><i class="fas fa-cart-shopping me-1"></i>View Cart</a>
            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-primary"><i class="fas fa-clock-rotate-left me-1"></i>Order History</a>
            <a href="<?php echo e(route('user.profile')); ?>" class="btn btn-outline-secondary"><i class="fas fa-user-pen me-1"></i>Edit Profile</a>
            <a href="<?php echo e(route('wishlist.index')); ?>" class="btn btn-outline-danger"><i class="fas fa-heart me-1"></i>Wishlist <span class="badge bg-danger ms-1"><?php echo e($wishlistCount); ?></span></a>
        </div>
    </div>

    <div class="section-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2 text-primary"></i>Recent Orders</h5>
            <?php if($recentOrders->isNotEmpty()): ?>
            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php if($recentOrders->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                <h5 class="fw-bold">No orders yet</h5>
                <p class="text-muted mb-3">Start shopping to see your recent orders here.</p>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-primary"><i class="fas fa-bag-shopping me-1"></i>Start Shopping</a>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
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
                            <td><span class="badge bg-dark-subtle text-dark border">#<?php echo e($order->id); ?></span></td>
                            <td><span class="badge bg-light text-dark border"><?php echo e($order->orderItems->count()); ?> item(s)</span></td>
                            <td class="fw-bold text-success">₹<?php echo e(number_format($order->total_amount, 2)); ?></td>
                            <td>
                                <?php if($order->payment_method == 'online'): ?>
                                <span class="badge bg-primary">Online</span>
                                <?php else: ?>
                                <span class="badge bg-secondary">COD</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge badge-status-<?php echo e($order->status); ?>"><?php echo e(ucfirst($order->status)); ?></span></td>
                            <td><small class="text-muted"><?php echo e($order->created_at->format('d M Y')); ?></small></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                    <?php if($order->status == 'pending'): ?>
                                    <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST" onsubmit="return confirm('Cancel Order #<?php echo e($order->id); ?>?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
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