<?php

namespace App\Models;

use PDO;
use PDOException;

class ShopModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new shop
     * @param array $data Shop data
     * @return int|bool Shop ID or false on failure
     */
    public function create($data)
    {
        try {
            $stmt = self::$pdo->prepare("
                INSERT INTO shops (
                    user_id, 
                    name, 
                    description, 
                    address, 
                    contact_email, 
                    contact_number, 
                    img, 
                    created_at
                ) VALUES (
                    :user_id, 
                    :name, 
                    :description, 
                    :address, 
                    :contact_email, 
                    :contact_number, 
                    :img, 
                    NOW()
                )
            ");

            $stmt->execute([
                ':user_id' => $data['user_id'],
                ':name' => $data['name'],
                ':description' => $data['description'],
                ':address' => $data['address'] ?? null,
                ':contact_email' => $data['contact_email'],
                ':contact_number' => $data['contact_number'] ?? null,
                ':img' => $data['img'] ?? ''
            ]);

            return self::$pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing shop
     * @param int $id Shop ID
     * @param array $data Shop data to update
     * @return bool Success or failure
     */
    public function update($id, $data)
    {
        try {
            $allowedFields = ['name', 'description', 'address', 'contact_email', 'contact_number', 'img'];
            $sets = [];
            $params = [':shop_id' => $id];

            foreach ($data as $key => $value) {
                if (in_array($key, $allowedFields)) {
                    $sets[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }

            if (empty($sets)) {
                return false;
            }

            $sql = "UPDATE shops SET " . implode(', ', $sets) . " WHERE shop_id = :shop_id";
            $stmt = self::$pdo->prepare($sql);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a shop
     * @param int $id Shop ID
     * @return bool Success or failure
     */
    public function delete($id)
    {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM shops WHERE shop_id = :shop_id");
            return $stmt->execute([':shop_id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get a shop by ID
     * @param int $id Shop ID
     * @return array|bool Shop data or false if not found
     */
    public function getById($id)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT s.*, u.email as owner_email 
                FROM shops s
                JOIN users u ON s.user_id = u.user_id
                WHERE s.shop_id = :shop_id
            ");

            $stmt->execute([':shop_id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get all shops
     * @return array Array of shops
     */
    public function getAll()
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT s.*, u.email as owner_email 
                FROM shops s
                JOIN users u ON s.user_id = u.user_id
                ORDER BY s.created_at DESC
            ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Get shops by user ID
     * @param int $userId User ID
     * @return array Array of shops
     */
    public function getByUserId($userId)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT * FROM shops
                WHERE user_id = :user_id
                ORDER BY created_at DESC
            ");

            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Check if user owns shop
     * @param int $shopId Shop ID
     * @param int $userId User ID
     * @return bool True if user owns shop, false otherwise
     */
    public function isOwner($shopId, $userId)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT COUNT(*) FROM shops
                WHERE shop_id = :shop_id AND user_id = :user_id
            ");

            $stmt->execute([
                ':shop_id' => $shopId,
                ':user_id' => $userId
            ]);

            return (int)$stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
