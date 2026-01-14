<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Product</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/products/<?= $product['id'] ?>/edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="shop_id" value="<?= $product['shop_id'] ?>">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" value="<?= $product['price'] ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" step="1" value="<?= $product['stock'] ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <?php if (!empty($product['img'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div>
                                        <img src="<?= cloudinary_thumbnail($product['img']) ?>" class="img-thumbnail" style="max-height: 200px;" alt="<?= htmlspecialchars($product['name']) ?>">
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <label for="image" class="form-label">Change Product Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Leave empty to keep current image. Recommended size: 800x600 pixels. Max file size: 2MB.</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <a href="/products/manage" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>