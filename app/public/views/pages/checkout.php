<?php require(__DIR__ . "/../partials/header.php"); ?>

<main class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Checkout</h1>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($cartItems)): ?>
                <div class="alert alert-info">
                    Your cart is empty. <a href="/products" class="alert-link">Continue shopping</a>.
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Order Items</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th class="ps-4">Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th class="text-end pe-4">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cartItems as $item): ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3" style="width: 60px; height: 60px;">
                                                                <?php if (!empty($item['img'])): ?>
                                                                    <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-fluid rounded">
                                                                <?php else: ?>
                                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded h-100">
                                                                        <i class="bi bi-image text-secondary"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0"><?= htmlspecialchars($item['name']) ?></h5>
                                                                <small class="text-muted">
                                                                    <?php if (isset($item['shop_name'])): ?>
                                                                        Sold by: <?= htmlspecialchars($item['shop_name']) ?>
                                                                    <?php endif; ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                                    <td><?= $item['quantity'] ?></td>
                                                    <td class="text-end pe-4">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Shipping Address</h5>
                            </div>
                            <div class="card-body">
                                <p>For demo purposes, no address is required. Orders will be processed instantly.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Items (<?= $cartSummary['total_items'] ?>):</span>
                                    <span>$<?= number_format($cartSummary['total_amount'], 2) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>Free</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong>$<?= number_format($cartSummary['total_amount'], 2) ?></strong>
                                </div>
                                <form action="/checkout/process" method="post">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            Place Order
                                        </button>
                                    </div>
                                </form>
                                <div class="mt-3">
                                    <a href="/cart" class="text-decoration-none">
                                        <i class="bi bi-arrow-left"></i> Return to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>