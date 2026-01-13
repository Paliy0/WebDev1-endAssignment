<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <div class="row">
        <div class="col-12">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Order #<?= $orderDetails['order']['order_id'] ?></h1>
                <div>
                    <a href="/orders" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>

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
                                        <?php foreach ($orderDetails['items'] as $item): ?>
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
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$<?= number_format($item['price'], 2) ?></td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td class="text-end pe-4">$<?= number_format($item['subtotal'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Order ID:</span>
                                    <span class="fw-bold">#<?= $orderDetails['order']['order_id'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Date:</span>
                                    <span><?= date('F j, Y, g:i a', strtotime($orderDetails['order']['created_at'])) ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Status:</span>
                                    <span class="badge bg-success"><?= ucfirst($orderDetails['order']['status']) ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>$<?= number_format($orderDetails['order']['total_amount'], 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Total:</strong>
                                <strong>$<?= number_format($orderDetails['order']['total_amount'], 2) ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="/products" class="btn btn-primary">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>