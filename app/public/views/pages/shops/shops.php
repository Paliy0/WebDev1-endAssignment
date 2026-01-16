<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <h1 class="mb-4">All Shops</h1>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($shops)): ?>
        <div class="alert alert-info">
            No shops found.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($shops as $shop): ?>
                <div class="col-md-4 mb-4">
                    <a href="/shops/<?= $shop['shop_id'] ?>" class="card h-100 text-decoration-none text-dark">
                        <?php if (!empty($shop['img'])): ?>
                            <img src="<?= cloudinary_thumbnail($shop['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($shop['name']) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light text-center p-5">
                                <i class="fa fa-store fa-4x text-muted"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($shop['name']) ?></h5>
                            <p class="card-text text-truncate"><?= htmlspecialchars($shop['description']) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>