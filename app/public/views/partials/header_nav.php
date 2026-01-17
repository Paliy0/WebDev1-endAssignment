<?php

use App\Controllers\AuthController;
use App\Controllers\CartController;

$authController = new AuthController();
$cartController = new CartController();
$isLoggedIn = $authController->isLoggedIn();
$currentUser = $isLoggedIn ? $authController->getCurrentUser() : null;
$cartCount = $cartController->getCartCount();
?>

<header class="header">
    <div class="container">
        <div class="header-inner">
            <a href="/" class="logo">Curated</a>

            <nav class="nav">
                <a href="/products" class="nav-link">Products</a>
                <a href="/shops" class="nav-link">Shops</a>
                <?php if ($isLoggedIn && $currentUser['role'] === 'business'): ?>
                    <a href="/shops/manage" class="nav-link">My Shops</a>
                    <a href="/products/manage" class="nav-link">My Products</a>
                <?php endif; ?>
                <?php if ($isLoggedIn && $currentUser['role'] === 'admin'): ?>
                    <a href="/admin/dashboard" class="nav-link">Admin</a>
                <?php endif; ?>
            </nav>

            <div class="header-actions">
                <?php if ($isLoggedIn): ?>
                    <div class="dropdown-wrapper">
                        <button class="icon-button" aria-label="Account" onclick="toggleAccountMenu()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </button>
                        <div class="dropdown-menu" id="account-menu">
                            <div class="dropdown-user"><?= htmlspecialchars($currentUser['email']); ?></div>
                            <a href="/profile" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                My Profile
                            </a>
                            <a href="/orders" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                My Orders
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/logout" class="dropdown-item text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                Logout
                            </a>
                        </div>
                    </div>
                    <a href="/cart" class="icon-button cart-button-wrapper" aria-label="Cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge" id="cart-count"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline">Login</a>
                    <a href="/register" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>

                <button class="mobile-menu-toggle" aria-label="Menu" onclick="toggleMobileMenu()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="mobile-menu-overlay" id="mobile-menu-overlay" onclick="closeMobileMenu()"></div>
<aside class="mobile-menu" id="mobile-menu">
    <div class="mobile-menu-header">
        <a href="/" class="logo">Curated</a>
        <button class="icon-button" onclick="closeMobileMenu()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
        </button>
    </div>
    <nav class="mobile-menu-nav">
        <a href="/products" class="nav-link">Products</a>
        <a href="/shops" class="nav-link">Shops</a>
        <?php if ($isLoggedIn && $currentUser['role'] === 'business'): ?>
            <a href="/shops/manage" class="nav-link">My Shops</a>
            <a href="/products/manage" class="nav-link">My Products</a>
        <?php endif; ?>
        <?php if ($isLoggedIn && $currentUser['role'] === 'admin'): ?>
            <a href="/admin/dashboard" class="nav-link">Admin Panel</a>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <a href="/profile" class="nav-link">My Profile</a>
            <a href="/orders" class="nav-link">My Orders</a>
            <a href="/cart" class="nav-link">My Cart</a>
            <a href="/logout" class="nav-link text-accent">Logout</a>
        <?php else: ?>
            <a href="/login" class="nav-link">Login</a>
            <a href="/register" class="nav-link">Sign Up</a>
        <?php endif; ?>
    </nav>
</aside>

<style>
.dropdown-wrapper {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: var(--space-2);
    min-width: 200px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-elevated);
    padding: var(--space-2);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
    z-index: 100;
}

.dropdown-menu.open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-user {
    padding: var(--space-3) var(--space-3);
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--foreground);
    border-bottom: 1px solid var(--border);
    margin-bottom: var(--space-2);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    font-size: 0.875rem;
    color: var(--foreground);
    border-radius: var(--radius-md);
    transition: background-color 0.2s ease;
}

.dropdown-item:hover {
    background: var(--secondary);
}

.dropdown-divider {
    height: 1px;
    background: var(--border);
    margin: var(--space-2) 0;
}
</style>

<script>
function toggleAccountMenu() {
    const menu = document.getElementById('account-menu');
    menu.classList.toggle('open');
}

function toggleMobileMenu() {
    const overlay = document.getElementById('mobile-menu-overlay');
    const menu = document.getElementById('mobile-menu');
    overlay.classList.add('open');
    menu.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeMobileMenu() {
    const overlay = document.getElementById('mobile-menu-overlay');
    const menu = document.getElementById('mobile-menu');
    overlay.classList.remove('open');
    menu.classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('click', function(e) {
    const accountMenu = document.getElementById('account-menu');
    const wrapper = document.querySelector('.dropdown-wrapper');
    if (accountMenu && wrapper && !wrapper.contains(e.target)) {
        accountMenu.classList.remove('open');
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeMobileMenu();
        const accountMenu = document.getElementById('account-menu');
        if (accountMenu) accountMenu.classList.remove('open');
    }
});
</script>
