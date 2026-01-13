<?php

use App\Controllers\CartController;
use App\Controllers\AuthController;

// Create controller instances
$cartController = new CartController();
$authController = new AuthController();

// Cart page
Route::add('/cart', function () use ($cartController, $authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'You must be logged in to view your cart';
        header('Location: /login');
        exit;
    }

    $cartItems = $cartController->getCartItems();
    $cartSummary = $cartController->getCartSummary();

    require(__DIR__ . "/../views/pages/cart.php");
}, 'get');

// Add to cart
Route::add('/cart/add', function () use ($cartController) {
    $productId = $_POST['product_id'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;

    $result = $cartController->addToCart($productId, $quantity);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    // Redirect back to the referring page or to the cart
    $referer = $_SERVER['HTTP_REFERER'] ?? '/products';
    header("Location: $referer");
    exit;
}, 'post');

// Update cart item
Route::add('/cart/update', function () use ($cartController) {
    $productId = $_POST['product_id'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;

    $result = $cartController->updateCartItem($productId, $quantity);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    header('Location: /cart');
    exit;
}, 'post');

// Remove from cart
Route::add('/cart/remove', function () use ($cartController) {
    $productId = $_POST['product_id'] ?? 0;

    $result = $cartController->removeFromCart($productId);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    header('Location: /cart');
    exit;
}, 'post');

// Clear cart
Route::add('/cart/clear', function () use ($cartController) {
    $result = $cartController->clearCart();

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    header('Location: /cart');
    exit;
}, 'post');
