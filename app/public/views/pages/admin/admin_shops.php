<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Shops</h1>
        <div>
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createShopModal">
                <i class="bi bi-plus-circle"></i> Create Shop
            </button>
            <a href="/admin/dashboard" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shops as $shop): ?>
                        <tr>
                            <td><?= htmlspecialchars($shop['shop_id']) ?></td>
                            <td><?= htmlspecialchars($shop['name']) ?></td>
                            <td><?= htmlspecialchars($shop['owner_email']) ?></td>
                            <td><?= date('M j, Y', strtotime($shop['created_at'])) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $shop['shop_id'] ?>">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $shop['shop_id'] ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Shop Modal -->
    <div class="modal fade" id="createShopModal" tabindex="-1" aria-labelledby="createShopModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createShopModalLabel">Create New Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="/admin/shops/create">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create_name" class="form-label">Shop Name</label>
                            <input type="text" class="form-control" id="create_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_description" class="form-label">Description</label>
                            <textarea class="form-control" id="create_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="create_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="create_address" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="create_contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="create_contact_email" name="contact_email">
                        </div>
                        <div class="mb-3">
                            <label for="create_contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="create_contact_number" name="contact_number">
                        </div>
                        <div class="mb-3">
                            <label for="create_owner_id" class="form-label">Owner</label>
                            <select class="form-select" id="create_owner_id" name="owner_id" required>
                                <option value="">Select an owner...</option>
                                <?php foreach ($businessUsers as $user): ?>
                                    <option value="<?= $user['id'] ?>">
                                        <?= htmlspecialchars($user['email']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Create Shop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    <?php foreach ($shops as $shop): ?>
        <div class="modal fade" id="editModal<?= $shop['shop_id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $shop['shop_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel<?= $shop['shop_id'] ?>">Edit Shop</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="/admin/shops/edit/<?= $shop['shop_id'] ?>">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name<?= $shop['shop_id'] ?>" class="form-label">Shop Name</label>
                                <input type="text" class="form-control" id="name<?= $shop['shop_id'] ?>" name="name" value="<?= htmlspecialchars($shop['name']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description<?= $shop['shop_id'] ?>" class="form-label">Description</label>
                                <textarea class="form-control" id="description<?= $shop['shop_id'] ?>" name="description" rows="3"><?= htmlspecialchars($shop['description']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="address<?= $shop['shop_id'] ?>" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address<?= $shop['shop_id'] ?>" name="address" value="<?= htmlspecialchars($shop['address']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="contact_email<?= $shop['shop_id'] ?>" class="form-label">Contact Email</label>
                                <input type="email" class="form-control" id="contact_email<?= $shop['shop_id'] ?>" name="contact_email" value="<?= htmlspecialchars($shop['contact_email']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="contact_number<?= $shop['shop_id'] ?>" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact_number<?= $shop['shop_id'] ?>" name="contact_number" value="<?= htmlspecialchars($shop['contact_number']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="owner_id<?= $shop['shop_id'] ?>" class="form-label">Owner</label>
                                <select class="form-select" id="owner_id<?= $shop['shop_id'] ?>" name="owner_id" required>
                                    <?php foreach ($businessUsers as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= $shop['owner_id'] == $user['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($user['email']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Shop</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Delete Modals -->
    <?php foreach ($shops as $shop): ?>
        <div class="modal fade" id="deleteModal<?= $shop['shop_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $shop['shop_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel<?= $shop['shop_id'] ?>">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong><?= htmlspecialchars($shop['name']) ?></strong>?</p>
                    <p class="text-danger">This action cannot be undone. All products associated with this shop will also be deleted.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="/admin/shops/delete/<?= $shop['shop_id'] ?>" method="post">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</main>