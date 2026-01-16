<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
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

    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($product['img'])): ?>
                <img src="<?= cloudinary_thumbnail($product['img'], false) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($product['name']) ?>">
            <?php else: ?>
                <div class="bg-light text-center p-5 rounded">
                    <i class="fa fa-image fa-5x text-muted"></i>
                    <p class="mt-3">No image available</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p class="text-muted">Sold by: <a href="/shops/<?= $product['store_id'] ?>"><?= htmlspecialchars($product['shop_name']) ?></a></p>

            <div class="mb-3">
                <h3>$<?= number_format($product['price'], 2) ?></h3>

                <?php if ($product['stock'] > 0): ?>
                    <span class="badge bg-success">In Stock (<?= $product['stock'] ?> available)</span>
                <?php else: ?>
                    <span class="badge bg-danger">Out of Stock</span>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <h4>Description</h4>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>

            <?php if ($product['stock'] > 0): ?>
                <form action="/cart/add" method="post" class="mb-3">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                        <button type="submit" class="btn btn-success">Add to Cart</button>
                    </div>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg disabled">Out of Stock</button>
            <?php endif; ?>

            <div class="mt-4">
                <a href="/products" class="btn btn-outline-primary">&laquo; Back to Products</a>
                <a href="/shops/<?= $product['store_id'] ?>" class="btn btn-outline-secondary">More from this Shop</a>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>