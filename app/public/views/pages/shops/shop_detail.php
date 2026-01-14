<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <?php if (!empty($shop['img'])): ?>
                <img src="<?= cloudinary_thumbnail($shop['img'], false) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($shop['name']) ?>">
            <?php else: ?>
                <div class="bg-light text-center p-5 rounded">
                    <i class="fa fa-store fa-5x text-muted"></i>
                    <p class="mt-3">No image available</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-8">
            <h1><?= htmlspecialchars($shop['name']) ?></h1>
            <p class="lead"><?= nl2br(htmlspecialchars($shop['description'])) ?></p>
            
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> <?= htmlspecialchars($shop['contact_email']) ?></p>
                    
                    <?php if (!empty($shop['contact_number'])): ?>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($shop['contact_number']) ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($shop['address'])): ?>
                        <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($shop['address'])) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <h2 class="mb-4">Products</h2>
    
    <?php if (empty($products)): ?>
        <div class="alert alert-info">
            This shop doesn't have any products yet.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($product['img'])): ?>
                            <img src="<?= cloudinary_thumbnail($product['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 180px; object-fit: contain;">
                        <?php else: ?>
                            <div class="bg-light text-center p-4">
                                <i class="fa fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-truncate"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text"><strong>$<?= number_format($product['price'], 2) ?></strong></p>
                        </div>
                        
                        <div class="card-footer d-flex justify-content-between">
                            <a href="/products/<?= $product['product_id'] ?>" class="btn btn-sm btn-primary">View Details</a>
                            
                            <?php if ($product['stock'] > 0): ?>
                                <form action="/cart/add" method="post">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-success">Add to Cart</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled>Out of Stock</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="mt-4">
        <a href="/shops" class="btn btn-outline-primary">&laquo; Back to Shops</a>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>