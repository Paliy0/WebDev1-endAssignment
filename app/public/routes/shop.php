<?php

use App\Controllers\ShopController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;

$shopController = new ShopController();
$authController = new AuthController();
$productController = new ProductController();

Route::add('/shops', function () use ($shopController) {
    $shops = $shopController->getAllShops();
    require(__DIR__ . "/../views/pages/shops/shops.php");
}, 'get');

Route::add('/shops/([0-9]+)', function ($shopId) use ($shopController, $productController) {
    $shop = $shopController->getShop($shopId);

    if (!$shop) {
        header('Location: /shops');
        exit;
    }

    $products = $productController->getShopProducts($shop['owner_id']);

    require(__DIR__ . "/../views/pages/shops/shop_detail.php");
}, 'get');

Route::add('/shops/manage', function () use ($shopController, $authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $shops = $shopController->getUserShops();
    require(__DIR__ . "/../views/pages/shops/manage_shops.php");
}, 'get');

Route::add('/shops/create', function () use ($authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    require(__DIR__ . "/../views/pages/shops/create_shop.php");
}, 'get');

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

    $currentUser = $authController->getCurrentUser();
    if ($shop['owner_id'] != $currentUser['id']) {
        $_SESSION['error'] = 'You do not have permission to edit this shop.';
        header('Location: /shops/manage');
        exit;
    }

    require(__DIR__ . "/../views/pages/shops/edit_shop.php");
}, 'get');

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
