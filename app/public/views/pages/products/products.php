<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Home
            </a>
        </nav>

        <div class="section-header" style="margin-bottom: var(--space-8);">
            <div>
                <h1 class="heading-section">All Products</h1>
            </div>
        </div>

        <div style="margin-bottom: var(--space-8);">
            <form action="/products" method="get" id="search-form" style="display: flex; gap: var(--space-3); max-width: 480px;">
                <div style="position: relative; flex: 1;">
                    <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--muted-foreground);" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    <input type="text" name="search" id="product-search" class="form-input" placeholder="Search products..." value="<?= htmlspecialchars($search ?? '') ?>" style="padding-left: 48px;">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="margin-bottom: var(--space-6);">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: var(--space-6);">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div id="products-container">
            <?php if (empty($products)): ?>
                <div class="cta-card" style="text-align: center; padding: var(--space-16);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto var(--space-4); color: var(--muted-foreground);"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    <p class="body-text text-muted">No products found.</p>
                </div>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($products as $product): ?>
                        <a href="/products/<?= $product['product_id'] ?>" class="product-card" style="text-decoration: none;">
                             <div class="product-image-container">
                                 <?php if (!empty($product['img'])): ?>
                                     <img src="<?= cloudinary_thumbnail($product['img']) ?>" class="product-image" alt="<?= htmlspecialchars($product['name']) ?>">
                                 <?php else: ?>
                                     <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: var(--secondary);">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground);"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                     </div>
                                 <?php endif; ?>
                                 <div class="quick-add-overlay">
                                     <span class="btn btn-primary btn-sm btn-full">View Details</span>
                                 </div>
                             </div>
                            <div class="product-info">
                                <p class="product-shop"><?= htmlspecialchars($product['shop_name']) ?></p>
                                <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                                <p class="product-price">$<?= number_format($product['price'], 2) ?></p>
                                <p style="font-size: 0.75rem; margin-top: var(--space-2);">
                                    <?php if ($product['stock'] > 0): ?>
                                        <span style="color: var(--success, #22c55e);">In Stock (<?= $product['stock'] ?>)</span>
                                    <?php else: ?>
                                        <span style="color: var(--muted-foreground);">Out of Stock</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
