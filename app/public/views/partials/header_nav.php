<?php

use App\Controllers\AuthController;

$authController = new AuthController();
$isLoggedIn = $authController->isLoggedIn();
$currentUser = $isLoggedIn ? $authController->getCurrentUser() : null;
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">
            <i class="bi bi-shop me-2"></i>PHP Marketplace
        </a>

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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage Business
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/shops/manage">My Shops</a></li>
                            <li><a class="dropdown-item" href="/products/manage">My Products</a></li>
                        </ul>
                    </li>
                 <?php endif; ?>
                 <?php if ($isLoggedIn && $currentUser['role'] === 'admin'): ?>
                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Admin Panel
                         </a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
                             <li><a class="dropdown-item" href="/admin/users">Manage Users</a></li>
                             <li><a class="dropdown-item" href="/admin/shops">Manage Shops</a></li>
                         </ul>
                     </li>
                 <?php endif; ?>
             </ul>

            <div class="d-flex align-items-center">
                <?php if ($isLoggedIn): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>
                            <?= $currentUser['email']; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i>My Profile</a></li>
                            <?php if ($currentUser['role'] === 'customer'): ?>
                                <li><a class="dropdown-item" href="/orders">My Orders</a></li>
                                <li><a class="dropdown-item" href="/cart">My Cart</a></li>
                            <?php endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                    <?php if ($currentUser['role'] === 'customer'): ?>
                        <a href="/cart" class="btn btn-link position-relative ms-2">
                            <i class="bi bi-cart fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                                <span class="visually-hidden">items in cart</span>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn btn-outline-primary me-2" href="/login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                    <a class="btn btn-primary" href="/register">
                        <i class="bi bi-person-plus me-1"></i>Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>