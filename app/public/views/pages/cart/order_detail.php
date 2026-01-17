<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container" style="max-width: 900px;">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/orders" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to My Orders
            </a>
        </nav>

        <div class="cta-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6); flex-wrap: wrap; gap: var(--space-3);">
                <h1 class="heading-section" style="margin: 0;">Order #<?= $order['order_id'] ?></h1>
                <?php
                $statusClass = match($order['status']) {
                    'confirmed' => 'badge-success',
                    'pending' => 'badge-warning',
                    'cancelled' => 'badge-danger',
                    default => 'badge-primary'
                };
                ?>
                <span class="badge <?= $statusClass ?>" style="font-size: 0.875rem; padding: var(--space-2) var(--space-3);"><?= ucfirst($order['status']) ?></span>
            </div>

            <p class="body-text" style="margin-bottom: var(--space-6);">
                <span style="color: var(--muted-foreground);">Order Date:</span>
                <strong><?= date('F j, Y g:i A', strtotime($order['created_at'])) ?></strong>
            </p>

            <div style="border-top: 1px solid var(--border); padding-top: var(--space-6);">
                <h3 style="font-family: var(--font-sans); font-size: 1rem; font-weight: 600; margin-bottom: var(--space-4);">Items Ordered</h3>

                <div class="table-container">
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
                                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                                            <?php if (!empty($item['img'])): ?>
                                                <img src="<?= cloudinary_thumbnail($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 40px; height: 40px; object-fit: contain; border-radius: var(--radius-sm);">
                                            <?php endif; ?>
                                            <a href="/products/<?= $item['product_id'] ?>" style="color: var(--foreground); text-decoration: none; font-weight: 500;"><?= htmlspecialchars($item['name']) ?></a>
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
                                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                                <td><strong style="font-size: 1.125rem; color: var(--accent);">$<?= number_format($order['total_price'], 2) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: var(--space-3); margin-top: var(--space-6); flex-wrap: wrap;">
            <a href="/orders" class="btn btn-outline">Back to Orders</a>
            <a href="/products" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
