<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container" style="max-width: 640px;">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/products/manage" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Manage Products
            </a>
        </nav>

        <div style="margin-bottom: var(--space-8);">
            <h1 class="heading-section">Edit Product</h1>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: var(--space-6);">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="cta-card">
            <form action="/products/<?= $product['id'] ?>/edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="shop_id" value="<?= $product['shop_id'] ?>">

                <div class="form-group">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-input" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" class="form-input" id="price" name="price" min="0.01" step="0.01" value="<?= $product['price'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-input" id="stock" name="stock" min="0" step="1" value="<?= $product['stock'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-input" id="description" name="description" rows="5" style="resize: vertical;"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <?php if (!empty($product['img'])): ?>
                        <div style="margin-bottom: var(--space-4);">
                            <label class="form-label">Current Image</label>
                            <div style="margin-top: var(--space-2);">
                                <img src="<?= cloudinary_thumbnail($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-height: 200px; border-radius: var(--radius-lg); border: 1px solid var(--border);">
                            </div>
                        </div>
                    <?php endif; ?>

                    <label for="image" class="form-label">Change Product Image</label>
                    <input type="file" class="form-input" id="image" name="image" accept="image/*">
                    <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-2);">Leave empty to keep current image. Recommended size: 800x600 pixels. Max file size: 2MB.</p>
                </div>

                <div style="display: flex; flex-direction: column; gap: var(--space-3); margin-top: var(--space-6);">
                    <button type="submit" class="btn btn-primary btn-full">Update Product</button>
                    <a href="/products/manage" class="btn btn-outline btn-full">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
