<?php $__env->startSection('title', 'Manage Orders'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-shopping-cart"></i> Orders Management</h2>
            <p>View and manage all customer orders</p>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> All Orders</h5>
            <span class="badge bg-primary"><?php echo e($orders->total()); ?> Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if($orders->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No orders found</h5>
                <p class="text-muted">Orders will appear here once customers start purchasing.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center" style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><span class="badge bg-secondary">#<?php echo e($order->id); ?></span></td>
                                <td>
                                    <strong><?php echo e($order->user->name); ?></strong>
                                    <br><small class="text-muted"><?php echo e($order->user->email); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($order->orderItems->count()); ?> item(s)</span>
                                </td>
                                <td>
                                    <strong class="text-success">₹<?php echo e(number_format($order->total_amount, 2)); ?></strong>
                                </td>
                                <td>
                                    <?php if($order->payment_method == 'online'): ?>
                                        <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> COD</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="<?php echo e(route('admin.orders.status', $order->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <select name="status" 
                                                class="form-select form-select-sm" 
                                                style="width: 140px; font-size: 0.85rem;"
                                                onchange="if(confirm('Change order #<?php echo e($order->id); ?> status to ' + this.value + '?')) this.form.submit(); else this.value='<?php echo e($order->status); ?>';">
                                            <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>⏳ Pending</option>
                                            <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>🔄 Processing</option>
                                            <option value="completed" <?php echo e($order->status == 'completed' ? 'selected' : ''); ?>>✅ Completed</option>
                                            <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>❌ Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-day"></i> <?php echo e($order->created_at->format('d M Y')); ?>

                                    </small>
                                    <br>
                                    <small class="text-muted"><?php echo e($order->created_at->format('h:i A')); ?></small>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-primary" title="View Order Details">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if($orders->isNotEmpty() && $orders->hasPages()): ?>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <span class="text-muted">
                    Showing <strong><?php echo e($orders->firstItem()); ?></strong> to <strong><?php echo e($orders->lastItem()); ?></strong> of <strong><?php echo e($orders->total()); ?></strong> orders
                </span>
                <div>
                    <?php echo e($orders->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>