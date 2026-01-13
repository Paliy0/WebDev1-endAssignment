<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container py-5">
    <!-- Shop Hero Section -->
    <div class="position-relative mb-5">
        <div class="rounded overflow-hidden" style="max-height: 300px;">
            <?php if (!empty($shop['img'])): ?>
                <img src="<?= htmlspecialchars($shop['img']) ?>" class="img-fluid w-100 object-fit-cover" style="height: 300px;" alt="<?= htmlspecialchars($shop['name']) ?>">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="fa fa-store fa-5x text-muted"></i>
                </div>
            <?php endif; ?>
            <div class="position-absolute bottom-0 start-0 end-0 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <h1 class="text-white fw-bold mb-2"><?= htmlspecialchars($shop['name']) ?></h1>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark">Shop</span>
                            <span class="text-white">•</span>
                            <span class="text-white small"><?= date('F Y', strtotime($shop['created_at'] ?? 'now')) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Content Tabs -->
    <div class="row">
        <div class="col-12 mb-4">
            <ul class="nav nav-tabs" id="shopTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true">About</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="false">Products</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="shopTabsContent">
        <!-- About Tab -->
        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-3">About This Shop</h3>
                    <p class="card-text mb-4"><?= nl2br(htmlspecialchars($shop['description'])) ?></p>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Shop Information</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <span class="fw-semibold me-2">Owner:</span>
                                    <span><?= htmlspecialchars($shop['owner_email'] ?? 'Not available') ?></span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-semibold me-2">Established:</span>
                                    <span><?= date('F Y', strtotime($shop['created_at'] ?? 'now')) ?></span>
                                </li>
                            </ul>
                        </div>

                        <?php if (!empty($shop['address'])): ?>
                            <div class="col-md-6">
                                <h5 class="mb-3">Location</h5>
                                <div class="bg-light rounded p-3 mb-2">
                                    <i class="fa fa-map-marker-alt me-2"></i>
                                    <?= nl2br(htmlspecialchars($shop['address'])) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Products</h3>
            </div>

            <?php if (empty($products)): ?>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i> This shop doesn't have any products yet.
                    <a href="/products/create" class="alert-link">Add your first product</a>

                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php foreach ($products as $product): ?>
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm product-card">
                                <div class="position-relative">
                                    <?php if (!empty($product['img'])): ?>
                                        <img src="<?= htmlspecialchars($product['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fa fa-image fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <button class="btn btn-sm position-absolute top-0 end-0 m-2 btn-light rounded-circle p-2">
                                        <i class="fa fa-heart text-muted"></i>
                                    </button>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title text-truncate"><?= htmlspecialchars($product['name']) ?></h5>
                                    <p class="card-text text-truncate text-muted small"><?= htmlspecialchars($product['description'] ?? '') ?></p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="fw-bold fs-5">€<?= $product['price'] ?></span>

                                        <?php if ($product['stock'] > 0): ?>
                                            <span class="badge bg-success">In Stock</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-0 pt-0">
                                    <div class="d-grid gap-2">
                                        <a href="/products/<?= $product['product_id'] ?>" class="btn btn-outline-primary">View Details</a>

                                        <?php if ($product['stock'] > 0): ?>
                                            <form action="/cart/add" method="post">
                                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fa fa-shopping-cart me-2"></i> Add to Cart
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-secondary w-100" disabled>
                                                <i class="fa fa-ban me-2"></i> Out of Stock
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Contact Tab -->
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Contact Information</h3>

                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="fa fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Email</h5>
                                    <p class="mb-0"><?= htmlspecialchars($shop['contact_email']) ?></p>
                                </div>
                            </div>

                            <?php if (!empty($shop['contact_number'])): ?>
                                <div class="d-flex align-items-start mb-4">
                                    <div class="bg-light rounded-circle p-3 me-3">
                                        <i class="fa fa-phone text-primary"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Phone</h5>
                                        <p class="mb-0"><?= htmlspecialchars($shop['contact_number']) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($shop['address'])): ?>
                                <div class="d-flex align-items-start">
                                    <div class="bg-light rounded-circle p-3 me-3">
                                        <i class="fa fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Address</h5>
                                        <p class="mb-0"><?= nl2br(htmlspecialchars($shop['address'])) ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Send a Message</h3>

                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="name" class="form-label">Your Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="John Doe" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Your Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="john@example.com" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" placeholder="Question about a product">
                                </div>

                                <div class="mb-4">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="Type your message here..." required></textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-paper-plane me-2"></i> Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <a href="/shops" class="btn btn-outline-primary">
            <i class="fa fa-arrow-left me-2"></i> Back to Shops
        </a>
    </div>
</main>

<!-- Add some custom CSS for product cards hover effect -->
<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-0.5px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1) !important;
    }

    .tab-content {
        min-height: 400px;
    }
</style>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>