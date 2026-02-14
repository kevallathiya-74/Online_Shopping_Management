<?php $__env->startSection('title', $product->name . ' - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="background: white; padding: 12px 20px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="text-decoration-none"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.category', $product->category_id)); ?>" class="text-decoration-none"><?php echo e($product->category->name); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(Str::limit($product->name, 40)); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-body p-4">
                    <?php if($product->image): ?>
                    <div style="height: 400px; display: flex; align-items: center; justify-content: center; background: #f8f9fc; border-radius: 12px; padding: 20px;">
                        <img src="<?php echo e($product->image); ?>"
                            alt="<?php echo e($product->name); ?>"
                            style="max-height: 380px; max-width: 100%; object-fit: contain;"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display:none; align-items:center; justify-content:center; flex-direction:column; color:#adb5bd;">
                            <i class="fas fa-image fa-4x mb-3"></i>
                            <p class="mb-0">Image not available</p>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5" style="background: #f8f9fc; border-radius: 12px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                        <p class="mt-3 text-muted">No image available</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-body p-4">
                    <!-- Category Badge -->
                    <span class="badge bg-primary mb-3 px-3 py-2">
                        <i class="fas fa-tag"></i> <?php echo e($product->category->name); ?>

                    </span>

                    <!-- Product Name -->
                    <h2 class="fw-bold mb-3"><?php echo e($product->name); ?></h2>

                    <!-- Price & Stock -->
                    <div class="d-flex align-items-center mb-4 flex-wrap gap-3">
                        <span class="price-tag" style="font-size: 2.2rem;">₹<?php echo e(number_format($product->price, 2)); ?></span>
                        <span class="badge <?php echo e($product->stock > 0 ? 'bg-success' : 'bg-danger'); ?> px-3 py-2">
                            <?php if($product->stock > 0): ?>
                            <i class="fas fa-check-circle"></i> <?php echo e($product->stock); ?> in stock
                            <?php else: ?>
                            <i class="fas fa-times-circle"></i> Out of Stock
                            <?php endif; ?>
                        </span>
                    </div>

                    <hr>

                    <!-- Description -->
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle text-primary"></i> Product Description</h5>
                    <p class="text-muted" style="line-height: 1.8;">
                        <?php echo e($product->description ?? 'No description available for this product.'); ?>

                    </p>

                    <hr>

                    <!-- Add to Cart / Login -->
                    <?php if(auth()->guard()->check()): ?>
                    <?php if($product->stock > 0): ?>
                    <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-bold"><i class="fas fa-sort-numeric-up"></i> Quantity</label>
                                <input type="number" name="quantity" class="form-control"
                                    value="1" min="1" max="<?php echo e($product->stock); ?>">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php else: ?>
                    <button class="btn btn-secondary btn-lg w-100 mb-3" disabled>
                        <i class="fas fa-ban"></i> Currently Unavailable
                    </button>
                    <?php endif; ?>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="fas fa-sign-in-alt"></i> Login to Purchase
                    </a>
                    <?php endif; ?>

                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="card mt-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-star text-warning"></i> Customer Reviews (<?php echo e($product->reviews->count()); ?>)</h5>
        </div>
        <div class="card-body">
            <!-- Average Rating -->
            <?php
            $avgRating = $product->reviews->avg('rating') ?: 0;
            ?>
            <div class="mb-4">
                <h1 class="fw-bold mb-0"><?php echo e(number_format($avgRating, 1)); ?> <small class="text-muted fs-6">/ 5</small></h1>
                <div class="text-warning">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="<?php echo e($i <= round($avgRating) ? 'fas' : 'far'); ?> fa-star"></i>
                        <?php endfor; ?>
                </div>
                <small class="text-muted">Based on <?php echo e($product->reviews->count()); ?> reviews</small>
            </div>

            <hr>

            <!-- Review Form -->
            <?php if(auth()->guard()->check()): ?>
            <?php
            $userReview = $product->reviews->where('user_id', auth()->id())->first();
            ?>

            <?php if(!$userReview): ?>
            <h6 class="fw-bold mb-3">Write a Review</h6>
            <form action="<?php echo e(route('products.review', $product->id)); ?>" method="POST" class="mb-4">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="rating-input">
                        <div class="btn-group" role="group">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" class="btn-check" name="rating" id="rating<?php echo e($i); ?>" value="<?php echo e($i); ?>" <?php echo e($i == 5 ? 'checked' : ''); ?>>
                                <label class="btn btn-outline-warning" for="rating<?php echo e($i); ?>"><?php echo e($i); ?> <i class="fas fa-star"></i></label>
                                <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Your Review</label>
                    <textarea name="review" class="form-control" rows="3" placeholder="Share your experience..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
            <hr>
            <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-check-circle"></i> You have already reviewed this product.
            </div>
            <?php endif; ?>
            <?php else: ?>
            <div class="alert alert-light border">
                Please <a href="<?php echo e(route('login')); ?>">login</a> to leave a review.
            </div>
            <?php endif; ?>

            <!-- Reviews List -->
            <?php $__empty_1 = true; $__currentLoopData = $product->reviews()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mb-1"><?php echo e($review->user->name); ?></h6>
                    <small class="text-muted"><?php echo e($review->created_at->diffForHumans()); ?></small>
                </div>
                <div class="text-warning mb-2" style="font-size: 0.9rem;">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <i class="<?php echo e($i <= $review->rating ? 'fas' : 'far'); ?> fa-star"></i>
                        <?php endfor; ?>
                </div>
                <p class="text-muted mb-0"><?php echo e($review->review); ?></p>
            </div>
            <?php if(!$loop->last): ?>
            <hr class="my-3"> <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted text-center py-3">No reviews yet. Be the first to review!</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/products/show.blade.php ENDPATH**/ ?>