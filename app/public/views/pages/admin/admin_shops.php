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
                <h1 class="heading-section">Manage Shops</h1>
            </div>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('createShopModal').style.display='flex'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
                Create Shop
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
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shops as $shop): ?>
                        <tr>
                            <td style="color: var(--muted-foreground);"><?= htmlspecialchars($shop['shop_id']) ?></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($shop['name']) ?></td>
                            <td style="color: var(--muted-foreground);"><?= htmlspecialchars($shop['owner_email']) ?></td>
                            <td style="color: var(--muted-foreground); font-size: 0.875rem;"><?= date('M j, Y', strtotime($shop['created_at'])) ?></td>
                            <td>
                                <div style="display: flex; gap: var(--space-2);">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="document.getElementById('editModal<?= $shop['shop_id'] ?>').style.display='flex'">Edit</button>
                                    <button type="button" class="btn btn-sm" style="background: var(--accent); color: var(--accent-foreground);" onclick="document.getElementById('deleteModal<?= $shop['shop_id'] ?>').style.display='flex'">Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Create Shop Modal -->
<div id="createShopModal" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4); overflow-y: auto;">
    <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 560px; width: 100%; box-shadow: var(--shadow-elevated); margin: var(--space-8) 0;">
        <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Create New Shop</h3>
            <button type="button" onclick="document.getElementById('createShopModal').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
        </div>
        <form method="post" action="/admin/shops/create">
            <div style="padding: var(--space-6);">
                <div class="form-group">
                    <label for="create_name" class="form-label">Shop Name</label>
                    <input type="text" class="form-input" id="create_name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="create_description" class="form-label">Description</label>
                    <textarea class="form-input" id="create_description" name="description" rows="3" style="resize: vertical;"></textarea>
                </div>
                <div class="form-group">
                    <label for="create_address" class="form-label">Address</label>
                    <input type="text" class="form-input" id="create_address" name="address">
                </div>
                <div class="form-group">
                    <label for="create_contact_email" class="form-label">Contact Email</label>
                    <input type="email" class="form-input" id="create_contact_email" name="contact_email">
                </div>
                <div class="form-group">
                    <label for="create_contact_number" class="form-label">Contact Number</label>
                    <input type="text" class="form-input" id="create_contact_number" name="contact_number">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="create_owner_id" class="form-label">Owner</label>
                    <select class="form-input form-select" id="create_owner_id" name="owner_id" required>
                        <option value="">Select an owner...</option>
                        <?php foreach ($businessUsers as $user): ?>
                            <option value="<?= $user['id'] ?>">
                                <?= htmlspecialchars($user['email']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('createShopModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Shop</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modals -->
<?php foreach ($shops as $shop): ?>
    <div id="editModal<?= $shop['shop_id'] ?>" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4); overflow-y: auto;">
        <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 560px; width: 100%; box-shadow: var(--shadow-elevated); margin: var(--space-8) 0;">
            <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Edit Shop</h3>
                <button type="button" onclick="document.getElementById('editModal<?= $shop['shop_id'] ?>').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <form method="post" action="/admin/shops/edit/<?= $shop['shop_id'] ?>">
                <div style="padding: var(--space-6);">
                    <div class="form-group">
                        <label for="name<?= $shop['shop_id'] ?>" class="form-label">Shop Name</label>
                        <input type="text" class="form-input" id="name<?= $shop['shop_id'] ?>" name="name" value="<?= htmlspecialchars($shop['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description<?= $shop['shop_id'] ?>" class="form-label">Description</label>
                        <textarea class="form-input" id="description<?= $shop['shop_id'] ?>" name="description" rows="3" style="resize: vertical;"><?= htmlspecialchars($shop['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="address<?= $shop['shop_id'] ?>" class="form-label">Address</label>
                        <input type="text" class="form-input" id="address<?= $shop['shop_id'] ?>" name="address" value="<?= htmlspecialchars($shop['address']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact_email<?= $shop['shop_id'] ?>" class="form-label">Contact Email</label>
                        <input type="email" class="form-input" id="contact_email<?= $shop['shop_id'] ?>" name="contact_email" value="<?= htmlspecialchars($shop['contact_email']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact_number<?= $shop['shop_id'] ?>" class="form-label">Contact Number</label>
                        <input type="text" class="form-input" id="contact_number<?= $shop['shop_id'] ?>" name="contact_number" value="<?= htmlspecialchars($shop['contact_number']) ?>">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="owner_id<?= $shop['shop_id'] ?>" class="form-label">Owner</label>
                        <select class="form-input form-select" id="owner_id<?= $shop['shop_id'] ?>" name="owner_id" required>
                            <?php foreach ($businessUsers as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= $shop['owner_id'] == $user['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user['email']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                    <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal<?= $shop['shop_id'] ?>').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Shop</button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<!-- Delete Modals -->
<?php foreach ($shops as $shop): ?>
    <div id="deleteModal<?= $shop['shop_id'] ?>" style="display: none; position: fixed; inset: 0; background: rgba(44, 41, 34, 0.5); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: var(--space-4);">
        <div style="background: var(--card); border-radius: var(--radius-xl); border: 1px solid var(--border); max-width: 400px; width: 100%; box-shadow: var(--shadow-elevated);">
            <div style="padding: var(--space-6); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500;">Confirm Delete</h3>
                <button type="button" onclick="document.getElementById('deleteModal<?= $shop['shop_id'] ?>').style.display='none'" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-full); color: var(--muted-foreground);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <div style="padding: var(--space-6);">
                <p class="body-text" style="margin-bottom: var(--space-3);">Are you sure you want to delete <strong><?= htmlspecialchars($shop['name']) ?></strong>?</p>
                <p style="color: var(--accent); font-size: 0.875rem;">This action cannot be undone. All products associated with this shop will also be deleted.</p>
            </div>
            <div style="padding: var(--space-4) var(--space-6); border-top: 1px solid var(--border); display: flex; gap: var(--space-3); justify-content: flex-end;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('deleteModal<?= $shop['shop_id'] ?>').style.display='none'">Cancel</button>
                <form action="/admin/shops/delete/<?= $shop['shop_id'] ?>" method="post" style="margin: 0;">
                    <button type="submit" class="btn" style="background: var(--accent); color: var(--accent-foreground);">Delete</button>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
