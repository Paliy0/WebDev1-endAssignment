<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container" style="max-width: 640px;">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/admin/shops" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Manage Shops
            </a>
        </nav>

        <div style="margin-bottom: var(--space-8);">
            <h1 class="heading-section">Edit Shop</h1>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: var(--space-6);">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="cta-card">
            <form method="post" action="">
                <div class="form-group">
                    <label for="name" class="form-label">Shop Name</label>
                    <input type="text" class="form-input" id="name" name="name" value="<?= htmlspecialchars($shop['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-input" id="description" name="description" rows="3" style="resize: vertical;"><?= htmlspecialchars($shop['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-input" id="address" name="address" value="<?= htmlspecialchars($shop['address']) ?>">
                </div>

                <div class="form-group">
                    <label for="contact_email" class="form-label">Contact Email</label>
                    <input type="email" class="form-input" id="contact_email" name="contact_email" value="<?= htmlspecialchars($shop['contact_email']) ?>">
                </div>

                <div class="form-group">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" class="form-input" id="contact_number" name="contact_number" value="<?= htmlspecialchars($shop['contact_number']) ?>">
                </div>

                <div class="form-group">
                    <label for="owner_id" class="form-label">Owner</label>
                    <select class="form-input form-select" id="owner_id" name="owner_id" required>
                        <?php foreach ($businessUsers as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= $shop['owner_id'] == $user['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['email']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; gap: var(--space-3); margin-top: var(--space-6);">
                    <button type="submit" class="btn btn-primary btn-full">Update Shop</button>
                    <a href="/admin/shops" class="btn btn-outline btn-full">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
