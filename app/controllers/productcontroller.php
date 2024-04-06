<?php
require __DIR__ . '/../services/productservice.php';

class ProductController
{
    private $productService;

    function __construct()
    {
        $this->productService = new \App\Services\ProductService();
    }

    public function index()
    {
        $model = $this->productService->getAll();

        require __DIR__ . '/../views/products/index.php';
    }

    public function create() //pass values to create product
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            print_r($_POST);
            print_r($_FILES);

            if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['desc']) && isset($_FILES['img'])) {
                $product = new Product();
                $product->setName($_POST['name']);
                $product->setDesc($_POST['desc']);
                $product->setPrice($_POST['price']);

                $image = $_FILES['image'];
                $upload_dir = '/home/paliyo/Projects/php-mvc-basic/app/img/products/';
                $uploaded_image = $upload_dir . basename($image['name']);
                move_uploaded_file($image['tmp_name'], $uploaded_image);
                $product->setImg($uploaded_image);
                $productService = new ProductService();
                $productService->create($product);
            }
        }


        /*
        $model = $this->productService->getAll();
        $image = $_FILES['image'];
        $upload_dir = 'path/to/images/products/';
        $uploaded_image = $upload_dir . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $uploaded_image);
        */

        require __DIR__ . '/../views/products/create.php';
    }

    public function edit()
    {
        //$model = $this->productService->getAll();
        require __DIR__ . '/../views/products/edit.php';
    }

    public function delete()
    {
        //$model = $this->productService->getAll();
        require __DIR__ . '/../views/products/delete.php';
    }
}
