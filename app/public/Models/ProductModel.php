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

    public function create($data)
    {
        try {
            $stmt = self::$pdo->prepare("
                INSERT INTO products (
                    shop_id,
                    name,
                    description,
                    price,
                    stock,
                    img,
                    created_at
                ) VALUES (
                    :shop_id,
                    :name,
                    :description,
                    :price,
                    :stock,
                    :img,
                    NOW()
                )
            ");

            $stmt->execute([
                ':shop_id' => $data['shop_id'],
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

    public function getById($id)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT p.*, s.name as shop_name, s.owner_id as shop_owner_id
                FROM products p
                JOIN shops s ON p.shop_id = s.shop_id
                WHERE p.product_id = :product_id
            ");

            $stmt->execute([':product_id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAll($filters = [])
    {
        try {
            $sql = "
            SELECT p.*, s.shop_id, s.owner_id as shop_owner_id, u.email as shop_email, s.name as shop_name
            FROM products p
            JOIN shops s ON p.shop_id = s.shop_id
            JOIN users u ON s.owner_id = u.user_id
            WHERE 1=1
            ";

            $params = [];

            // Add shop filter if provided
            if (isset($filters['shop_id'])) {
                $sql .= " AND p.shop_id = :shop_id";
                $params[':shop_id'] = $filters['shop_id'];
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

    public function getByShopId($shopId)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT * FROM products
                WHERE shop_id = :shop_id
                ORDER BY created_at DESC
            ");

            $stmt->execute([':shop_id' => $shopId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

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
