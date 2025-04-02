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

<main class="bg-light min-vh-100 py-4">
    <div class="container">
        <!-- Customer Dashboard Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Customer Dashboard</h1>
            <div>
                <a href="/orders" class="btn btn-outline-primary">
                    <i class="bi bi-box me-1"></i> My Orders
                </a>
                <a href="/wishlist" class="btn btn-outline-primary ms-2">
                    <i class="bi bi-heart me-1"></i> Wishlist
                </a>
                <a href="/cart" class="btn btn-primary ms-2">
                    <i class="bi bi-cart me-1"></i> Cart <span class="badge bg-light text-dark">0</span>
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="search" class="form-control" placeholder="Search products...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>All Categories</option>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                            <option value="home-garden">Home & Garden</option>
                            <option value="books">Books</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>Sort By</option>
                            <option value="newest">Newest</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="popular">Most Popular</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        <h2 class="h4 mb-3">Featured Products</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
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
                <div class="col">
                    <div class="card h-100 product-card shadow-sm">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <div class="mb-2">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <?php if ($i <= floor($product['rating'])) : ?>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    <?php elseif ($i - 0.5 <= $product['rating']) : ?>
                                        <i class="bi bi-star-half text-warning"></i>
                                    <?php else : ?>
                                        <i class="bi bi-star text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <small class="ms-1 text-muted">(<?= $product['rating'] ?>)</small>
                            </div>
                            <p class="card-text text-muted"><?= $product['description'] ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="product-price fw-bold fs-5">$<?= number_format($product['price'], 2) ?></span>
                                <a href="/products/<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                        <div class="card-footer bg-white p-2">
                            <div class="d-flex">
                                <button class="btn btn-outline-primary flex-grow-1 me-2">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                                <button class="btn btn-outline-danger flex-grow-1">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recently Viewed Products -->
        <h2 class="h4 mb-3">Recently Viewed</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
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
                <div class="col">
                    <div class="card h-100 product-card shadow-sm">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <div class="mb-2">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <?php if ($i <= floor($product['rating'])) : ?>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    <?php elseif ($i - 0.5 <= $product['rating']) : ?>
                                        <i class="bi bi-star-half text-warning"></i>
                                    <?php else : ?>
                                        <i class="bi bi-star text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <small class="ms-1 text-muted">(<?= $product['rating'] ?>)</small>
                            </div>
                            <p class="card-text text-muted"><?= $product['description'] ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="product-price fw-bold fs-5">$<?= number_format($product['price'], 2) ?></span>
                                <a href="/products/<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                        <div class="card-footer bg-white p-2">
                            <div class="d-flex">
                                <button class="btn btn-outline-primary flex-grow-1 me-2">
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                                <button class="btn btn-outline-danger flex-grow-1">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recommended Shops -->
        <h2 class="h4 mb-3">Recommended Shops</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
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
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <img src="<?= $shop['logo'] ?>" class="rounded-circle mb-3" width="80" height="80" alt="<?= $shop['name'] ?> Logo">
                            <h5 class="card-title"><?= $shop['name'] ?></h5>
                            <div class="mb-2">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <?php if ($i <= floor($shop['rating'])) : ?>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    <?php elseif ($i - 0.5 <= $shop['rating']) : ?>
                                        <i class="bi bi-star-half text-warning"></i>
                                    <?php else : ?>
                                        <i class="bi bi-star text-warning"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <small class="ms-1 text-muted">(<?= $shop['rating'] ?>)</small>
                            </div>
                            <p class="card-text text-muted"><?= $shop['description'] ?></p>
                            <p class="text-muted"><?= $shop['products_count'] ?> products</p>
                        </div>
                        <div class="card-footer bg-white p-2">
                            <a href="/shops/<?= $shop['id'] ?>" class="btn btn-primary w-100">
                                <i class="bi bi-shop me-1"></i> Visit Shop
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Browse Categories -->
        <h2 class="h4 mb-3">Browse Categories</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
            <?php
            // Sample categories
            $categories = [
                [
                    'id' => 1,
                    'name' => 'Electronics',
                    'icon' => 'bi-laptop',
                    'color' => 'primary',
                    'products_count' => 250
                ],
                [
                    'id' => 2,
                    'name' => 'Fashion',
                    'icon' => 'bi-bag',
                    'color' => 'success',
                    'products_count' => 320
                ],
                [
                    'id' => 3,
                    'name' => 'Home & Garden',
                    'icon' => 'bi-house',
                    'color' => 'danger',
                    'products_count' => 180
                ],
                [
                    'id' => 4,
                    'name' => 'Books',
                    'icon' => 'bi-book',
                    'color' => 'warning',
                    'products_count' => 150
                ]
            ];

            foreach ($categories as $category) : ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm text-center category-card">
                        <div class="card-body p-4">
                            <div class="rounded-circle bg-<?= $category['color'] ?> bg-opacity-10 p-3 d-inline-flex mb-3" style="width: 80px; height: 80px;">
                                <i class="bi <?= $category['icon'] ?> fs-1 text-<?= $category['color'] ?> m-auto"></i>
                            </div>
                            <h3 class="h5 card-title"><?= $category['name'] ?></h3>
                            <p class="card-text text-muted"><?= $category['products_count'] ?> products</p>
                            <a href="/products/category/<?= strtolower(str_replace(' & ', '-', str_replace(' ', '-', $category['name']))) ?>" class="btn btn-outline-primary mt-2">Browse</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Recent Orders -->
        <h2 class="h4 mb-3">Recent Orders</h2>
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Your Orders</h5>
                    <a href="/orders" class="btn btn-outline-primary btn-sm">
                        View All Orders
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">Order #</th>
                                <th scope="col" class="border-0">Date</th>
                                <th scope="col" class="border-0">Items</th>
                                <th scope="col" class="border-0">Total</th>
                                <th scope="col" class="border-0">Status</th>
                                <th scope="col" class="border-0 text-end">Actions</th>
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
                                $statusClass = 'bg-success';
                                if ($order['status'] === 'Shipped') {
                                    $statusClass = 'bg-info';
                                } else if ($order['status'] === 'Processing') {
                                    $statusClass = 'bg-warning';
                                }
                            ?>
                                <tr>
                                    <td class="align-middle">#<?= $order['id'] ?></td>
                                    <td class="align-middle"><?= date('M d, Y', strtotime($order['date'])) ?></td>
                                    <td class="align-middle"><?= $order['items'] ?> item(s)</td>
                                    <td class="align-middle">$<?= number_format($order['total'], 2) ?></td>
                                    <td class="align-middle">
                                        <span class="badge rounded-pill <?= $statusClass ?>"><?= $order['status'] ?></span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <a href="/orders/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary action-btn me-1">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/orders/<?= $order['id'] ?>/track" class="btn btn-sm btn-outline-secondary action-btn">
                                            <i class="bi bi-truck"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>