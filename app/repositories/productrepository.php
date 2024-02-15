<?php
require __DIR__ . '/repository.php';
require __DIR__ . '/../models/product.php';

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

    function create(Product $product)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO `product` (`id`, `name`, `description`, `price`, `img`, `storeId`, `quantity`) VALUES (?, ?, ?, ?, ?, ?, ?");
            $stmt->bind_param("ssdsii", $product->getName(), $product->getDesc(), $product->getPrice(), $product->getImg(), $product->getStoreId(), $product->getQuantity());

            $stmt->execute();
            $stmt->close();

            return $products;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
