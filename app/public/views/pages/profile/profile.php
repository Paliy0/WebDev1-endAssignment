<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3>Account Settings</h3>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> <?= $user['email']; ?></p>
                    <p><strong>Account Type:</strong> <?= ucfirst($user['role']); ?></p>
                    <div class="mb-3">
                        <a href="/profile/edit" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-md-6">
            <?php if ($user['role'] === 'business'): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>My Shops</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($shops)): ?>
                            <p>You currently have no shops.</p>
                        <?php else: ?>
                            <div class="list-group">
                                <?php foreach ($shops as $shop): ?>
                                    <a href="/shops/<?= $shop['shop_id']; ?>" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?= $shop['name']; ?></h5>
                                        </div>
                                        <p class="mb-1"><?= $shop['description']; ?></p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mt-3">
                            <a href="/shops/create" class="btn btn-primary">Create a Shop</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>