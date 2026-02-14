<?php $__env->startSection('title', 'Order #' . $order->id . ' - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-receipt text-primary"></i> Order #<?php echo e($order->id); ?></h2>
            <p class="text-muted mb-0">Placed on <?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
        </div>
        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8 mb-4">
            <!-- Order Status Card -->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle text-primary"></i> Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-muted" style="width: 120px;">Order ID:</td>
                                    <td><span class="badge bg-secondary">#<?php echo e($order->id); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Date:</td>
                                    <td><?php echo e($order->created_at->format('d M Y, h:i A')); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status:</td>
                                    <td>
                                        <span class="badge badge-status-<?php echo e($order->status); ?> px-3 py-1">
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
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-muted" style="width: 120px;">Payment:</td>
                                    <td>
                                        <?php if($order->payment_method == 'online'): ?>
                                        <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online Payment</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> Cash on Delivery</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Address:</td>
                                    <td><?php echo e($order->shipping_address); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Phone:</td>
                                    <td><i class="fas fa-phone text-muted"></i> <?php echo e($order->phone); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-box text-success"></i> Products Ordered (<?php echo e($order->orderItems->count()); ?>)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <?php if($item->product): ?>
                                        <a href="<?php echo e(route('products.show', $item->product->id)); ?>" class="text-decoration-none fw-bold">
                                            <?php echo e($item->product->name); ?>

                                        </a>
                                        <?php else: ?>
                                        <span class="text-muted">Product Deleted</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($item->product && $item->product->category): ?>
                                        <span class="badge bg-primary" style="font-size: 0.7rem;">
                                            <?php echo e($item->product->category->name); ?>

                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">₹<?php echo e(number_format($item->price, 2)); ?></td>
                                    <td class="text-center"><span class="badge bg-info"><?php echo e($item->quantity); ?></span></td>
                                    <td class="text-end"><strong>₹<?php echo e(number_format($item->price * $item->quantity, 2)); ?></strong></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <td colspan="5" class="text-end fw-bold fs-6">Grand Total:</td>
                                    <td class="text-end">
                                        <strong class="text-success fs-5">₹<?php echo e(number_format($order->total_amount, 2)); ?></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); color: white;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt"></i> Order Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Items:</span>
                        <strong><?php echo e($order->orderItems->count()); ?> product(s)</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Quantity:</span>
                        <strong><?php echo e($order->orderItems->sum('quantity')); ?> units</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping:</span>
                        <strong class="text-success">FREE</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="fw-bold mb-0">Total:</h5>
                        <h4 class="text-success fw-bold mb-0">₹<?php echo e(number_format($order->total_amount, 2)); ?></h4>
                    </div>

                    <hr>

                    <!-- Order Status Info -->
                    <div class="text-center">
                        <?php if($order->status == 'pending'): ?>
                        <div class="alert alert-warning mb-3 py-2">
                            <i class="fas fa-clock"></i> Your order is <strong>pending</strong> and will be processed soon.
                        </div>
                        <!-- Cancel Button — Only for Pending Orders -->
                        <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel Order #<?php echo e($order->id); ?>?\n\nThis action cannot be undone.\nProduct stock will be restored.');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <button type="submit" class="btn btn-danger w-100 mb-2">
                                <i class="fas fa-times-circle"></i> Cancel This Order
                            </button>
                        </form>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> You can only cancel orders that are still pending.
                        </small>
                        <?php elseif($order->status == 'processing'): ?>
                        <div class="alert alert-info mb-3 py-2">
                            <i class="fas fa-spinner fa-spin"></i> Your order is being <strong>processed</strong>.
                        </div>
                        <div class="alert alert-light border mb-0 py-2">
                            <small><i class="fas fa-info-circle text-muted"></i> Orders being processed cannot be cancelled. Please contact support if needed.</small>
                        </div>
                        <?php elseif($order->status == 'completed'): ?>
                        <div class="alert alert-success mb-3 py-2">
                            <i class="fas fa-check-circle"></i> Your order has been <strong>completed</strong>!
                        </div>
                        <div class="alert alert-light border mb-0 py-2">
                            <small><i class="fas fa-info-circle text-muted"></i> Completed orders cannot be cancelled.</small>
                        </div>
                        <?php elseif($order->status == 'cancelled'): ?>
                        <div class="alert alert-danger mb-3 py-2">
                            <i class="fas fa-times-circle"></i> This order was <strong>cancelled</strong>.
                        </div>
                        <div class="alert alert-light border mb-0 py-2">
                            <small><i class="fas fa-info-circle text-muted"></i> Product stock has been restored to inventory.</small>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card mt-3">
                <div class="card-body">
                    <a href="<?php echo e(route('orders.invoice', $order->id)); ?>" class="btn btn-dark w-100 mb-2">
                        <i class="fas fa-file-pdf"></i> Download Invoice
                    </a>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list"></i> All Orders
                    </a>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/orders/show.blade.php ENDPATH**/ ?>