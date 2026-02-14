

<?php $__env->startSection('title', 'Order Confirmed - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Header -->
            <div class="card mb-4 text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none;">
                <div class="card-body text-white py-5">
                    <i class="fas fa-check-circle fa-4x mb-3"></i>
                    <h2 class="fw-bold mb-2">Order Placed Successfully!</h2>
                    <p class="mb-1 opacity-75">Thank you for your purchase. Your order has been received.</p>
                    <h4 class="mt-3">
                        <span class="badge bg-white text-success px-4 py-2">Order #<?php echo e($order->id); ?></span>
                    </h4>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle text-primary"></i> Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-muted">Order ID:</td>
                                    <td><span class="badge bg-secondary">#<?php echo e($order->id); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Date:</td>
                                    <td><?php echo e($order->created_at->format('d M Y, h:i A')); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status:</td>
                                    <td><span class="badge badge-status-<?php echo e($order->status); ?> px-2 py-1"><?php echo e(ucfirst($order->status)); ?></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-muted">Payment:</td>
                                    <td>
                                        <?php if($order->payment_method == 'online'): ?>
                                            <span class="badge bg-primary"><i class="fas fa-credit-card"></i> Online Payment</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><i class="fas fa-money-bill-wave"></i> Cash on Delivery</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Shipping:</td>
                                    <td><?php echo e($order->shipping_address); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Phone:</td>
                                    <td><?php echo e($order->phone); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-box text-success"></i> Items Ordered</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><strong><?php echo e($item->product->name ?? 'Product Deleted'); ?></strong></td>
                                        <td>₹<?php echo e(number_format($item->price, 2)); ?></td>
                                        <td class="text-center"><span class="badge bg-info"><?php echo e($item->quantity); ?></span></td>
                                        <td class="text-end"><strong>₹<?php echo e(number_format($item->price * $item->quantity, 2)); ?></strong></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <td colspan="4" class="text-end fw-bold fs-6">Grand Total:</td>
                                    <td class="text-end">
                                        <strong class="text-success fs-5">₹<?php echo e(number_format($order->total_amount, 2)); ?></strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-eye"></i> View Order Details
                </a>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-box"></i> My Orders
                </a>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/orders/confirmation.blade.php ENDPATH**/ ?>