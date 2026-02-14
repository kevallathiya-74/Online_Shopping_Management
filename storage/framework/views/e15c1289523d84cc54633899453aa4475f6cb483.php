<?php $__env->startSection('title', 'Checkout - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-credit-card text-primary"></i> Checkout</h2>
            <p class="text-muted mb-0">Complete your order by providing shipping details</p>
        </div>
        <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Cart
        </a>
    </div>

    <form action="<?php echo e(route('orders.place')); ?>" method="POST" id="checkoutForm">
        <?php echo csrf_field(); ?>
        <div class="row">
            <!-- Shipping & Payment Form -->
            <div class="col-lg-7 mb-4">
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-truck text-primary"></i> Shipping Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt"></i> Shipping Address <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="shipping_address"
                                name="shipping_address"
                                rows="3"
                                placeholder="Enter your complete delivery address"
                                required><?php echo e(old('shipping_address', $user->address)); ?></textarea>
                            <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">
                                <i class="fas fa-phone"></i> Phone Number <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="phone"
                                name="phone"
                                value="<?php echo e(old('phone', $user->phone)); ?>"
                                placeholder="e.g., 9876543210"
                                pattern="^\d{10}$"
                                title="Phone number must be exactly 10 digits"
                                required>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card">
                    <div class="card-header py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-wallet text-success"></i> Payment Method</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="row g-3">
                            <!-- Cash on Delivery -->
                            <div class="col-md-6">
                                <div class="form-check card h-100" style="cursor: pointer;">
                                    <div class="card-body p-3">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_offline" value="offline"
                                            <?php echo e(old('payment_method', 'offline') == 'offline' ? 'checked' : ''); ?>

                                            style="position: absolute; top: 15px; right: 15px;">
                                        <label class="form-check-label d-block" for="payment_offline" style="cursor: pointer;">
                                            <div class="text-center py-2">
                                                <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                                <h6 class="fw-bold mb-1">Cash on Delivery</h6>
                                                <small class="text-muted">Pay when you receive your order</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Online Payment -->
                            <div class="col-md-6">
                                <div class="form-check card h-100" style="cursor: pointer;">
                                    <div class="card-body p-3">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="payment_online" value="online"
                                            <?php echo e(old('payment_method') == 'online' ? 'checked' : ''); ?>

                                            style="position: absolute; top: 15px; right: 15px;">
                                        <label class="form-check-label d-block" for="payment_online" style="cursor: pointer;">
                                            <div class="text-center py-2">
                                                <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                                                <h6 class="fw-bold mb-1">Online Payment</h6>
                                                <small class="text-muted">Pay securely via UPI / Card / Net Banking</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); color: white;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-receipt"></i> Order Summary</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Cart Items List -->
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex justify-content-between align-items-start mb-3 <?php echo e(!$loop->last ? 'pb-3 border-bottom' : ''); ?>">
                            <div class="d-flex align-items-center" style="flex: 1;">
                                <div style="width: 45px; height: 45px; background: #f8f9fc; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                    <?php if($item->product->image): ?>
                                    <img src="<?php echo e($item->product->image); ?>"
                                        alt="<?php echo e($item->product->name); ?>"
                                        style="max-width: 35px; max-height: 35px; object-fit: contain;"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <i class="fas fa-box text-muted" style="display:none;"></i>
                                    <?php else: ?>
                                    <i class="fas fa-box text-muted"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <small class="fw-bold d-block"><?php echo e(Str::limit($item->product->name, 25)); ?></small>
                                    <small class="text-muted">Qty: <?php echo e($item->quantity); ?> × ₹<?php echo e(number_format($item->product->price, 0)); ?></small>
                                </div>
                            </div>
                            <div class="text-end">
                                <strong>₹<?php echo e(number_format($item->product->price * $item->quantity, 2)); ?></strong>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Items:</span>
                            <strong><?php echo e($cartItems->count()); ?> product(s)</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <strong>₹<?php echo e(number_format($total, 2)); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping:</span>
                            <strong class="text-success">FREE</strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold mb-0">Total Amount:</h5>
                            <h4 class="text-success fw-bold mb-0">₹<?php echo e(number_format($total, 2)); ?></h4>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg"
                            onclick="return confirm('Are you sure you want to place this order for ₹<?php echo e(number_format($total, 2)); ?>?')">
                            <i class="fas fa-check-circle"></i> Place Order
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock"></i> Your information is secure and encrypted
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Hidden Form for Razorpay Verification -->
    <form id="razorpayForm" action="<?php echo e(route('payment.verify')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (paymentMethod === 'online') {
            e.preventDefault();

            // Show loading state
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing Payment...';

            // Step 1: Create Razorpay Order via AJAX
            const formData = new FormData(this);

            fetch("<?php echo e(route('orders.place')); ?>", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Step 2: Open Razorpay Modal
                        const options = {
                            "key": data.key_id,
                            "amount": data.amount,
                            "currency": "INR",
                            "name": "ShopEasy Online",
                            "description": "Payment for your order",
                            "order_id": data.razorpay_order_id,
                            "handler": function(response) {
                                // Step 3: Payment Success - Submit verification form
                                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                document.getElementById('razorpayForm').submit();
                            },
                            "prefill": {
                                "name": data.name,
                                "email": data.email,
                                "contact": data.contact
                            },
                            "theme": {
                                "color": "#0d6efd"
                            }
                        };
                        const rzp1 = new Razorpay(options);
                        rzp1.open();

                        rzp1.on('payment.failed', function(response) {
                            alert("Payment Failed: " + response.error.description);
                            btn.disabled = false;
                            btn.innerHTML = originalText;
                        });
                    } else {
                        alert("Error: " + (data.error || "Failed to initialize payment"));
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An unexpected error occurred. Please try again.");
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        } else {
            // For COD, proceed with normal form submission
            return true;
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/orders/checkout.blade.php ENDPATH**/ ?>