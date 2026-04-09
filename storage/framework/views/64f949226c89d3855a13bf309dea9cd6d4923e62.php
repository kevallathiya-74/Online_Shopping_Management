<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('body_class', 'auth-body'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="auth-shell">
                    <div class="row g-0">
                        <div class="col-md-5 d-none d-md-block">
                            <div class="auth-hero">
                                <h2>Secure Sign In</h2>
                                <p>Access your orders, wishlist, saved addresses, and account settings from one clean dashboard.</p>
                                <ul>
                                    <li><i class="fas fa-check-circle"></i> Real-time order tracking</li>
                                    <li><i class="fas fa-check-circle"></i> Faster checkout with saved details</li>
                                    <li><i class="fas fa-check-circle"></i> Easy returns and invoice access</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="auth-form-panel">
                                <h3>Welcome Back</h3>
                                <p class="auth-note">Login to continue shopping with your existing account.</p>

                                <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-circle-exclamation me-1"></i>
                                    <ul class="mb-0 mt-2">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <?php endif; ?>

                                <form action="<?php echo e(route('login')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="you@example.com" required autofocus>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-2">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="password" name="password" placeholder="Enter your password" required>
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="text-end mb-3">
                                        <a href="<?php echo e(route('password.forgot')); ?>" class="small text-muted">
                                            <i class="fas fa-key me-1"></i>Forgot Password?
                                        </a>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="fas fa-right-to-bracket me-1"></i>Login to Account
                                    </button>
                                </form>

                                <hr class="my-4">

                                <p class="text-center mb-0 small">
                                    New to ShopEasy?
                                    <a href="<?php echo e(route('register')); ?>" class="fw-bold ms-1">Create an account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/auth/login.blade.php ENDPATH**/ ?>