<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/shops" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Shops
            </a>
        </nav>

        <div class="section-header" style="margin-bottom: var(--space-8);">
            <div>
                <h1 class="heading-section">Manage Shops</h1>
            </div>
            <a href="/shops/create" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
                Create New Shop
            </a>
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

        <?php if (isset($_SESSION['warning'])): ?>
            <div class="alert alert-warning" style="margin-bottom: var(--space-6);">
                <?= $_SESSION['warning']; ?>
                <?php unset($_SESSION['warning']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($shops)): ?>
            <div class="cta-card" style="text-align: center; padding: var(--space-16);">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto var(--space-4); color: var(--muted-foreground);"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <p class="body-text" style="margin-bottom: var(--space-4);">You haven't created any shops yet.</p>
                <a href="/shops/create" class="btn btn-primary">Create your first shop</a>
            </div>
        <?php else: ?>
            <div class="shop-grid">
                <?php foreach ($shops as $shop): ?>
                    <div class="shop-card" style="text-align: left; position: relative;">
                        <div class="shop-avatar">
                            <?php if (!empty($shop['img'])): ?>
                                <img src="<?= htmlspecialchars($shop['img']) ?>" alt="<?= htmlspecialchars($shop['name']) ?>">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--secondary);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground);"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h3 class="shop-name"><?= htmlspecialchars($shop['name']) ?></h3>
                        <p class="shop-products-count" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($shop['description']) ?></p>
                        <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-2);">
                            Created: <?= date('M j, Y', strtotime($shop['created_at'])) ?>
                        </p>

                        <div style="display: flex; gap: var(--space-2); margin-top: var(--space-4); flex-wrap: wrap;">
                            <a href="/shops/<?= $shop['shop_id'] ?>" class="btn btn-sm btn-outline">View</a>
                            <a href="/shops/<?= $shop['shop_id'] ?>/edit" class="btn btn-sm btn-primary">Edit</a>
                            <button type="button" class="btn btn-sm" style="background: var(--accent); color: var(--accent-foreground);" onclick="document.getElementById('deleteModal<?= $shop['shop_id'] ?>').style.display='flex'">Delete</button>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div id="deleteModal<?= $shop['shop_id'] ?>" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4);">
                        <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 400px; width: 100%; box-shadow: var(--shadow-elevated);">
                            <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Confirm Delete</h3>
                                <button type="button" onclick="document.getElementById('deleteModal<?= $shop['shop_id'] ?>').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground); transition: background-color 0.2s;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                </button>
                            </div>
                            <div style="padding: var(--space-6);">
                                <p class="body-text" style="margin-bottom: var(--space-3);">Are you sure you want to delete <strong><?= htmlspecialchars($shop['name']) ?></strong>?</p>
                                <p style="color: var(--accent); font-size: 0.875rem;">This action cannot be undone. All products associated with this shop will also be deleted.</p>
                            </div>
                            <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                                <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal<?= $shop['shop_id'] ?>').style.display='none'">Cancel</button>
                                <form action="/shops/<?= $shop['shop_id'] ?>/delete" method="post" style="margin: 0;">
                                    <button type="submit" class="btn" style="background: var(--accent); color: var(--accent-foreground);">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
