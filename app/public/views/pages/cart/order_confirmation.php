<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container" style="max-width: 800px;">
        <!-- Success Header -->
        <div style="text-align: center; margin-bottom: var(--space-8);">
            <div style="width: 80px; height: 80px; background: #dcfce7; border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-4);">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><path d="m9 11 3 3L22 4"></path></svg>
            </div>
            <h1 class="heading-section" style="margin-bottom: var(--space-3);">Order Confirmed!</h1>
            <p class="body-text text-muted">Thank you for your purchase.</p>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="margin-bottom: var(--space-6); text-align: center;">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="cta-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-4); flex-wrap: wrap; gap: var(--space-3);">
                <h2 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500; margin: 0;">Order #<?= $order['order_id'] ?></h2>
                <span class="badge badge-success" style="font-size: 0.875rem; padding: var(--space-2) var(--space-3);"><?= ucfirst($order['status']) ?></span>
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
                                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                                <td><strong style="font-size: 1.125rem; color: var(--accent);">$<?= number_format($order['total_price'], 2) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: var(--space-6);">
            <a href="/products" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
