<?php

namespace App\Models;

use PDO;
use PDOException;

class ProductModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new product
     * @param array $data Product data
     * @return int|bool Product ID or false on failure
     */
    public function create($data)
    {
        try {
            $stmt = self::$pdo->prepare("
                INSERT INTO products (
                    store_id, 
                    name, 
                    description, 
                    price, 
                    stock, 
                    img, 
                    created_at
                ) VALUES (
                    :store_id, 
                    :name, 
                    :description, 
                    :price, 
                    :stock, 
                    :img, 
                    NOW()
                )
            ");

            $stmt->execute([
                ':store_id' => $data['store_id'],
                ':name' => $data['name'],
                ':description' => $data['description'],
                ':price' => $data['price'],
                ':stock' => $data['stock'],
                ':img' => $data['img'] ?? ''
            ]);

            return self::$pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing product
     * @param int $id Product ID
     * @param array $data Product data to update
     * @return bool Success or failure
     */
    public function update($id, $data)
    {
        try {
            $allowedFields = ['name', 'description', 'price', 'stock', 'img'];
            $sets = [];
            $params = [':product_id' => $id];

            foreach ($data as $key => $value) {
                if (in_array($key, $allowedFields)) {
                    $sets[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }

            if (empty($sets)) {
                return false;
            }

            $sql = "UPDATE products SET " . implode(', ', $sets) . " WHERE product_id = :product_id";
            $stmt = self::$pdo->prepare($sql);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a product
     * @param int $id Product ID
     * @return bool Success or failure
     */
    public function delete($id)
    {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
            return $stmt->execute([':product_id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get a product by ID
     * @param int $id Product ID
     * @return array|bool Product data or false if not found
     */
    public function getById($id)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT p.*, s.name as shop_name 
                FROM products p
                JOIN shops s ON p.store_id = s.user_id
                WHERE p.product_id = :product_id
            ");

            $stmt->execute([':product_id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get all products
     * @param array $filters Optional filters
     * @return array Array of products
     */
    public function getAll($filters = [])
    {
        try {
            $sql = "
            SELECT p.*, s.shop_id, u.email as shop_email, s.name as shop_name
            FROM products p
            JOIN users u ON p.store_id = u.user_id
            LEFT JOIN shops s ON p.store_id = s.user_id
            WHERE 1=1
            ";

            $params = [];

            // Add shop filter if provided
            if (isset($filters['store_id'])) {
                $sql .= " AND p.store_id = :store_id";
                $params[':store_id'] = $filters['store_id'];
            }

            // Add search filter if provided
            if (isset($filters['search']) && !empty($filters['search'])) {
                $sql .= " AND (p.name LIKE :search OR p.description LIKE :search)";
                $params[':search'] = '%' . $filters['search'] . '%';
            }

            $sql .= " ORDER BY p.created_at DESC";

            $stmt = self::$pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Get products by store ID
     * @param int $storeId Store/User ID
     * @return array Array of products
     */
    public function getByStoreId($storeId)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT * FROM products
                WHERE store_id = :store_id
                ORDER BY created_at DESC
            ");

            $stmt->execute([':store_id' => $storeId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Update product stock
     * @param int $id Product ID
     * @param int $quantity Quantity to add (positive) or subtract (negative)
     * @return bool Success or failure
     */
    public function updateStock($id, $quantity)
    {
        try {
            $stmt = self::$pdo->prepare("
                UPDATE products
                SET stock = stock + :quantity
                WHERE product_id = :product_id AND stock + :quantity >= 0
            ");

            return $stmt->execute([
                ':product_id' => $id,
                ':quantity' => $quantity
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
