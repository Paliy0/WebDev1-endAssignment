<?php

use App\Controllers\ProductController;
use App\Controllers\ShopController;
use App\Controllers\AuthController;

$productController = new ProductController();
$shopController = new ShopController();
$authController = new AuthController();

Route::add('/products', function () use ($productController) {
    $search = $_GET['search'] ?? '';
    $filters = [];

    if (!empty($search)) {
        $filters['search'] = $search;
    }

    $products = $productController->getAllProducts($filters);
    require(__DIR__ . "/../views/pages/products.php");
}, 'get');

Route::add('/products/([0-9]+)', function ($productId) use ($productController) {
    $product = $productController->getProduct($productId);

    if (!$product) {
        header('Location: /products');
        exit;
    }

    require(__DIR__ . "/../views/pages/product_detail.php");
}, 'get');

Route::add('/products/manage', function () use ($productController, $authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $currentUser = $authController->getCurrentUser();
    $products = $productController->getShopProducts($currentUser['id']);

    require(__DIR__ . "/../views/pages/manage_products.php");
}, 'get');

Route::add('/products/create', function () use ($authController, $shopController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $shops = $shopController->getUserShops();

    require(__DIR__ . "/../views/pages/create_product.php");
}, 'get');

Route::add('/products/create', function () use ($productController) {
    $result = $productController->createProduct($_POST, $_FILES);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: /products/manage');
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /products/create');
        exit;
    }
}, 'post');
