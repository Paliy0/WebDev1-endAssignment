<?php
require __DIR__ . '/../repositories/productrepository.php';

class ProductService
{
    public function getAll()
    {
        $repository = new ProductRepository();
        return $repository->getAll();
    }
    public function create(Product $product)
    {
        $repository = new ProductRepository();
        return $repository->create($product);
    }
}
