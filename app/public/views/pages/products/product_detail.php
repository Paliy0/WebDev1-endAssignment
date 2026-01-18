<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="margin-bottom: var(--space-6);">
                <?= htmlspecialchars($_SESSION['success']); ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: var(--space-6);">
                <?= htmlspecialchars($_SESSION['error']); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <nav style="margin-bottom: var(--space-6);">
            <a href="/products" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Products
            </a>
        </nav>

        <div style="display: grid; gap: var(--space-8); grid-template-columns: 1fr 1fr;" class="product-detail-grid">
            <div>
                <?php if (!empty($product['img'])): ?>
                    <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; border-radius: var(--radius-xl); aspect-ratio: 1/1; object-fit: contain; background: var(--secondary);">
                <?php else: ?>
                    <div style="width: 100%; aspect-ratio: 1/1; border-radius: var(--radius-xl); background: var(--secondary); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground);"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <p class="body-text text-muted" style="margin-top: var(--space-3);">No image available</p>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-2);">
                    <a href="/shops/<?= $product['shop_id'] ?>" class="overline" style="color: var(--accent);"><?= htmlspecialchars($product['shop_name']) ?></a>
                </div>

                <h1 class="heading-section" style="margin-bottom: var(--space-4);"><?= htmlspecialchars($product['name']) ?></h1>

                <div style="display: flex; align-items: baseline; gap: var(--space-3); margin-bottom: var(--space-6);">
                    <span style="font-family: var(--font-serif); font-size: 2rem; font-weight: 600; color: var(--foreground);">$<?= number_format($product['price'], 2) ?></span>
                    <?php if ($product['stock'] > 0): ?>
                        <span class="badge badge-success">In Stock (<?= $product['stock'] ?> available)</span>
                    <?php else: ?>
                        <span class="badge badge-error">Out of Stock</span>
                    <?php endif; ?>
                </div>

                <div style="margin-bottom: var(--space-8);">
                    <p class="overline" style="margin-bottom: var(--space-2);">Description</p>
                    <p class="body-text" style="color: var(--muted-foreground);"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>

                <?php if ($product['stock'] > 0): ?>
                    <form action="/cart/add" method="post" style="display: flex; gap: var(--space-3); flex-wrap: wrap; margin-bottom: var(--space-8);">
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <div style="display: flex; align-items: center; gap: var(--space-2);">
                            <label for="quantity" class="form-label" style="margin: 0; white-space: nowrap;">Qty:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-input" style="width: 80px;">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                            Add to Cart
                        </button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-lg" style="background: var(--muted); color: var(--muted-foreground); cursor: not-allowed; margin-bottom: var(--space-8);" disabled>Out of Stock</button>
                <?php endif; ?>

                <div style="display: flex; gap: var(--space-3); padding-top: var(--space-6); border-top: 1px solid var(--border);">
                    <a href="/shops/<?= $product['shop_id'] ?>" class="btn btn-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        More from this Shop
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
@media (max-width: 768px) {
    .product-detail-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
