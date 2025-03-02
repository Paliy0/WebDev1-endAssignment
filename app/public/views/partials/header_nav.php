<?php
require_once(__DIR__ . "/../../controllers/AuthController.php");
$authController = new AuthController();
$isLoggedIn = $authController->isLoggedIn();
$currentUser = $isLoggedIn ? $authController->getCurrentUser() : null;
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">E-Commerce Platform</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/shops">Shops</a>
                </li>
                <?php if ($isLoggedIn && $currentUser['role'] === 'business'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/shops/manage">Manage Shops</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex">
                <?php if ($isLoggedIn): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $currentUser['email']; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                            <?php if ($currentUser['role'] === 'customer'): ?>
                                <li><a class="dropdown-item" href="/orders">My Orders</a></li>
                            <?php endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a class="btn btn-outline-light me-2" href="/login">Login</a>
                    <a class="btn btn-primary" href="/register">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>