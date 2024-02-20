<?php

namespace App\Repository;

use PDO;
use PDOException;

class ProductRepository extends Repository
{

    function getAll()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM product");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            $products = $stmt->fetchAll();

            return $products;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function create($product)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO product (id, store_id, name, description, price, stock, created_at, updated_at) 
            VALUES (:id, :store_id, :name, :description, :price, :stock, :created_at, :updated_at)");

            $results = $stmt->execute([
                ':id' => $product->id,
                ':store_id' => $product->shop_id,
                ':name' => $product->name,
                ':description' => $product->description,
                ':price' => $product->price,
                ':stock' => $product->stock,
                ':created_at' => $product->created_at,
                ':updated_at' => $product->updated_at,
            ]);
            return $results;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
