<main class="main">
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <p class="overline">Welcome to PHP Shop</p>
                    <h1 class="heading-hero">
                        Discover products<br>
                        <em>you'll love</em>
                    </h1>
                    <p class="body-text hero-description">
                        Explore PHP Shop collections from independent shops. Quality goods, unique finds, delivered to your door.
                    </p>
                    <div class="hero-buttons">
                        <a href="/products" class="btn btn-primary btn-lg">
                            Explore Collection
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="/shops" class="btn btn-outline btn-lg">View Shops</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<section class="section" style="padding-top: 0; padding-bottom: var(--space-16);">
    <div class="container">
        <div class="section-header">
            <div>
                <p class="overline">Our collection</p>
                <h2 class="heading-section">Featured Products</h2>
            </div>
            <a href="/products" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="product-grid">
            <?php if (empty($featuredProducts)): ?>
                <p class="body-text" style="grid-column: 1 / -1; text-align: center; color: var(--muted-foreground);">No products available yet.</p>
            <?php else: ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <a href="/products/<?= htmlspecialchars($product['product_id']) ?>" class="product-card">
                        <div class="product-image-container">
                            <img src="<?= !empty($product['img']) ? htmlspecialchars($product['img']) : 'https://placehold.co/400x400?text=No+Image' ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                            <div class="quick-add-overlay">
                                <span class="btn btn-primary btn-sm btn-full">View Product</span>
                            </div>
                        </div>
                        <div class="product-info">
                            <p class="product-shop"><?= htmlspecialchars($product['shop_name'] ?? 'Shop') ?></p>
                            <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="product-price">$<?= number_format($product['price'], 2) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top: 0; padding-bottom: var(--space-16);">
    <div class="container">
        <div class="section-header">
            <div>
                <p class="overline">Featured stores</p>
                <h2 class="heading-section">Top Shops</h2>
            </div>
            <a href="/shops" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="shop-grid">
            <?php if (empty($topShops)): ?>
                <p class="body-text" style="grid-column: 1 / -1; text-align: center; color: var(--muted-foreground);">No shops available yet.</p>
            <?php else: ?>
                <?php foreach ($topShops as $shop): ?>
                    <a href="/shops/<?= htmlspecialchars($shop['shop_id']) ?>" class="shop-card">
                        <div class="shop-avatar">
                            <img src="<?= !empty($shop['img']) ? htmlspecialchars($shop['img']) : 'https://placehold.co/100x100?text=' . urlencode(substr($shop['name'], 0, 1)) ?>" alt="<?= htmlspecialchars($shop['name']) ?>">
                        </div>
                        <h3 class="shop-name"><?= htmlspecialchars($shop['name']) ?></h3>
                        <p class="shop-products-count"><?= htmlspecialchars($shop['description'] ?? '') ?></p>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top: 0; padding-bottom: var(--space-16);">
    <div class="container">
        <div style="display: grid; gap: var(--space-6);">
            <div class="cta-card cta-card-primary">
                <div style="display: flex; flex-direction: column; gap: var(--space-4); align-items: flex-start;">
                    <div>
                        <h2 class="cta-card-title">For Shop Owners</h2>
                        <p class="cta-card-text">Start selling your products online today. Create your shop and reach customers around the world.</p>
                    </div>
                    <a href="/register" class="btn" style="background: var(--background); color: var(--foreground);">
                        Get Started
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="cta-card">
                <div style="display: flex; flex-direction: column; gap: var(--space-4); align-items: flex-start;">
                    <div>
                        <h2 class="cta-card-title">For Customers</h2>
                        <p class="cta-card-text">Find unique products from various sellers. Create an account to track orders and save favorites.</p>
                    </div>
                    <a href="/register" class="btn btn-primary">
                        Sign Up Now
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>