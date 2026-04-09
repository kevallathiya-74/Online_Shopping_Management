<?php $__env->startSection('title', 'Shopping Cart - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="section-header mb-4">
        <div>
            <h2 class="section-title mb-1"><i class="fas fa-cart-shopping text-primary me-2"></i>Shopping Cart</h2>
            <p class="section-subtitle">
                <?php if($cartItems->isNotEmpty()): ?>
                You have <?php echo e($cartItems->count()); ?> item(s) ready for checkout.
                <?php else: ?>
                Your cart is currently empty.
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i>Continue Shopping
        </a>
    </div>

    <?php if($cartItems->isEmpty()): ?>
    <div class="section-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-cart-shopping"></i></div>
            <h4 class="mb-2 fw-bold">Your cart is empty</h4>
            <p class="text-muted mb-4">Add products from the catalog and return here to checkout.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-bag-shopping me-1"></i>Start Shopping
            </a>
        </div>
    </div>
    <?php else: ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="section-card">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Cart Items (<?php echo e($cartItems->count()); ?>)</h5>
                </div>
                <div class="card-body p-4">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row g-3 align-items-center py-2 <?php echo e(!$loop->last ? 'border-bottom mb-3 pb-4' : ''); ?>">
                        <div class="col-md-2 col-3">
                            <div class="admin-table thumb-box thumb-square-86 mx-auto mx-md-0">
                                <?php if($item->product->image): ?>
                                <img src="<?php echo e($item->product->image); ?>"
                                    alt="<?php echo e($item->product->name); ?>"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-image fa-2x text-muted d-none"></i>
                                <?php else: ?>
                                <i class="fas fa-image fa-2x text-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-4 col-9">
                            <h6 class="mb-1 fw-bold product-title product-title-tight">
                                <a href="<?php echo e(route('products.show', $item->product->id)); ?>" class="text-dark">
                                    <?php echo e($item->product->name); ?>

                                </a>
                            </h6>
                            <span class="badge bg-light text-dark border mb-1">
                                <?php echo e($item->product->category->name ?? 'N/A'); ?>

                            </span>
                            <p class="text-success mb-0 fw-bold">₹<?php echo e(number_format($item->product->price, 2)); ?> each</p>
                        </div>

                        <div class="col-md-3 col-6">
                            <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <label class="form-label small">Quantity</label>
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control"
                                        value="<?php echo e($item->quantity); ?>" min="1" max="<?php echo e($item->product->stock); ?>">
                                    <button type="submit" class="btn btn-outline-primary" title="Update Quantity">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1">Max: <?php echo e($item->product->stock); ?></small>
                            </form>
                        </div>

                        <div class="col-md-2 col-6 text-center">
                            <p class="small text-muted mb-1">Subtotal</p>
                            <h6 class="fw-bold text-success mb-0">
                                ₹<?php echo e(number_format($item->product->price * $item->quantity, 2)); ?>

                            </h6>
                        </div>

                        <div class="col-md-1 col-12 text-end">
                            <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST"
                                onsubmit="return confirm('Remove <?php echo e($item->product->name); ?> from cart?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove Item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="section-card summary-card sticky-top summary-sticky">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-1"></i>Order Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Items:</span>
                        <strong><?php echo e($cartItems->count()); ?> product(s)</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Quantity:</span>
                        <strong><?php echo e($cartItems->sum('quantity')); ?> unit(s)</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal:</span>
                        <strong>₹<?php echo e(number_format($total, 2)); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Shipping:</span>
                        <strong class="text-success">FREE</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold">Total:</h5>
                        <h5 class="text-success fw-bold">₹<?php echo e(number_format($total, 2)); ?></h5>
                    </div>

                    <a href="<?php echo e(route('checkout')); ?>" class="btn btn-success w-100 mb-3 btn-lg">
                        <i class="fas fa-check-circle me-1"></i>Proceed to Checkout
                    </a>

                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-bag-shopping me-1"></i>Add More Items
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/cart/index.blade.php ENDPATH**/ ?>