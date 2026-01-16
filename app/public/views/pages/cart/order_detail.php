<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/orders">My Orders</a></li>
            <li class="breadcrumb-item active">Order #<?= $order['order_id'] ?></li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order #<?= $order['order_id'] ?></h5>
                    <?php
                    $statusClass = match($order['status']) {
                        'confirmed' => 'bg-success',
                        'pending' => 'bg-warning',
                        'cancelled' => 'bg-danger',
                        default => 'bg-secondary'
                    };
                    ?>
                    <span class="badge <?= $statusClass ?>"><?= ucfirst($order['status']) ?></span>
                </div>
                <div class="card-body">
                    <p><strong>Date:</strong> <?= date('F j, Y g:i A', strtotime($order['created_at'])) ?></p>

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
                                            <a href="/products/<?= $item['product_id'] ?>"><?= htmlspecialchars($item['name']) ?></a>
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

            <div class="mt-4">
                <a href="/orders" class="btn btn-outline-secondary">Back to Orders</a>
                <a href="/products" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
