<?php

namespace App\Services;

class ProductService
{
    public function getAll()
    {
        $repository = new \App\Repositories\ProductRepository();
        return $repository->getAll();
    }

    public function create($product)
    {
        $repository = new \App\Repositories\ProductRepository();
        return $repository->create($product);
    }
}
