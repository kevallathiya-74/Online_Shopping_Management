

<?php $__env->startSection('title', 'Order #' . $order->id . ' - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="section-header mb-4">
        <div>
            <h2 class="section-title mb-1"><i class="fas fa-receipt text-primary me-2"></i>Order #<?php echo e($order->id); ?></h2>
            <p class="section-subtitle">Placed on <?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
        </div>
        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Orders
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="section-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-circle-info text-primary me-2"></i>Order Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted fw-semibold meta-label-col">Order ID</td>
                                    <td><span class="badge bg-dark-subtle text-dark border">#<?php echo e($order->id); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Date</td>
                                    <td><?php echo e($order->created_at->format('d M Y, h:i A')); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Status</td>
                                    <td>
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
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted fw-semibold meta-label-col">Payment</td>
                                    <td>
                                        <?php if($order->payment_method == 'online'): ?>
                                        <span class="badge bg-primary"><i class="fas fa-credit-card me-1"></i>Online Payment</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary"><i class="fas fa-money-bill-wave me-1"></i>Cash on Delivery</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Address</td>
                                    <td class="text-wrap-anywhere"><?php echo e($order->shipping_address); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-semibold">Phone</td>
                                    <td><?php echo e($order->phone); ?></td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-box text-success me-2"></i>Products Ordered (<?php echo e($order->orderItems->count()); ?>)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
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
                                    <a href="<?php echo e(route('products.show', $item->product->id)); ?>" class="fw-bold text-wrap-anywhere d-inline-block">
                                        <?php echo e($item->product->name); ?>

                                    </a>
                                    <?php else: ?>
                                    <span class="text-muted">Product Deleted</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($item->product && $item->product->category): ?>
                                    <span class="badge bg-light text-dark border"><?php echo e($item->product->category->name); ?></span>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">₹<?php echo e(number_format($item->price, 2)); ?></td>
                                <td class="text-center"><span class="badge bg-info"><?php echo e($item->quantity); ?></span></td>
                                <td class="text-end fw-bold">₹<?php echo e(number_format($item->price * $item->quantity, 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="5" class="text-end fw-bold">Grand Total</td>
                                <td class="text-end text-success fw-bold fs-5">₹<?php echo e(number_format($order->total_amount, 2)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="section-card summary-card sticky-top summary-sticky">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-file-invoice me-1"></i>Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Items</span>
                        <strong><?php echo e($order->orderItems->count()); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Quantity</span>
                        <strong><?php echo e($order->orderItems->sum('quantity')); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <strong class="text-success">FREE</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="fw-bold mb-0">Total</h5>
                        <h4 class="text-success fw-bold mb-0">₹<?php echo e(number_format($order->total_amount, 2)); ?></h4>
                    </div>

                    <?php if($order->status == 'pending'): ?>
                    <div class="alert alert-warning py-2">
                        <i class="fas fa-clock me-1"></i>Your order is pending and can be cancelled.
                    </div>
                    <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST"
                        onsubmit="return confirm('Are you sure you want to cancel Order #<?php echo e($order->id); ?>? This action cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <button type="submit" class="btn btn-outline-danger w-100 mb-2">
                            <i class="fas fa-xmark me-1"></i>Cancel Order
                        </button>
                    </form>
                    <?php elseif($order->status == 'processing'): ?>
                    <div class="alert alert-info py-2 mb-3">
                        <i class="fas fa-spinner me-1"></i>Your order is currently being processed.
                    </div>
                    <?php elseif($order->status == 'completed'): ?>
                    <div class="alert alert-success py-2 mb-3">
                        <i class="fas fa-check-circle me-1"></i>This order has been completed.
                    </div>
                    <?php else: ?>
                    <div class="alert alert-danger py-2 mb-3">
                        <i class="fas fa-times-circle me-1"></i>This order was cancelled.
                    </div>
                    <?php endif; ?>

                    <a href="<?php echo e(route('orders.invoice', $order->id)); ?>" class="btn btn-dark w-100 mb-2">
                        <i class="fas fa-file-pdf me-1"></i>Download Invoice
                    </a>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-bag-shopping me-1"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/orders/show.blade.php ENDPATH**/ ?>