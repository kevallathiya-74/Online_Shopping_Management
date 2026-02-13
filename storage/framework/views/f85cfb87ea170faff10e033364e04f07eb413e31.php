<?php $__env->startSection('title', isset($category) ? $category->name . ' - ShopEasy' : 'Home - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Hero Section -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); border: none; border-radius: 16px; overflow: hidden;">
        <div class="card-body text-white text-center py-5">
            <h1 class="fw-bold mb-2"><i class="fas fa-shopping-bag"></i> Welcome to ShopEasy</h1>
            <p class="mb-3 opacity-75 fs-5">Discover amazing products at great prices!</p>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg me-2">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <h5 class="fw-bold mb-3"><i class="fas fa-filter text-primary"></i> Shop by Category</h5>
            <div class="d-flex flex-wrap">
                <a href="<?php echo e(route('home')); ?>" 
                   class="btn btn-outline-primary category-btn <?php echo e(!isset($category) ? 'active' : ''); ?>">
                    <i class="fas fa-th"></i> All Products
                </a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('products.category', $cat->id)); ?>" 
                       class="btn btn-outline-primary category-btn <?php echo e(isset($category) && $category->id == $cat->id ? 'active' : ''); ?>">
                        <i class="fas fa-tag"></i> <?php echo e($cat->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Products Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-boxes text-primary"></i> 
            <?php echo e(isset($category) ? $category->name : 'All Products'); ?>

        </h3>
        <span class="badge-custom"><?php echo e($products->total()); ?> Products</span>
    </div>

    <!-- Products Grid -->
    <?php if($products->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No products available</h5>
                <p class="text-muted">
                    <?php if(isset($category)): ?>
                        No products found in "<?php echo e($category->name); ?>" category.
                        <br><a href="<?php echo e(route('home')); ?>" class="text-primary">View all products</a>
                    <?php else: ?>
                        Products will appear here once they are added.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100">
                        <div class="card-body p-3">
                            <!-- Product Image -->
                            <div class="product-image-container">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e($product->image); ?>" 
                                         alt="<?php echo e($product->name); ?>"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display:none; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#adb5bd;">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <small>Image not available</small>
                                    </div>
                                <?php else: ?>
                                    <div style="display:flex; height:100%; align-items:center; justify-content:center; flex-direction:column; color:#adb5bd;">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <small>No image</small>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Category Badge -->
                            <span class="badge bg-primary mb-2" style="font-size: 0.7rem;">
                                <?php echo e($product->category->name); ?>

                            </span>

                            <!-- Product Name -->
                            <h6 class="card-title fw-bold mb-2" style="height: 38px; overflow: hidden; line-height: 1.4;">
                                <?php echo e(Str::limit($product->name, 35)); ?>

                            </h6>

                            <!-- Price & Stock -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="price-tag" style="font-size: 1.3rem;">₹<?php echo e(number_format($product->price, 0)); ?></span>
                                <span class="badge <?php echo e($product->stock > 0 ? 'bg-success' : 'bg-danger'); ?>" style="font-size: 0.65rem;">
                                    <?php if($product->stock > 0): ?>
                                        <i class="fas fa-check-circle"></i> In Stock
                                    <?php else: ?>
                                        <i class="fas fa-times-circle"></i> Out of Stock
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card-footer bg-white border-0 p-3 pt-0">
                            <div class="d-grid gap-2">
                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if($product->stock > 0): ?>
                                        <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-ban"></i> Unavailable
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sign-in-alt"></i> Login to Buy
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <?php if($products->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($products->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/home.blade.php ENDPATH**/ ?>