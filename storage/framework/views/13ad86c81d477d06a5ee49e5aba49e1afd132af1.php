<?php $__env->startSection('title', 'My Orders - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-box text-primary"></i> My Orders</h2>
            <p class="text-muted mb-0">View and track all your orders</p>
        </div>
        <div>
            <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Shop More
            </a>
        </div>
    </div>

    <?php if($orders->isEmpty()): ?>
        <!-- Empty State -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h4 class="mb-3">No orders yet</h4>
                <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Start Shopping
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Orders List -->
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card mb-3">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-secondary px-3 py-2">Order #<?php echo e($order->id); ?></span>
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
                            <?php if($order->payment_method == 'online'): ?>
                                <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> COD</span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> <?php echo e($order->created_at->format('d M Y, h:i A')); ?>

                        </small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="fw-bold mb-2"><i class="fas fa-shopping-bag text-primary"></i> Items Ordered:</h6>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        <?php echo e($item->product->name ?? 'Deleted Product'); ?> 
                                        × <?php echo e($item->quantity); ?>

                                        — ₹<?php echo e(number_format($item->price * $item->quantity, 2)); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="d-flex gap-4 text-muted small">
                                <span><i class="fas fa-map-marker-alt"></i> <?php echo e(Str::limit($order->shipping_address, 50)); ?></span>
                                <span><i class="fas fa-phone"></i> <?php echo e($order->phone); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <h4 class="text-success fw-bold mb-3">₹<?php echo e(number_format($order->total_amount, 2)); ?></h4>
                            <div class="d-flex gap-2 justify-content-md-end">
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <?php if($order->status == 'pending'): ?>
                                    <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST"
                                          onsubmit="return confirm('Are you sure you want to cancel Order #<?php echo e($order->id); ?>?\n\nThis action cannot be undone.');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Pagination -->
        <?php if($orders->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($orders->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/orders/index.blade.php ENDPATH**/ ?>