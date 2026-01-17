<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/shops" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Shops
            </a>
        </nav>

        <!-- Shop Header -->
        <div style="display: grid; gap: var(--space-8); margin-bottom: var(--space-12);">
            <div style="display: grid; grid-template-columns: 1fr; gap: var(--space-8);">
                <!-- Shop Image and Info -->
                <div style="display: flex; flex-direction: column; gap: var(--space-6);">
                    <?php if (!empty($shop['img'])): ?>
                        <div style="aspect-ratio: 16/9; max-height: 300px; border-radius: var(--radius-xl); overflow: hidden; background: var(--secondary);">
                            <img src="<?= cloudinary_thumbnail($shop['img'], false) ?>" alt="<?= htmlspecialchars($shop['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php else: ?>
                        <div style="aspect-ratio: 16/9; max-height: 300px; border-radius: var(--radius-xl); background: var(--secondary); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground);"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                    <?php endif; ?>

                    <div>
                        <h1 class="heading-section" style="margin-bottom: var(--space-4);"><?= htmlspecialchars($shop['name']) ?></h1>
                        <p class="body-text text-muted" style="line-height: 1.8;"><?= nl2br(htmlspecialchars($shop['description'])) ?></p>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="cta-card">
                    <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500; margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        Contact Information
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                        <div style="display: flex; align-items: flex-start; gap: var(--space-3);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground); flex-shrink: 0; margin-top: 2px;"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                            <div>
                                <p style="font-size: 0.75rem; color: var(--muted-foreground); text-transform: uppercase; letter-spacing: 0.05em;">Email</p>
                                <p class="body-text"><?= htmlspecialchars($shop['contact_email']) ?></p>
                            </div>
                        </div>

                        <?php if (!empty($shop['contact_number'])): ?>
                            <div style="display: flex; align-items: flex-start; gap: var(--space-3);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground); flex-shrink: 0; margin-top: 2px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <div>
                                    <p style="font-size: 0.75rem; color: var(--muted-foreground); text-transform: uppercase; letter-spacing: 0.05em;">Phone</p>
                                    <p class="body-text"><?= htmlspecialchars($shop['contact_number']) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($shop['address'])): ?>
                            <div style="display: flex; align-items: flex-start; gap: var(--space-3);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground); flex-shrink: 0; margin-top: 2px;"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <div>
                                    <p style="font-size: 0.75rem; color: var(--muted-foreground); text-transform: uppercase; letter-spacing: 0.05em;">Address</p>
                                    <p class="body-text"><?= nl2br(htmlspecialchars($shop['address'])) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="section-header" style="margin-bottom: var(--space-8);">
            <div>
                <h2 class="heading-section">Products</h2>
            </div>
        </div>

        <?php if (empty($products)): ?>
            <div class="cta-card" style="text-align: center; padding: var(--space-12);">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto var(--space-4); color: var(--muted-foreground);"><path d="m7.5 4.27 9 5.15"></path><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
                <p class="body-text text-muted">This shop doesn't have any products yet.</p>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <a href="/products/<?= $product['product_id'] ?>" class="product-card" style="text-decoration: none;">
                        <div class="product-image-container">
                            <?php if (!empty($product['img'])): ?>
                                <img src="<?= cloudinary_thumbnail($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--secondary);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground);"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                                </div>
                            <?php endif; ?>

                            <?php if ($product['stock'] > 0): ?>
                                <div class="quick-add-overlay">
                                    <form action="/cart/add" method="post" onclick="event.stopPropagation();">
                                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-full btn-sm">Add to Cart</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="product-info">
                            <p class="product-name"><?= htmlspecialchars($product['name']) ?></p>
                            <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-1); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($product['description']) ?></p>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: var(--space-2);">
                                <p class="product-price">$<?= number_format($product['price'], 2) ?></p>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge badge-success"><?= $product['stock'] ?> in stock</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Out of stock</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
