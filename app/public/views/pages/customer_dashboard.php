<?php
require(__DIR__ . "/../partials/header.php");

// Check if user is logged in and is a customer
require_once(__DIR__ . "/../../controllers/AuthController.php");
$authController = new AuthController();

if (!$authController->isLoggedIn() || !$authController->hasRole('customer')) {
    $_SESSION['error'] = "You must be logged in as a customer to access this page.";
    header('Location: /login');
    exit;
}

$currentUser = $authController->getCurrentUser();
?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <!-- Customer Dashboard Header -->
        <div class="section-header" style="margin-bottom: var(--space-8);">
            <div>
                <h1 class="heading-section">Customer Dashboard</h1>
            </div>
            <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
                <a href="/orders" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"></path><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
                    My Orders
                </a>
                <a href="/cart" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                    Cart
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="cta-card" style="margin-bottom: var(--space-8);">
            <div style="display: grid; grid-template-columns: 1fr; gap: var(--space-4);">
                <div class="form-group" style="margin-bottom: 0;">
                    <div style="position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: var(--space-3); top: 50%; transform: translateY(-50%); color: var(--muted-foreground);"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        <input type="search" class="form-input" placeholder="Search products..." style="padding-left: var(--space-10);">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-4);">
                    <select class="form-input form-select">
                        <option selected>All Categories</option>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="home-garden">Home & Garden</option>
                        <option value="books">Books</option>
                    </select>
                    <select class="form-input form-select">
                        <option selected>Sort By</option>
                        <option value="newest">Newest</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        <div style="margin-bottom: var(--space-12);">
            <h2 class="heading-section" style="margin-bottom: var(--space-6);">Featured Products</h2>
            <div class="product-grid">
                <?php
                // Sample product data - In a real application, this would come from your database
                $featuredProducts = [
                    [
                        'id' => 1,
                        'name' => 'Wireless Earbuds',
                        'price' => 49.99,
                        'description' => 'Premium wireless earbuds with noise cancellation',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.5
                    ],
                    [
                        'id' => 2,
                        'name' => 'Smart Watch',
                        'price' => 129.99,
                        'description' => 'Fitness tracker with heart rate monitoring',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.2
                    ],
                    [
                        'id' => 3,
                        'name' => 'Laptop Backpack',
                        'price' => 39.99,
                        'description' => 'Water-resistant backpack with USB charging port',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.7
                    ],
                    [
                        'id' => 4,
                        'name' => 'Bluetooth Speaker',
                        'price' => 79.99,
                        'description' => 'Portable speaker with 24-hour battery life',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.0
                    ]
                ];

                foreach ($featuredProducts as $product) : ?>
                    <a href="/products/<?= $product['id'] ?>" class="product-card" style="text-decoration: none;">
                        <div class="product-image-container">
                            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                        </div>
                        <div class="product-info">
                            <p class="product-name"><?= $product['name'] ?></p>
                            <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-1); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= $product['description'] ?></p>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: var(--space-2);">
                                <p class="product-price">$<?= number_format($product['price'], 2) ?></p>
                                <span class="badge badge-primary"><?= $product['rating'] ?> / 5</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recently Viewed Products -->
        <div style="margin-bottom: var(--space-12);">
            <h2 class="heading-section" style="margin-bottom: var(--space-6);">Recently Viewed</h2>
            <div class="product-grid">
                <?php
                // Sample recently viewed products
                $recentlyViewed = [
                    [
                        'id' => 5,
                        'name' => 'Desk Lamp',
                        'price' => 34.99,
                        'description' => 'LED desk lamp with adjustable brightness',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.3
                    ],
                    [
                        'id' => 6,
                        'name' => 'Coffee Mug',
                        'price' => 14.99,
                        'description' => 'Ceramic mug with unique design',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.8
                    ],
                    [
                        'id' => 7,
                        'name' => 'Wireless Mouse',
                        'price' => 29.99,
                        'description' => 'Ergonomic wireless mouse with long battery life',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.1
                    ],
                    [
                        'id' => 8,
                        'name' => 'Phone Stand',
                        'price' => 19.99,
                        'description' => 'Adjustable phone stand for desk or bedside',
                        'image' => 'https://via.placeholder.com/300x200',
                        'rating' => 4.6
                    ]
                ];

                foreach ($recentlyViewed as $product) : ?>
                    <a href="/products/<?= $product['id'] ?>" class="product-card" style="text-decoration: none;">
                        <div class="product-image-container">
                            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                        </div>
                        <div class="product-info">
                            <p class="product-name"><?= $product['name'] ?></p>
                            <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-1); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= $product['description'] ?></p>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: var(--space-2);">
                                <p class="product-price">$<?= number_format($product['price'], 2) ?></p>
                                <span class="badge badge-primary"><?= $product['rating'] ?> / 5</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recommended Shops -->
        <div style="margin-bottom: var(--space-12);">
            <h2 class="heading-section" style="margin-bottom: var(--space-6);">Recommended Shops</h2>
            <div class="shop-grid">
                <?php
                // Sample recommended shops
                $recommendedShops = [
                    [
                        'id' => 1,
                        'name' => 'TechGadgets',
                        'logo' => 'https://via.placeholder.com/100',
                        'description' => 'Electronics and gadgets store',
                        'products_count' => 48,
                        'rating' => 4.8
                    ],
                    [
                        'id' => 2,
                        'name' => 'Fashion Hub',
                        'logo' => 'https://via.placeholder.com/100',
                        'description' => 'Trendy fashion and accessories',
                        'products_count' => 76,
                        'rating' => 4.6
                    ],
                    [
                        'id' => 3,
                        'name' => 'Home & Garden',
                        'logo' => 'https://via.placeholder.com/100',
                        'description' => 'Everything for your home',
                        'products_count' => 112,
                        'rating' => 4.5
                    ],
                    [
                        'id' => 4,
                        'name' => 'Book Corner',
                        'logo' => 'https://via.placeholder.com/100',
                        'description' => 'Books for all interests',
                        'products_count' => 83,
                        'rating' => 4.9
                    ]
                ];

                foreach ($recommendedShops as $shop) : ?>
                    <a href="/shops/<?= $shop['id'] ?>" class="shop-card" style="text-decoration: none;">
                        <div class="shop-avatar">
                            <img src="<?= $shop['logo'] ?>" alt="<?= $shop['name'] ?> Logo">
                        </div>
                        <h3 class="shop-name"><?= $shop['name'] ?></h3>
                        <p class="shop-products-count"><?= $shop['products_count'] ?> products</p>
                        <p style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: var(--space-1);"><?= $shop['description'] ?></p>
                        <span class="badge badge-primary" style="margin-top: var(--space-2);"><?= $shop['rating'] ?> / 5</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Browse Categories -->
        <div style="margin-bottom: var(--space-12);">
            <h2 class="heading-section" style="margin-bottom: var(--space-6);">Browse Categories</h2>
            <div class="category-grid">
                <?php
                // Sample categories
                $categories = [
                    [
                        'id' => 1,
                        'name' => 'Electronics',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="12" x="3" y="4" rx="2" ry="2"></rect><line x1="2" x2="22" y1="20" y2="20"></line></svg>',
                        'products_count' => 250
                    ],
                    [
                        'id' => 2,
                        'name' => 'Fashion',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>',
                        'products_count' => 320
                    ],
                    [
                        'id' => 3,
                        'name' => 'Home & Garden',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
                        'products_count' => 180
                    ],
                    [
                        'id' => 4,
                        'name' => 'Books',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path></svg>',
                        'products_count' => 150
                    ]
                ];

                foreach ($categories as $category) : ?>
                    <a href="/products/category/<?= strtolower(str_replace(' & ', '-', str_replace(' ', '-', $category['name']))) ?>" class="category-card" style="text-decoration: none;">
                        <div class="category-icon">
                            <?= $category['icon'] ?>
                        </div>
                        <h3 class="category-name"><?= $category['name'] ?></h3>
                        <p class="category-count"><?= $category['products_count'] ?> products</p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Orders -->
        <div>
            <div class="section-header" style="margin-bottom: var(--space-6);">
                <h2 class="heading-section" style="margin: 0;">Recent Orders</h2>
                <a href="/orders" class="btn btn-outline btn-sm">View All Orders</a>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Sample orders data
                        $orders = [
                            [
                                'id' => '1001',
                                'date' => '2023-12-05',
                                'items' => 3,
                                'total' => 129.99,
                                'status' => 'Delivered'
                            ],
                            [
                                'id' => '1002',
                                'date' => '2023-12-10',
                                'items' => 1,
                                'total' => 49.99,
                                'status' => 'Shipped'
                            ],
                            [
                                'id' => '1003',
                                'date' => '2023-12-15',
                                'items' => 2,
                                'total' => 89.99,
                                'status' => 'Processing'
                            ]
                        ];

                        foreach ($orders as $order) :
                            $statusClass = match($order['status']) {
                                'Delivered' => 'badge-success',
                                'Shipped' => 'badge-primary',
                                'Processing' => 'badge-warning',
                                default => 'badge-secondary'
                            };
                        ?>
                            <tr>
                                <td style="font-weight: 500;">#<?= $order['id'] ?></td>
                                <td style="color: var(--muted-foreground);"><?= date('M d, Y', strtotime($order['date'])) ?></td>
                                <td><?= $order['items'] ?> item(s)</td>
                                <td style="font-weight: 500;">$<?= number_format($order['total'], 2) ?></td>
                                <td><span class="badge <?= $statusClass ?>"><?= $order['status'] ?></span></td>
                                <td>
                                    <a href="/orders/<?= $order['id'] ?>" class="btn btn-sm btn-outline">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>
