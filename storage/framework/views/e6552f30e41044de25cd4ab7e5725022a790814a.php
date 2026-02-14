<?php $__env->startSection('title', 'Manage Categories'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h2><i class="fas fa-tags"></i> Categories Management</h2>
            <p>Manage your product categories</p>
        </div>
        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add Category
        </a>
    </div>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list"></i> All Categories</h5>
            <span class="badge bg-primary"><?php echo e($categories->count()); ?> Total</span>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if($categories->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No categories found</h5>
                <p class="text-muted mb-3">Start by creating your first category</p>
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create First Category
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th class="text-center">Products</th>
                            <th class="text-center" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?php echo e($category->id); ?></span></td>
                                <td><strong><?php echo e($category->name); ?></strong></td>
                                <td>
                                    <?php if($category->description): ?>
                                        <span class="text-muted"><?php echo e(Str::limit($category->description, 60)); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">No description</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?php echo e($category->products_count > 0 ? 'bg-primary' : 'bg-secondary'); ?>">
                                        <?php echo e($category->products_count); ?> product(s)
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" 
                                       class="btn btn-sm btn-warning me-1" title="Edit Category">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.categories.delete', $category->id)); ?>" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this category?<?php echo e($category->products_count > 0 ? ' This category has ' . $category->products_count . ' product(s).' : ''); ?>')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Category">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Online_Shopping_Management\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>