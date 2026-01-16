<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <h1 class="mb-4">Checkout</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['img'])): ?>
                                                <img src="<?= cloudinary_thumbnail($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 50px; height: 50px; object-fit: contain;" class="me-2">
                                            <?php endif; ?>
                                            <?= htmlspecialchars($item['name']) ?>
                                        </div>
                                    </td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>$<?= number_format($total, 2) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Complete Order</h5>
                </div>
                <div class="card-body">
                    <p><strong>Account:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Total:</strong> $<?= number_format($total, 2) ?></p>

                    <hr>

                    <form action="/checkout" method="post">
                        <button type="submit" class="btn btn-success btn-lg w-100">Place Order</button>
                    </form>

                    <a href="/cart" class="btn btn-outline-secondary w-100 mt-2">Back to Cart</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
