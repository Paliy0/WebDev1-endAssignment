<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/products" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Continue Shopping
            </a>
        </nav>

        <h1 class="heading-section" style="margin-bottom: var(--space-8);">Shopping Cart</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="margin-bottom: var(--space-6);">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: var(--space-6);">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="cta-card" style="text-align: center; padding: var(--space-16);">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto var(--space-4); color: var(--muted-foreground);"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                <p class="body-text text-muted" style="margin-bottom: var(--space-4);">Your cart is empty.</p>
                <a href="/products" class="btn btn-primary">Browse Products</a>
            </div>
        <?php else: ?>
            <div class="table-container" style="margin-bottom: var(--space-8);">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: var(--space-3);">
                                        <?php if (!empty($item['img'])): ?>
                                            <img src="<?= cloudinary_thumbnail($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 60px; height: 60px; object-fit: contain; border-radius: var(--radius-md); background: var(--secondary);">
                                        <?php endif; ?>
                                        <div>
                                            <a href="/products/<?= $item['product_id'] ?>" style="font-weight: 500; color: var(--foreground);"><?= htmlspecialchars($item['name']) ?></a>
                                        </div>
                                    </div>
                                </td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <form action="/cart/update" method="post" style="display: flex; align-items: center; gap: var(--space-2);">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-input" style="width: 70px;">
                                        <button type="submit" class="btn btn-outline btn-sm">Update</button>
                                    </form>
                                </td>
                                <td style="font-weight: 500;">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                <td>
                                    <form action="/cart/remove" method="post" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <button type="submit" class="btn btn-sm" style="background: var(--accent); color: white;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: 600;">Total:</td>
                            <td style="font-weight: 600; font-size: 1.25rem;">$<?= number_format($total, 2) ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: var(--space-4);">
                <form action="/cart/clear" method="post">
                    <button type="submit" class="btn btn-outline">Clear Cart</button>
                </form>
                <div style="display: flex; gap: var(--space-3);">
                    <a href="/products" class="btn btn-outline">Continue Shopping</a>
                    <a href="/checkout" class="btn btn-primary">
                        Proceed to Checkout
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
