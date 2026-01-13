<?php

use App\Controllers\ShopController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;

// Create controller instances
$shopController = new ShopController();
$authController = new AuthController();
$productController = new ProductController();

// Shops listing page
Route::add('/shops', function () use ($shopController) {
    $shops = $shopController->getAllShops();
    require(__DIR__ . "/../views/pages/shops.php");
}, 'get');

// Shop detail page
Route::add('/shops/([0-9]+)', function ($shopId) use ($shopController, $productController) {
    $shop = $shopController->getShop($shopId);

    if (!$shop) {
        header('Location: /shops');
        exit;
    }

    // Get products for this shop
    $products = $productController->getShopProducts($shop['user_id']);

    require(__DIR__ . "/../views/pages/shop_detail.php");
}, 'get');

// Shop management page (for business owner)
Route::add('/shops/manage', function () use ($shopController, $authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $shops = $shopController->getUserShops();
    require(__DIR__ . "/../views/pages/manage_shops.php");
}, 'get');

// Create shop form
Route::add('/shops/create', function () use ($authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    require(__DIR__ . "/../views/pages/create_shop.php");
}, 'get');

// Create shop form submission
Route::add('/shops/create', function () use ($shopController) {
    $result = $shopController->createShop($_POST, $_FILES);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: /shops/manage');
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /shops/create');
        exit;
    }
}, 'post');

// Edit shop form
Route::add('/shops/([0-9]+)/edit', function ($shopId) use ($shopController, $authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $shop = $shopController->getShop($shopId);

    if (!$shop) {
        header('Location: /shops/manage');
        exit;
    }

    // Check if user owns the shop
    $currentUser = $authController->getCurrentUser();
    if ($shop['user_id'] != $currentUser['id']) {
        $_SESSION['error'] = 'You do not have permission to edit this shop.';
        header('Location: /shops/manage');
        exit;
    }

    require(__DIR__ . "/../views/pages/edit_shop.php");
}, 'get');

// Edit shop form submission
Route::add('/shops/([0-9]+)/edit', function ($shopId) use ($shopController) {
    $result = $shopController->updateShop($shopId, $_POST, $_FILES);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: /shops/manage');
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /shops/' . $shopId . '/edit');
        exit;
    }
}, 'post');

// Delete shop
Route::add('/shops/([0-9]+)/delete', function ($shopId) use ($shopController, $authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $result = $shopController->deleteShop($shopId);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    header('Location: /shops/manage');
    exit;
}, 'post');
