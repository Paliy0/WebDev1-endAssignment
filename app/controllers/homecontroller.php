<?php

namespace App\Controllers;

class HomeController
{
    private $productService;

    public function index()
    {
        $this->productService = new \App\Services\ProductService();

        $products = $this->productService->getAll();
        require __DIR__ . '/../views/home/index.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/home/about.php';
    }
}
