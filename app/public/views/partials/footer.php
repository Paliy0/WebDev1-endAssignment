<footer class="bg-white border-t mt-5">
    <div class="container py-12">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-md-6 col-lg-3">
                <h3 class="text-primary fw-bold fs-4 mb-3">PHP Marketplace</h3>
                <p class="text-muted mb-4">
                    Your one-stop shop for everything you need. Find products from various sellers all in one place.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-secondary rounded-circle p-2">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle p-2">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle p-2">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle p-2">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-6 col-lg-3">
                <h3 class="fs-5 fw-semibold mb-3">Shop</h3>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="/products" class="nav-link p-0 text-muted">All Products</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/products/new-arrivals" class="nav-link p-0 text-muted">New Arrivals</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/products/featured" class="nav-link p-0 text-muted">Featured Products</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/products/sale" class="nav-link p-0 text-muted">Sale Items</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/products/popular" class="nav-link p-0 text-muted">Popular Items</a>
                    </li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-md-6 col-lg-3">
                <h3 class="fs-5 fw-semibold mb-3">Customer Service</h3>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="/contact" class="nav-link p-0 text-muted">Contact Us</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/faq" class="nav-link p-0 text-muted">FAQ</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/shipping" class="nav-link p-0 text-muted">Shipping & Returns</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/terms" class="nav-link p-0 text-muted">Terms & Conditions</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/privacy" class="nav-link p-0 text-muted">Privacy Policy</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-md-6 col-lg-3">
                <h3 class="fs-5 fw-semibold mb-3">Stay Updated</h3>
                <p class="text-muted mb-3">Subscribe to our newsletter for the latest products and offers.</p>
                <form class="mb-4">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email address" required>
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </div>
                </form>
                <div class="mb-2 d-flex align-items-center text-muted">
                    <i class="bi bi-envelope me-2"></i>
                    <span>support@phpmarketplace.com</span>
                </div>
                <div class="mb-2 d-flex align-items-center text-muted">
                    <i class="bi bi-telephone me-2"></i>
                    <span>1 23456789</span>
                </div>
                <div class="d-flex align-items-center text-muted">
                    <i class="bi bi-geo-alt me-2"></i>
                    <span>Bijdorplaan 15, 2015 CE Haarlem</span>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted small mb-md-0">
                    &copy; <?= date('Y') ?> PHP Marketplace. All rights reserved.
                </p>
            </div>
            <div class="col-md-6">
                <ul class="nav justify-content-center justify-content-md-end">
                    <li class="nav-item">
                        <a href="/terms" class="nav-link px-2 text-muted">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a href="/privacy" class="nav-link px-2 text-muted">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a href="/cookies" class="nav-link px-2 text-muted">Cookies</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>

</html>