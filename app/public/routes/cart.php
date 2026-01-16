<?php

use App\Controllers\CartController;
use App\Controllers\AuthController;

$cartController = new CartController();
$authController = new AuthController();

// View cart
Route::add('/cart', function () use ($cartController) {
    $cart = $cartController->getCart();
    $total = $cartController->getCartTotal();
    require(__DIR__ . "/../views/pages/cart/cart.php");
}, 'get');

// Add to cart
Route::add('/cart/add', function () use ($cartController) {
    $productId = $_POST['product_id'] ?? null;
    $quantity = (int)($_POST['quantity'] ?? 1);

    if (!$productId) {
        $_SESSION['error'] = 'Invalid product';
        header('Location: /products');
        exit;
    }

    $result = $cartController->addToCart($productId, $quantity);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    // Redirect back to previous page or cart
    $referer = $_SERVER['HTTP_REFERER'] ?? '/cart';
    header('Location: ' . $referer);
    exit;
}, 'post');

// Update cart quantity
Route::add('/cart/update', function () use ($cartController) {
    $productId = $_POST['product_id'] ?? null;
    $quantity = (int)($_POST['quantity'] ?? 1);

    if (!$productId) {
        $_SESSION['error'] = 'Invalid product';
        header('Location: /cart');
        exit;
    }

    $result = $cartController->updateQuantity($productId, $quantity);

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
    $productId = $_POST['product_id'] ?? null;

    if ($productId) {
        $cartController->removeFromCart($productId);
        $_SESSION['success'] = 'Product removed from cart';
    }

    header('Location: /cart');
    exit;
}, 'post');

// Clear cart
Route::add('/cart/clear', function () use ($cartController) {
    $cartController->clearCart();
    $_SESSION['success'] = 'Cart cleared';
    header('Location: /cart');
    exit;
}, 'post');

// Checkout page
Route::add('/checkout', function () use ($cartController, $authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'Please login to checkout';
        header('Location: /login');
        exit;
    }

    $cart = $cartController->getCart();

    if (empty($cart)) {
        $_SESSION['error'] = 'Your cart is empty';
        header('Location: /cart');
        exit;
    }

    $total = $cartController->getCartTotal();
    $user = $authController->getCurrentUser();

    require(__DIR__ . "/../views/pages/cart/checkout.php");
}, 'get');

// Process checkout
Route::add('/checkout', function () use ($cartController, $authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'Please login to checkout';
        header('Location: /login');
        exit;
    }

    $result = $cartController->checkout();

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        $_SESSION['last_order_id'] = $result['order_id'];
        header('Location: /order/confirmation');
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /checkout');
        exit;
    }
}, 'post');

// Order confirmation
Route::add('/order/confirmation', function () use ($authController) {
    if (!$authController->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    $orderId = $_SESSION['last_order_id'] ?? null;

    if (!$orderId) {
        header('Location: /');
        exit;
    }

    $orderModel = new \App\Models\OrderModel();
    $order = $orderModel->getOrderById($orderId);
    $orderItems = $orderModel->getOrderItems($orderId);

    unset($_SESSION['last_order_id']);

    require(__DIR__ . "/../views/pages/cart/order_confirmation.php");
}, 'get');

// View all orders
Route::add('/orders', function () use ($authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'Please login to view your orders';
        header('Location: /login');
        exit;
    }

    $user = $authController->getCurrentUser();
    $orderModel = new \App\Models\OrderModel();
    $orders = $orderModel->getOrdersByCustomer($user['id']);

    require(__DIR__ . "/../views/pages/cart/orders.php");
}, 'get');

// View single order details
Route::add('/orders/([0-9]+)', function ($orderId) use ($authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'Please login to view order details';
        header('Location: /login');
        exit;
    }

    $user = $authController->getCurrentUser();
    $orderModel = new \App\Models\OrderModel();
    $order = $orderModel->getOrderById($orderId);

    // Check if order belongs to user
    if (!$order || $order['customer_id'] != $user['id']) {
        header('HTTP/1.0 404 Not Found');
        require(__DIR__ . "/../views/pages/404.php");
        exit;
    }

    $orderItems = $orderModel->getOrderItems($orderId);

    require(__DIR__ . "/../views/pages/cart/order_detail.php");
}, 'get');
