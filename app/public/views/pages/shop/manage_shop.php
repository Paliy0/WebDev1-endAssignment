<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Shops</h1>
        <a href="/shops/create" class="btn btn-success">Create New Shop</a>
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

    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert alert-warning">
            <?= $_SESSION['warning']; ?>
            <?php unset($_SESSION['warning']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($shops)): ?>
        <div class="alert alert-info">
            You haven't created any shops yet. <a href="/shops/create" class="alert-link">Create your first shop</a>.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($shops as $shop): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <?php if (!empty($shop['img'])): ?>
                                    <img src="<?= htmlspecialchars($shop['img']) ?>" class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="<?= htmlspecialchars($shop['name']) ?>">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                        <i class="fa fa-store fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($shop['name']) ?></h5>
                                    <p class="card-text text-truncate"><?= htmlspecialchars($shop['description']) ?></p>
                                    <p class="card-text"><small class="text-muted">Created: <?= date('M j, Y', strtotime($shop['created_at'])) ?></small></p>

                                    <div class="btn-group">
                                        <a href="/shops/<?= $shop['shop_id'] ?>" class="btn btn-sm btn-info">View</a>
                                        <a href="/shops/<?= $shop['shop_id'] ?>/edit" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $shop['shop_id'] ?>">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal<?= $shop['shop_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $shop['shop_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel<?= $shop['shop_id'] ?>">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete <strong><?= htmlspecialchars($shop['name']) ?></strong>?</p>
                                    <p class="text-danger">This action cannot be undone. All products associated with this shop will also be deleted.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="/shops/<?= $shop['shop_id'] ?>/delete" method="post">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>