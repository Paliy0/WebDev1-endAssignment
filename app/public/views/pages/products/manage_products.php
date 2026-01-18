<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/products" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Products
            </a>
        </nav>

        <div class="section-header" style="margin-bottom: var(--space-8);">
            <div>
                <h1 class="heading-section">Manage Products</h1>
            </div>
            <a href="/products/create" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
                Add New Product
            </a>
        </div>

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

        <?php if (isset($_SESSION['warning'])): ?>
            <div class="alert alert-warning" style="margin-bottom: var(--space-6);">
                <?= htmlspecialchars($_SESSION['warning']); ?>
                <?php unset($_SESSION['warning']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="cta-card" style="text-align: center; padding: var(--space-16);">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto var(--space-4); color: var(--muted-foreground);"><path d="m7.5 4.27 9 5.15"></path><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
                <p class="body-text" style="margin-bottom: var(--space-4);">No products found.</p>
                <a href="/products/create" class="btn btn-primary">Add your first product</a>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($product['img'])): ?>
                                        <img src="<?= cloudinary_thumbnail($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--radius-sm);">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; background: var(--secondary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground);"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 500;"><?= htmlspecialchars($product['name']) ?></td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <?php if ($product['stock'] > 0): ?>
                                        <span class="badge badge-success"><?= $product['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Out of Stock</span>
                                    <?php endif; ?>
                                </td>
                                <td style="color: var(--muted-foreground); font-size: 0.875rem;"><?= date('M j, Y', strtotime($product['created_at'])) ?></td>
                                <td>
                                    <div style="display: flex; gap: var(--space-2);">
                                        <a href="/products/<?= $product['product_id'] ?>" class="btn btn-sm btn-outline">View</a>
                                        <a href="/products/<?= $product['product_id'] ?>/edit" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm" style="background: var(--accent); color: var(--accent-foreground);" onclick="document.getElementById('deleteModal<?= $product['product_id'] ?>').style.display='flex'">Delete</button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div id="deleteModal<?= $product['product_id'] ?>" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4);">
                                        <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 400px; width: 100%; box-shadow: var(--shadow-elevated);">
                                            <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                                                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Confirm Delete</h3>
                                                <button type="button" onclick="document.getElementById('deleteModal<?= $product['product_id'] ?>').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                                </button>
                                            </div>
                                            <div style="padding: var(--space-6);">
                                                <p class="body-text" style="margin-bottom: var(--space-3);">Are you sure you want to delete <strong><?= htmlspecialchars($product['name']) ?></strong>?</p>
                                                <p style="color: var(--accent); font-size: 0.875rem;">This action cannot be undone.</p>
                                            </div>
                                            <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                                                <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal<?= $product['product_id'] ?>').style.display='none'">Cancel</button>
                                                <form action="/products/<?= $product['product_id'] ?>/delete" method="post" style="margin: 0;">
                                                    <button type="submit" class="btn" style="background: var(--accent); color: var(--accent-foreground);">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
