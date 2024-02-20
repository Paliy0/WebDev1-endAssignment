<?php

namespace App\Services;

class ProductService
{
    public function getAll()
    {
        $repository = new \App\Repository\ProductRepository();
        return $repository->getAll();
    }

    public function create($product)
    {
        $repository = new \App\Repository\ProductRepository();
        return $repository->create($product);
    }
}
