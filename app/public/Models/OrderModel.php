<?php

namespace App\Models;

use PDO;
use PDOException;

class OrderModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createOrder($customerId, $totalPrice)
    {
        try {
            $stmt = self::$pdo->prepare("
                INSERT INTO orders (customer_id, total_price, status, created_at)
                VALUES (:customer_id, :total_price, 'confirmed', NOW())
            ");

            $stmt->execute([
                ':customer_id' => $customerId,
                ':total_price' => $totalPrice
            ]);

            return self::$pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function addOrderItem($orderId, $productId, $quantity, $price)
    {
        try {
            $subtotal = $price * $quantity;

            $stmt = self::$pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
                VALUES (:order_id, :product_id, :quantity, :price, :subtotal)
            ");

            return $stmt->execute([
                ':order_id' => $orderId,
                ':product_id' => $productId,
                ':quantity' => $quantity,
                ':price' => $price,
                ':subtotal' => $subtotal
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getOrdersByCustomer($customerId)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT * FROM orders
                WHERE customer_id = :customer_id
                ORDER BY created_at DESC
            ");

            $stmt->execute([':customer_id' => $customerId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getOrderById($orderId)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT * FROM orders
                WHERE order_id = :order_id
            ");

            $stmt->execute([':order_id' => $orderId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getOrderItems($orderId)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT oi.*, p.name, p.img
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                WHERE oi.order_id = :order_id
            ");

            $stmt->execute([':order_id' => $orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}
