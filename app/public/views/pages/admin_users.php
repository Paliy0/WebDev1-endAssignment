<?php require(__DIR__ . "/../partials/header.php"); ?>

<main class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Users</h1>
        <div>
            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="bi bi-plus-circle"></i> Create User
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
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'business' ? 'primary' : 'secondary') ?>">
                                    <?= ucfirst(htmlspecialchars($user['role'])) ?>
                                </span>
                            </td>
                            <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <?php if ($user['role'] !== 'admin'): ?>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['id'] ?>">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id'] ?>">Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="/admin/users/create">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create_email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="create_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="create_password" name="password" minlength="8" required>
                            <div class="form-text">Minimum 8 characters</div>
                        </div>
                        <div class="mb-3">
                            <label for="create_role" class="form-label">Role</label>
                            <select class="form-select" id="create_role" name="role" required>
                                <option value="">Select a role...</option>
                                <option value="customer">Customer</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    <?php foreach ($users as $user): ?>
        <?php if ($user['role'] !== 'admin'): ?>
            <div class="modal fade" id="editModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $user['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel<?= $user['id'] ?>">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="/admin/users/edit/<?= $user['id'] ?>">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="email<?= $user['id'] ?>" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email<?= $user['id'] ?>" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role<?= $user['id'] ?>" class="form-label">Role</label>
                                    <select class="form-select" id="role<?= $user['id'] ?>" name="role" required>
                                        <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                                        <option value="business" <?= $user['role'] === 'business' ? 'selected' : '' ?>>Business</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Delete Modals -->
    <?php foreach ($users as $user): ?>
        <?php if ($user['role'] !== 'admin'): ?>
            <div class="modal fade" id="deleteModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel<?= $user['id'] ?>">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete <strong><?= htmlspecialchars($user['email']) ?></strong>?</p>
                            <p class="text-danger">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="/admin/users/delete/<?= $user['id'] ?>" method="post">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</main>