<?php

use App\Controllers\OrderController;
use App\Controllers\CartController;
use App\Controllers\AuthController;

// Create controller instances
$orderController = new OrderController();
$cartController = new CartController();
$authController = new AuthController();

// Checkout page
Route::add('/checkout', function () use ($cartController, $authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'You must be logged in to checkout';
        header('Location: /login');
        exit;
    }

    $cartItems = $cartController->getCartItems();
    $cartSummary = $cartController->getCartSummary();

    if (empty($cartItems)) {
        $_SESSION['error'] = 'Your cart is empty';
        header('Location: /cart');
        exit;
    }

    require(__DIR__ . "/../views/pages/checkout/checkout.php");
}, 'get');

// Process order
Route::add('/checkout/process', function () use ($orderController) {
    $result = $orderController->createOrder();

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: /orders/' . $result['order_id']);
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /checkout');
        exit;
    }
}, 'post');

// Order confirmation page
Route::add('/orders/([0-9]+)', function ($orderId) use ($orderController, $authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'You must be logged in to view orders';
        header('Location: /login');
        exit;
    }

    $orderDetails = $orderController->getOrderDetails($orderId);

    if (!$orderDetails) {
        $_SESSION['error'] = 'Order not found';
        header('Location: /orders');
        exit;
    }

    require(__DIR__ . "/../views/pages/order/order_detail.php");
}, 'get');

// Orders list page
Route::add('/orders', function () use ($orderController, $authController) {
    if (!$authController->isLoggedIn()) {
        $_SESSION['error'] = 'You must be logged in to view orders';
        header('Location: /login');
        exit;
    }

    $orders = $orderController->getUserOrders();

    require(__DIR__ . "/../views/pages/order/orders.php");
}, 'get');
