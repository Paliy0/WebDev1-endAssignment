<?php require(__DIR__ . "/../partials/header.php"); ?>

<div class="min-vh-100 d-flex flex-column justify-content-center bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center mb-4">
                    <h1 class="h2 text-primary fw-bold">PHP Marketplace</h1>
                    <p class="text-muted">Create your account and start exploring</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="card-title text-center mb-4">Create Account</h2>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?= $_SESSION['error']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="/register">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                </div>
                                <div class="form-text">We'll never share your email with anyone else.</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Create a strong password" required>
                                </div>
                                <div class="form-text">Password must be at least 8 characters long.</div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label">Account Type</label>
                                <div class="row">
                                    <div class="col-md-6 mb-2 mb-md-0">
                                        <div class="form-check card p-3 border">
                                            <input class="form-check-input" type="radio" name="role" id="role-customer" value="customer" checked>
                                            <label class="form-check-label w-100" for="role-customer">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-person fs-4 me-2 text-primary"></i>
                                                    <span class="fw-medium">Customer</span>
                                                </div>
                                                <small class="text-muted">Shop for products from various sellers</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check card p-3 border">
                                            <input class="form-check-input" type="radio" name="role" id="role-business" value="business">
                                            <label class="form-check-label w-100" for="role-business">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-shop fs-4 me-2 text-primary"></i>
                                                    <span class="fw-medium">Business Owner</span>
                                                </div>
                                                <small class="text-muted">Sell your products on our platform</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary py-2">Create Account</button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Already have an account? <a href="/login" class="text-decoration-none">Login here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require(__DIR__ . "/../partials/footer.php"); ?>