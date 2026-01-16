<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <h1 class="mb-4">My Orders</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">
            You haven't placed any orders yet. <a href="/products">Browse products</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= $order['order_id'] ?></td>
                            <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                            <td>$<?= number_format($order['total_price'], 2) ?></td>
                            <td>
                                <?php
                                $statusClass = match($order['status']) {
                                    'confirmed' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= ucfirst($order['status']) ?></span>
                            </td>
                            <td>
                                <a href="/orders/<?= $order['order_id'] ?>" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
