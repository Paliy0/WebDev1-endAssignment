<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Shop</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/shops/<?= $shopId ?>/edit" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Shop Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($shop['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($shop['description']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= htmlspecialchars($shop['contact_email']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Phone Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= htmlspecialchars($shop['contact_number'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?= htmlspecialchars($shop['address'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <?php if (!empty($shop['img'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div>
                                        <img src="<?= htmlspecialchars($shop['img']) ?>" class="img-thumbnail" style="max-height: 200px;" alt="<?= htmlspecialchars($shop['name']) ?>">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <label for="image" class="form-label">Change Shop Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Leave empty to keep current image. Recommended size: 800x600 pixels. Max file size: 2MB.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Shop</button>
                            <a href="/shops/manage" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>