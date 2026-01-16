<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <h1 class="mb-4">All Products</h1>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="/products" method="get" class="d-flex" id="search-form">
                <input type="text" name="search" id="product-search" class="form-control me-2" placeholder="Search products..." value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
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

    <div id="products-container">
        <?php if (empty($products)): ?>
            <div class="alert alert-info">
                No products found.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <a href="/products/<?= $product['product_id'] ?>" class="card h-100 text-decoration-none text-dark">
                            <?php if (!empty($product['img'])): ?>
                                <img src="<?= cloudinary_thumbnail($product['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: contain;">
                            <?php else: ?>
                                <div class="bg-light text-center p-5">
                                    <i class="fa fa-image fa-4x text-muted"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <p class="card-text text-truncate"><?= $product['description'] ?></p>
                                <p class="card-text"><strong>$<?= number_format($product['price'], 2) ?></strong></p>
                                <p class="text-muted">Sold by: <?= $product['shop_name'] ?></p>
                            </div>

                            <div class="card-footer">
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="text-success">In Stock</span>
                                <?php else: ?>
                                    <span class="text-secondary">Out of Stock</span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>