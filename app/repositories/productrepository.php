<?php
require __DIR__ . '/repository.php';
require __DIR__ . '/../models/product.php';

class ProductRepository extends Repository
{
    function getAll()
    {
        try {
            $stmt = $this->connection->prepare("SELECT product.*, store.name as storeName
            FROM product 
            JOIN store ON product.storeId = store.id
            ");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            $products = $stmt->fetchAll();

            return $products;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getById($id)
    {
        try {
            $query = "SELECT product.* WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $product = new Product();
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $product->setDesc($row['description']);
            $product->setImg($row['img']);
            $product->setStoreId($row['storeId']);
            $product->setQuantity($row['quantity']);

            return $product;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function create(Product $product)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into product (name, price, description, image, storeId) VALUES (?,?,?,?,?)");

            $stmt->execute([$product->getName(), $product->getPrice(), $product->getDesc(), $product->getImg(), $product->getStoreId()]);

            $productId = $this->$connection->lastInsertId();
            $product->setId($productId);

            return $this->getById($product->getId());
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
