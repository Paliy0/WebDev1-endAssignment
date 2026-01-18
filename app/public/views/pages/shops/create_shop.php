<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container" style="max-width: 640px;">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/shops/manage" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Manage Shops
            </a>
        </nav>

        <div style="margin-bottom: var(--space-8);">
            <h1 class="heading-section">Create New Shop</h1>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: var(--space-6);">
                <?= htmlspecialchars($_SESSION['error']); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="cta-card">
            <form action="/shops/create" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="form-label">Shop Name</label>
                    <input type="text" class="form-input" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-input" id="description" name="description" rows="5" required style="resize: vertical;"></textarea>
                </div>

                <div class="form-group">
                    <label for="contact_email" class="form-label">Contact Email</label>
                    <input type="email" class="form-input" id="contact_email" name="contact_email" required>
                </div>

                <div class="form-group">
                    <label for="contact_number" class="form-label">Contact Phone Number</label>
                    <input type="text" class="form-input" id="contact_number" name="contact_number">
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-input" id="address" name="address" rows="3" style="resize: vertical;"></textarea>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Shop Image</label>
                    <input type="file" class="form-input" id="image" name="image" accept="image/*">
                    <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-2);">Recommended size: 800x600 pixels. Max file size: 2MB.</p>
                </div>

                <div style="display: flex; flex-direction: column; gap: var(--space-3); margin-top: var(--space-6);">
                    <button type="submit" class="btn btn-primary btn-full">Create Shop</button>
                    <a href="/shops/manage" class="btn btn-outline btn-full">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
