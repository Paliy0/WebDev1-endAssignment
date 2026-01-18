<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;

class CartController
{
    private $productModel;
    private $orderModel;
    private $authController;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->authController = new AuthController();
    }

    public function getCart()
    {
        return $_SESSION['cart'] ?? [];
    }

    public function getCartCount()
    {
        $cart = $this->getCart();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    public function getCartTotal()
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = $this->productModel->getById($productId);

        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }

        if ($product['stock'] < $quantity) {
            return [
                'success' => false,
                'message' => 'Not enough stock available'
            ];
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $newQuantity = $_SESSION['cart'][$productId]['quantity'] + $quantity;

            if ($newQuantity > $product['stock']) {
                return [
                    'success' => false,
                    'message' => 'Cannot add more than available stock'
                ];
            }

            $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'img' => $product['img'],
                'stock' => $product['stock']
            ];
        }

        return [
            'success' => true,
            'message' => 'Product added to cart'
        ];
    }

    public function updateQuantity($productId, $quantity)
    {
        if (!isset($_SESSION['cart'][$productId])) {
            return [
                'success' => false,
                'message' => 'Product not in cart'
            ];
        }

        if ($quantity <= 0) {
            return $this->removeFromCart($productId);
        }

        $product = $this->productModel->getById($productId);

        if ($quantity > $product['stock']) {
            return [
                'success' => false,
                'message' => 'Not enough stock available'
            ];
        }

        $_SESSION['cart'][$productId]['quantity'] = $quantity;

        return [
            'success' => true,
            'message' => 'Cart updated'
        ];
    }

    public function removeFromCart($productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        return [
            'success' => true,
            'message' => 'Product removed from cart'
        ];
    }

    public function clearCart()
    {
        $_SESSION['cart'] = [];

        return [
            'success' => true,
            'message' => 'Cart cleared'
        ];
    }

    public function checkout()
    {
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to checkout'
            ];
        }

        $cart = $this->getCart();

        if (empty($cart)) {
            return [
                'success' => false,
                'message' => 'Your cart is empty'
            ];
        }

        $currentUser = $this->authController->getCurrentUser();
        $total = $this->getCartTotal();

        // Create order
        $orderId = $this->orderModel->createOrder($currentUser['id'], $total);

        if (!$orderId) {
            return [
                'success' => false,
                'message' => 'Failed to create order'
            ];
        }

        // Add order items and reduce stock
        foreach ($cart as $item) {
            $this->orderModel->addOrderItem(
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $item['price']
            );

            // Reduce product stock
            $this->productModel->updateStock($item['product_id'], -$item['quantity']);
        }

        // Clear cart
        $this->clearCart();

        return [
            'success' => true,
            'message' => 'Order placed successfully',
            'order_id' => $orderId
        ];
    }
}
