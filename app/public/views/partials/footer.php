<footer class="bg-white border-t mt-5">
    <div class="container py-12">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-md-4">
                <h3 class="text-primary fw-bold fs-4 mb-3">PHP Marketplace</h3>
                <p class="text-muted mb-4">
                    Your one-stop shop for everything you need. Find products from various sellers all in one place.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4">
                <h3 class="fs-5 fw-semibold mb-3">Browse</h3>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="/shops" class="nav-link p-0 text-muted">All Shops</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="/products" class="nav-link p-0 text-muted">All Products</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4">
                <h3 class="fs-5 fw-semibold mb-3">Contact Us</h3>
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
            <div class="col-12 text-center">
                <p class="text-muted small mb-0">
                    &copy; <?= date('Y') ?> PHP Marketplace. All rights reserved. | <a href="/cookies" class="text-muted">Cookies</a>
                </p>
            </div>
        </div>
    </div>
</footer>
</body>

</html>