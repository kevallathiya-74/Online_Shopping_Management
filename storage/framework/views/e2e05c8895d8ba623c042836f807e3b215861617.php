<?php $__env->startSection('title', 'Shopping Cart - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-shopping-cart text-primary"></i> Shopping Cart</h2>
            <p class="text-muted mb-0">
                <?php if($cartItems->isNotEmpty()): ?>
                You have <?php echo e($cartItems->count()); ?> item(s) in your cart
                <?php else: ?>
                Your cart is empty
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Continue Shopping
        </a>
    </div>

    <?php if($cartItems->isEmpty()): ?>
    <!-- Empty Cart -->
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
            <h4 class="mb-3">Your cart is empty</h4>
            <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag"></i> Start Shopping
            </a>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-list"></i> Cart Items (<?php echo e($cartItems->count()); ?>)
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row mb-4 pb-4 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?> align-items-center">
                        <!-- Product Image -->
                        <div class="col-md-2 col-3">
                            <div style="background: #f8f9fc; border-radius: 10px; padding: 8px; display: flex; align-items: center; justify-content: center; height: 90px;">
                                <?php if($item->product->image): ?>
                                <img src="<?php echo e($item->product->image); ?>"
                                    alt="<?php echo e($item->product->name); ?>"
                                    style="max-height: 75px; max-width: 100%; object-fit: contain;"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-image fa-2x text-muted" style="display:none;"></i>
                                <?php else: ?>
                                <i class="fas fa-image fa-2x text-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="col-md-4 col-9">
                            <h6 class="mb-1 fw-bold">
                                <a href="<?php echo e(route('products.show', $item->product->id)); ?>" class="text-decoration-none text-dark">
                                    <?php echo e($item->product->name); ?>

                                </a>
                            </h6>
                            <span class="badge bg-primary mb-1" style="font-size: 0.7rem;">
                                <?php echo e($item->product->category->name ?? 'N/A'); ?>

                            </span>
                            <p class="text-success mb-0 fw-bold">₹<?php echo e(number_format($item->product->price, 2)); ?></p>
                        </div>

                        <!-- Quantity Update -->
                        <div class="col-md-3 col-6 mt-2 mt-md-0">
                            <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <label class="form-label fw-bold small">Quantity</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="quantity" class="form-control"
                                        value="<?php echo e($item->quantity); ?>" min="1" max="<?php echo e($item->product->stock); ?>">
                                    <button type="submit" class="btn btn-outline-primary" title="Update Quantity">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <div class="d-md-none mt-1">
                                    <small class="text-muted">Max: <?php echo e($item->product->stock); ?></small>
                                </div>
                            </form>
                        </div>

                        <!-- Subtotal -->
                        <div class="col-md-2 col-6 text-center mt-2 mt-md-0">
                            <p class="small text-muted mb-1">Subtotal</p>
                            <h6 class="fw-bold text-success mb-0">
                                ₹<?php echo e(number_format($item->product->price * $item->quantity, 2)); ?>

                            </h6>
                        </div>

                        <!-- Remove Button -->
                        <div class="col-md-1 col-12 text-end mt-2 mt-md-0">
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

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); color: white;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt"></i> Order Summary</h5>
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
                        <i class="fas fa-check-circle"></i> Proceed to Checkout
                    </a>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-shopping-bag"></i> Add More Items
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/cart/index.blade.php ENDPATH**/ ?>