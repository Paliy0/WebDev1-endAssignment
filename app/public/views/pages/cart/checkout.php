<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/cart" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Cart
            </a>
        </nav>

        <h1 class="heading-section" style="margin-bottom: var(--space-8);">Checkout</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: var(--space-6);">
                <?= htmlspecialchars($_SESSION['error']); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; gap: var(--space-8); grid-template-columns: 2fr 1fr;" class="checkout-grid">
            <div class="cta-card">
                <h2 style="font-family: var(--font-serif); font-size: 1.25rem; margin-bottom: var(--space-6);">Order Summary</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: right;">Price</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $item): ?>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                                            <?php if (!empty($item['img'])): ?>
                                                <img src="<?= cloudinary_thumbnail($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--radius-md); background: var(--secondary);">
                                            <?php endif; ?>
                                            <span style="font-weight: 500;"><?= htmlspecialchars($item['name']) ?></span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;"><?= $item['quantity'] ?></td>
                                    <td style="text-align: right;">$<?= number_format($item['price'], 2) ?></td>
                                    <td style="text-align: right;">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: 600; border-bottom: none;">Total:</td>
                                <td style="text-align: right; font-weight: 600; font-size: 1.125rem; color: var(--accent); border-bottom: none;">$<?= number_format($total, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="cta-card">
                <h2 style="font-family: var(--font-serif); font-size: 1.25rem; margin-bottom: var(--space-6);">Complete Order</h2>
                <div style="margin-bottom: var(--space-4);">
                    <p class="body-text"><strong>Account:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p class="body-text" style="font-size: 1.5rem; font-weight: 600; margin-top: var(--space-3);"><strong>Total:</strong> $<?= number_format($total, 2) ?></p>
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: var(--space-6); margin-top: var(--space-6);">
                    <form action="/checkout" method="post">
                        <button type="submit" class="btn btn-primary btn-lg btn-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"></path></svg>
                            Place Order
                        </button>
                    </form>

                    <a href="/cart" class="btn btn-outline btn-full" style="margin-top: var(--space-3);">Back to Cart</a>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
@media (max-width: 768px) {
    .checkout-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
