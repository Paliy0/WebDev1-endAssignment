<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/admin/dashboard" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Dashboard
            </a>
        </nav>

        <div class="section-header" style="margin-bottom: var(--space-8);">
            <div>
                <h1 class="heading-section">Manage Users</h1>
            </div>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('createUserModal').style.display='flex'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
                Create User
            </button>
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

        <div class="table-container">
            <table class="table">
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
                            <td style="color: var(--muted-foreground);"><?= htmlspecialchars($user['id']) ?></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <?php
                                $badgeClass = match($user['role']) {
                                    'admin' => 'badge-danger',
                                    'business' => 'badge-primary',
                                    default => 'badge-secondary'
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= ucfirst(htmlspecialchars($user['role'])) ?></span>
                            </td>
                            <td style="color: var(--muted-foreground); font-size: 0.875rem;"><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <?php if ($user['role'] !== 'admin'): ?>
                                    <div style="display: flex; gap: var(--space-2);">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="document.getElementById('editModal<?= $user['id'] ?>').style.display='flex'">Edit</button>
                                        <button type="button" class="btn btn-sm" style="background: var(--accent); color: var(--accent-foreground);" onclick="document.getElementById('deleteModal<?= $user['id'] ?>').style.display='flex'">Delete</button>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Create User Modal -->
<div id="createUserModal" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4);">
    <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 480px; width: 100%; box-shadow: var(--shadow-elevated);">
        <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Create New User</h3>
            <button type="button" onclick="document.getElementById('createUserModal').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
        </div>
        <form method="post" action="/admin/users/create">
            <div style="padding: var(--space-6);">
                <div class="form-group">
                    <label for="create_email" class="form-label">Email address</label>
                    <input type="email" class="form-input" id="create_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="create_password" class="form-label">Password</label>
                    <input type="password" class="form-input" id="create_password" name="password" minlength="8" required>
                    <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-2);">Minimum 8 characters</p>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="create_role" class="form-label">Role</label>
                    <select class="form-input form-select" id="create_role" name="role" required>
                        <option value="">Select a role...</option>
                        <option value="customer">Customer</option>
                        <option value="business">Business</option>
                    </select>
                </div>
            </div>
            <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('createUserModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-primary">Create User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modals -->
<?php foreach ($users as $user): ?>
    <?php if ($user['role'] !== 'admin'): ?>
        <div id="editModal<?= $user['id'] ?>" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4);">
            <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 480px; width: 100%; box-shadow: var(--shadow-elevated);">
                <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Edit User</h3>
                    <button type="button" onclick="document.getElementById('editModal<?= $user['id'] ?>').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                    </button>
                </div>
                <form method="post" action="/admin/users/edit/<?= $user['id'] ?>">
                    <div style="padding: var(--space-6);">
                        <div class="form-group">
                            <label for="email<?= $user['id'] ?>" class="form-label">Email address</label>
                            <input type="email" class="form-input" id="email<?= $user['id'] ?>" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="role<?= $user['id'] ?>" class="form-label">Role</label>
                            <select class="form-input form-select" id="role<?= $user['id'] ?>" name="role" required>
                                <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                                <option value="business" <?= $user['role'] === 'business' ? 'selected' : '' ?>>Business</option>
                            </select>
                        </div>
                    </div>
                    <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                        <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal<?= $user['id'] ?>').style.display='none'">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<!-- Delete Modals -->
<?php foreach ($users as $user): ?>
    <?php if ($user['role'] !== 'admin'): ?>
        <div id="deleteModal<?= $user['id'] ?>" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4);">
            <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 400px; width: 100%; box-shadow: var(--shadow-elevated);">
                <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Confirm Delete</h3>
                    <button type="button" onclick="document.getElementById('deleteModal<?= $user['id'] ?>').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                    </button>
                </div>
                <div style="padding: var(--space-6);">
                    <p class="body-text" style="margin-bottom: var(--space-3);">Are you sure you want to delete <strong><?= htmlspecialchars($user['email']) ?></strong>?</p>
                    <p style="color: var(--accent); font-size: 0.875rem;">This action cannot be undone.</p>
                </div>
                <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                    <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal<?= $user['id'] ?>').style.display='none'">Cancel</button>
                    <form action="/admin/users/delete/<?= $user['id'] ?>" method="post" style="margin: 0;">
                        <button type="submit" class="btn" style="background: var(--accent); color: var(--accent-foreground);">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
