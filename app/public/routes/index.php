<?php

use App\Controllers\ProductController;
use App\Controllers\ShopController;

$productController = new ProductController();
$shopController = new ShopController();

Route::add('/', function () use ($productController, $shopController) {
    $featuredProducts = array_slice($productController->getAllProducts(), 0, 4);
    $topShops = array_slice($shopController->getAllShops(), 0, 4);

    require(__DIR__ . "/../views/pages/index.php");
});
