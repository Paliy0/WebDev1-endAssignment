<?php require(__DIR__ . "../partials/header.php"); ?>

<main class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Your Shopping Cart</h1>

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

            <?php if (empty($cartItems)): ?>
                <div class="alert alert-info">
                    Your cart is empty. <a href="/products" class="alert-link">Continue shopping</a>.
                </div>
            <?php else: ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3" style="width: 70px; height: 70px;">
                                                        <?php if (!empty($item['img'])): ?>
                                                            <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="img-fluid rounded">
                                                        <?php else: ?>
                                                            <div class="bg-light d-flex align-items-center justify-content-center rounded h-100">
                                                                <i class="bi bi-image text-secondary"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1"><a href="/products/<?= $item['product_id'] ?>" class="text-decoration-none"><?= htmlspecialchars($item['name']) ?></a></h5>
                                                        <p class="text-muted small mb-0">
                                                            <?php if (isset($item['shop_name'])): ?>
                                                                Sold by: <a href="/shops/<?= $item['shop_id'] ?>"><?= htmlspecialchars($item['shop_name']) ?></a>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>$<?= number_format($item['price'], 2) ?></td>
                                            <td>
                                                <form action="/cart/update" method="post" class="d-flex align-items-center" style="max-width: 150px;">
                                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                    <div class="input-group input-group-sm">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity(this)">-</button>
                                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-control text-center quantity-input" onchange="this.form.submit()">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="incrementQuantity(this, <?= $item['stock'] ?>)">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                            <td class="text-end pe-4">
                                                <form action="/cart/remove" method="post" class="d-inline">
                                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to remove this item?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 ms-auto">
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
                                <div class="d-grid gap-2">
                                    <a href="/checkout" class="btn btn-primary">
                                        Proceed to Checkout
                                        <a href="/checkout" class="btn btn-primary">
                                            Proceed to Checkout
                                        </a>
                                        <a href="/products" class="btn btn-outline-secondary">
                                            Continue Shopping
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

<script>
    function incrementQuantity(button, maxStock) {
        const input = button.parentElement.querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
            input.form.submit();
        }
    }

    function decrementQuantity(button) {
        const input = button.parentElement.querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            input.form.submit();
        }
    }
</script>

<?php require(__DIR__ . "/../partials/footer.php"); ?>