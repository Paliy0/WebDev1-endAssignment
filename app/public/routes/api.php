<?php

use App\Controllers\ProductController;
use App\Controllers\ShopController;

$productController = new ProductController();
$shopController = new ShopController();

// GET /api/products - Returns all products as JSON
Route::add('/api/products', function () use ($productController) {
    header('Content-Type: application/json');

    $search = $_GET['search'] ?? '';
    $filters = [];

    if (!empty($search)) {
        $filters['search'] = $search;
    }

    $products = $productController->getAllProducts($filters);
    echo json_encode($products);
}, 'get');

// GET /api/products/{id} - Returns single product as JSON
Route::add('/api/products/([0-9]+)', function ($productId) use ($productController) {
    header('Content-Type: application/json');

    $product = $productController->getProduct($productId);

    if (!$product) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        return;
    }

    echo json_encode($product);
}, 'get');

// GET /api/shops - Returns all shops as JSON
Route::add('/api/shops', function () use ($shopController) {
    header('Content-Type: application/json');

    $shops = $shopController->getAllShops();
    echo json_encode($shops);
}, 'get');

// GET /api/shops/{id} - Returns single shop as JSON
Route::add('/api/shops/([0-9]+)', function ($shopId) use ($shopController) {
    header('Content-Type: application/json');

    $shop = $shopController->getShop($shopId);

    if (!$shop) {
        http_response_code(404);
        echo json_encode(['error' => 'Shop not found']);
        return;
    }

    echo json_encode($shop);
}, 'get');
