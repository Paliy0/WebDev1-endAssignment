<?php
require __DIR__ . '/../services/productservice.php';

class HomeController
{
    private $productService;

    public function index()
    {
        $this->productService = new ProductService();

        $products = $this->productService->getAll();
        require __DIR__ . '/../views/home/index.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/home/about.php';
    }
}
