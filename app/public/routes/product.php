<?php

use App\Controllers\ProductController;
use App\Controllers\ShopController;
use App\Controllers\AuthController;

// Create controller instances
$productController = new ProductController();
$shopController = new ShopController();
$authController = new AuthController();

// Product listing page
Route::add('/products', function () use ($productController) {
    $search = $_GET['search'] ?? '';
    $filters = [];

    if (!empty($search)) {
        $filters['search'] = $search;
    }

    $products = $productController->getAllProducts($filters);
    require(__DIR__ . "/../views/pages/product/products.php");
}, 'get');

// Product detail page
Route::add('/products/([0-9]+)', function ($productId) use ($productController) {
    $product = $productController->getProduct($productId);

    if (!$product) {
        header('Location: /products');
        exit;
    }

    require(__DIR__ . "/../views/pages/product/product_detail.php");
}, 'get');

// Product management page (list all products for business owner)
Route::add('/products/manage', function () use ($productController, $authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $currentUser = $authController->getCurrentUser();
    $products = $productController->getUserProducts($currentUser['id']);

    require(__DIR__ . "/../views/pages/product/manage_products.php");
}, 'get');

// Create product form
Route::add('/products/create', function () use ($authController, $shopController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $shops = $shopController->getUserShops();

    require(__DIR__ . "/../views/pages/product/create_product.php");
}, 'get');

// Create product form submission
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

// Edit product form
Route::add('/products/([0-9]+)/edit', function ($productId) use ($productController, $authController) {
    if (!$authController->isLoggedIn() || !$authController->hasRole('business')) {
        header('Location: /login');
        exit;
    }

    $product = $productController->getProduct($productId);
    if (!$product) {
        header('Location: /products/manage');
        exit;
    }

    // Check if user owns the product
    $currentUser = $authController->getCurrentUser();
    if ($product['store_id'] != $currentUser['id']) {
        header('Location: /products/manage');
        exit;
    }

    require(__DIR__ . "/../views/pages/product/edit_product.php");
}, 'get');

// Update product form submission
Route::add('/products/([0-9]+)/edit', function ($productId) use ($productController) {
    $result = $productController->updateProduct($productId, $_POST, $_FILES);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: /products/manage');
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /products/' . $productId . '/edit');
        exit;
    }
}, 'post');

// Delete product
Route::add('/products/([0-9]+)/delete', function ($productId) use ($productController) {
    $result = $productController->deleteProduct($productId);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    header('Location: /products/manage');
    exit;
}, 'post');
