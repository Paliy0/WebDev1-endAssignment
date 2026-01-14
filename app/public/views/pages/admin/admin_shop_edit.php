<?php require(__DIR__ . "/../../partials/header.php"); ?>

<div class="min-vh-100 d-flex flex-column justify-content-center bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="text-center mb-4">
                    <h1 class="h2 text-primary fw-bold">Edit Shop</h1>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?= $_SESSION['error']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="name" class="form-label">Shop Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($shop['name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($shop['description']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($shop['address']) ?>">
                            </div>

                            <div class="mb-3">
                                <label for="contact_email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= htmlspecialchars($shop['contact_email']) ?>">
                            </div>

                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= htmlspecialchars($shop['contact_number']) ?>">
                            </div>

                            <div class="mb-4">
                                <label for="owner_id" class="form-label">Owner</label>
                                <select class="form-select" id="owner_id" name="owner_id" required>
                                    <?php foreach ($businessUsers as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= $shop['owner_id'] == $user['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($user['email']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2">Update Shop</button>
                                <a href="/admin/shops" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>