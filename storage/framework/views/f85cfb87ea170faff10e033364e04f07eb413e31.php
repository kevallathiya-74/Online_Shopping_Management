<?php $__env->startSection('title', isset($category) ? $category->name . ' - ShopEasy' : 'Home - ShopEasy'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="section-card hero-banner mb-4">
        <div class="card-body p-4 p-lg-5">
            <span class="hero-highlight mb-3"><i class="fas fa-bolt"></i> New arrivals every week</span>
            <h1 class="hero-title mt-3">Premium picks for everyday shopping</h1>
            <p class="hero-subtitle">Discover trusted products with transparent pricing, simple checkout, and fast order updates from one clean shopping experience.</p>

            <form action="<?php echo e(route('home')); ?>" method="GET" class="search-strip mt-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text"><i class="fas fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search products by name or category" value="<?php echo e(request('search')); ?>">
                    <button class="btn btn-light fw-bold" type="submit">Search</button>
                </div>
            </form>

            <?php if(auth()->guard()->guest()): ?>
            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-light">
                    <i class="fas fa-user-plus me-1"></i>Create Account
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light">
                    <i class="fas fa-right-to-bracket me-1"></i>Login
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section-card mb-4">
        <div class="card-body">
            <div class="section-header">
                <div>
                    <h3 class="section-title"><i class="fas fa-layer-group me-2 text-primary"></i>Shop by Category</h3>
                    <p class="section-subtitle">Pick a category to quickly narrow your results.</p>
                </div>
            </div>

            <div>
                <a href="<?php echo e(route('home', request()->except(['category_id', 'page']))); ?>" class="category-pill <?php echo e(!request('category_id') ? 'active' : ''); ?>">
                    <i class="fas fa-grid-2"></i>All Products
                </a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('home', array_merge(request()->except(['category_id', 'page']), ['category_id' => $cat->id]))); ?>"
                    class="category-pill <?php echo e((string) request('category_id') === (string) $cat->id ? 'active' : ''); ?>">
                    <i class="fas fa-tag"></i><?php echo e($cat->name); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="section-card filter-panel">
                <div class="card-body">
                    <h5 class="section-title mb-2"><i class="fas fa-sliders me-2 text-primary"></i>Filters</h5>
                    <p class="section-subtitle mb-3">Refine results by category, price, and sorting.</p>

                    <form action="<?php echo e(route('home')); ?>" method="GET">
                        <?php if(request('search')): ?>
                        <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e((string) request('category_id') === (string) $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="<?php echo e(request('min_price')); ?>">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="<?php echo e(request('max_price')); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sort" class="form-label">Sort By</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Newest Arrivals</option>
                                <option value="price_low_high" <?php echo e(request('sort') == 'price_low_high' ? 'selected' : ''); ?>>Price: Low to High</option>
                                <option value="price_high_low" <?php echo e(request('sort') == 'price_high_low' ? 'selected' : ''); ?>>Price: High to Low</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="section-header mb-3">
                <div>
                    <h3 class="section-title mb-1"><?php echo e(isset($category) ? $category->name : 'All Products'); ?></h3>
                    <p class="section-subtitle">Curated listing with clean product details and fast actions.</p>
                </div>
                <span class="badge-soft"><?php echo e($products->total()); ?> products</span>
            </div>

            <?php if($products->isEmpty()): ?>
            <div class="section-card">
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                    <h5 class="fw-bold">No products found</h5>
                    <p class="text-muted mb-3">
                        <?php if(isset($category)): ?>
                        Nothing is available in "<?php echo e($category->name); ?>" right now.
                        <?php elseif(request('search') || request('min_price') || request('max_price')): ?>
                        No results match your search or filter combination.
                        <?php else: ?>
                        Products will appear here as soon as inventory is added.
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary">View all products</a>
                </div>
            </div>
            <?php else: ?>
            <div class="row g-4">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-4 col-md-6">
                    <div class="card product-card h-100">
                        <div class="product-thumb">
                            <?php if(auth()->guard()->check()): ?>
                            <form action="<?php echo e($product->inWishlist() ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php if($product->inWishlist()): ?>
                                <?php echo method_field('DELETE'); ?>
                                <?php endif; ?>
                                <button type="submit" class="wishlist-fab" title="Wishlist">
                                    <i class="<?php echo e($product->inWishlist() ? 'fas text-danger' : 'far'); ?> fa-heart"></i>
                                </button>
                            </form>
                            <?php endif; ?>

                            <?php if($product->image): ?>
                            <img src="<?php echo e($product->image); ?>" alt="<?php echo e($product->name); ?>"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="d-none h-100 w-100 align-items-center justify-content-center flex-column text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <small>Image unavailable</small>
                            </div>
                            <?php else: ?>
                            <div class="d-flex h-100 w-100 align-items-center justify-content-center flex-column text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <small>No image</small>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark border"><?php echo e($product->category->name); ?></span>
                                <?php if($product->stock > 0): ?>
                                <span class="stock-badge in-stock">In Stock</span>
                                <?php else: ?>
                                <span class="stock-badge out-of-stock">Out of Stock</span>
                                <?php endif; ?>
                            </div>

                            <h6 class="product-title"><?php echo e(Str::limit($product->name, 44)); ?></h6>

                            <p class="product-meta mb-3"><?php echo e(Str::limit($product->description ?? 'Quality product with verified listing details.', 70)); ?></p>

                            <div class="d-flex justify-content-between align-items-center mt-auto mb-3">
                                <span class="price-tag">₹<?php echo e(number_format($product->price, 0)); ?></span>
                                <small class="text-muted"><?php echo e(max((int) $product->stock, 0)); ?> left</small>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>

                                <?php if(auth()->guard()->check()): ?>
                                <?php if($product->stock > 0): ?>
                                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                    </button>
                                </form>
                                <?php else: ?>
                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                    Unavailable
                                </button>
                                <?php endif; ?>
                                <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-right-to-bracket me-1"></i>Login to Buy
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if($products->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($products->links('pagination::bootstrap-5')); ?>

            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $featuredProducts = $products->take(3);
    ?>

    <?php if($featuredProducts->isNotEmpty()): ?>
    <div class="section-card mt-4">
        <div class="card-body">
            <div class="section-header">
                <div>
                    <h4 class="section-title"><i class="fas fa-star me-2 text-warning"></i>Featured This Week</h4>
                    <p class="section-subtitle">A few highlighted products customers are currently exploring.</p>
                </div>
            </div>

            <div class="row g-3">
                <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featured): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <a href="<?php echo e(route('products.show', $featured->id)); ?>" class="section-card d-block p-3 h-100 text-dark">
                        <div class="d-flex align-items-center gap-3">
                            <div class="admin-table thumb-box thumb-square-64">
                                <?php if($featured->image): ?>
                                <img src="<?php echo e($featured->image); ?>" alt="<?php echo e($featured->name); ?>">
                                <?php else: ?>
                                <i class="fas fa-image text-muted"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="fw-bold"><?php echo e(Str::limit($featured->name, 30)); ?></div>
                                <div class="small text-muted"><?php echo e($featured->category->name); ?></div>
                                <div class="fw-bold mt-1">₹<?php echo e(number_format($featured->price, 0)); ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/home.blade.php ENDPATH**/ ?>