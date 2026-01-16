<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <div class="text-center mb-4">
        <i class="fa fa-check-circle text-success" style="font-size: 5rem;"></i>
        <h1 class="mt-3">Order Confirmed!</h1>
        <p class="lead">Thank you for your purchase.</p>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order #<?= $order['order_id'] ?></h5>
                </div>
                <div class="card-body">
                    <p><strong>Date:</strong> <?= date('F j, Y g:i A', strtotime($order['created_at'])) ?></p>
                    <p><strong>Status:</strong> <span class="badge bg-success"><?= ucfirst($order['status']) ?></span></p>

                    <hr>

                    <h6>Items Ordered:</h6>
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
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['img'])): ?>
                                                <img src="<?= cloudinary_thumbnail($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 40px; height: 40px; object-fit: contain;" class="me-2">
                                            <?php endif; ?>
                                            <?= htmlspecialchars($item['name']) ?>
                                        </div>
                                    </td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>$<?= number_format($order['total_price'], 2) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/products" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
