

<?php $__env->startSection('title', 'My Orders - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="section-header mb-4">
        <div>
            <h2 class="section-title mb-1"><i class="fas fa-box-open text-primary me-2"></i>My Orders</h2>
            <p class="section-subtitle">Track order status, amounts, and delivery details from one place.</p>
        </div>
        <div class="d-flex flex-wrap gap-2 justify-content-start justify-content-md-end">
            <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Dashboard
            </a>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">
                <i class="fas fa-bag-shopping me-1"></i>Shop More
            </a>
        </div>
    </div>

    <?php if($orders->isEmpty()): ?>
    <div class="section-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
            <h4 class="mb-2 fw-bold">No orders yet</h4>
            <p class="text-muted mb-4">Your placed orders will appear here with live status updates.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary btn-lg"><i class="fas fa-bag-shopping me-1"></i>Start Shopping</a>
        </div>
    </div>
    <?php else: ?>
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="section-card mb-3">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-dark-subtle text-dark border">Order #<?php echo e($order->id); ?></span>
                    <span class="badge badge-status-<?php echo e($order->status); ?>">
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
                    <span class="badge bg-primary"><i class="fas fa-credit-card me-1"></i>Online</span>
                    <?php else: ?>
                    <span class="badge bg-secondary"><i class="fas fa-money-bill-wave me-1"></i>COD</span>
                    <?php endif; ?>
                </div>
                <small class="text-muted"><i class="fas fa-calendar me-1"></i><?php echo e($order->created_at->format('d M Y, h:i A')); ?></small>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <h6 class="fw-bold mb-2">Items</h6>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-light text-dark border text-wrap-anywhere">
                            <?php echo e($item->product->name ?? 'Deleted Product'); ?> x <?php echo e($item->quantity); ?>

                        </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="small text-muted d-flex flex-wrap gap-3">
                        <span class="text-wrap-anywhere"><i class="fas fa-location-dot me-1"></i><?php echo e(Str::limit($order->shipping_address, 58)); ?></span>
                        <span><i class="fas fa-phone me-1"></i><?php echo e($order->phone); ?></span>
                    </div>
                </div>

                <div class="col-md-4 text-md-end">
                    <div class="h4 text-success fw-bold mb-3">₹<?php echo e(number_format($order->total_amount, 2)); ?></div>
                    <div class="d-flex gap-2 justify-content-md-end flex-wrap">
                        <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Details
                        </a>
                        <a href="<?php echo e(route('orders.invoice', $order->id)); ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-file-invoice me-1"></i>Invoice
                        </a>
                        <?php if($order->status == 'pending'): ?>
                        <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel Order #<?php echo e($order->id); ?>? This action cannot be undone.');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-xmark me-1"></i>Cancel
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($orders->hasPages()): ?>
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($orders->links('pagination::bootstrap-5')); ?>

    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/orders/index.blade.php ENDPATH**/ ?>