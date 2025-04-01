<?php

namespace App\Controllers;

use App\Models\ShopModel;
use App\Controllers\AuthController;

class ShopController
{
    private $shopModel;
    private $authController;

    public function __construct()
    {
        $this->shopModel = new ShopModel();
        $this->authController = new AuthController();
    }

    /**
     * Get all shops
     * @return array Shops data
     */
    public function getAllShops()
    {
        return $this->shopModel->getAll();
    }

    /**
     * Get shop by ID
     * @param int $id Shop ID
     * @return array|bool Shop data or false if not found
     */
    public function getShop($id)
    {
        return $this->shopModel->getById($id);
    }

    /**
     * Get shops owned by current user
     * @return array Shops data
     */
    public function getUserShops()
    {
        if (!$this->authController->isLoggedIn()) {
            return [];
        }

        $currentUser = $this->authController->getCurrentUser();
        return $this->shopModel->getByUserId($currentUser['id']);
    }

    /**
     * Create a new shop
     * @param array $data Shop data
     * @param array $file Uploaded file data (from $_FILES)
     * @return array Result with success status and message
     */
    public function createShop($data, $file = null)
    {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to create a shop'
            ];
        }

        // Check if user is a business
        if (!$this->authController->hasRole('business')) {
            return [
                'success' => false,
                'message' => 'Only business accounts can create shops'
            ];
        }

        // Validate required fields
        $requiredFields = ['name', 'description', 'contact_email'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return [
                    'success' => false,
                    'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
                ];
            }
        }

        // Validate email format
        if (!filter_var($data['contact_email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format'
            ];
        }

        // Handle image upload if provided
        $imgPath = '';
        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/uploads/shops/';

            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate unique filename
            $fileName = uniqid() . '_' . basename($file['image']['name']);
            $uploadPath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($file['image']['tmp_name'], $uploadPath)) {
                $imgPath = '/uploads/shops/' . $fileName;
            }
        }

        // Prepare data for database
        $currentUser = $this->authController->getCurrentUser();
        $shopData = [
            'user_id' => $currentUser['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'address' => $data['address'] ?? null,
            'contact_email' => $data['contact_email'],
            'contact_number' => $data['contact_number'] ?? null,
            'img' => $imgPath
        ];

        // Create shop
        $shopId = $this->shopModel->create($shopData);

        if (!$shopId) {
            return [
                'success' => false,
                'message' => 'Failed to create shop. Please try again.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Shop created successfully',
            'shop_id' => $shopId
        ];
    }

    /**
     * Update existing shop
     * @param int $id Shop ID
     * @param array $data Shop data
     * @param array $file Uploaded file data (from $_FILES)
     * @return array Result with success status and message
     */
    public function updateShop($id, $data, $file = null)
    {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to update a shop'
            ];
        }

        // Check if shop exists
        $shop = $this->shopModel->getById($id);
        if (!$shop) {
            return [
                'success' => false,
                'message' => 'Shop not found'
            ];
        }

        // Check if user owns the shop
        $currentUser = $this->authController->getCurrentUser();
        if ($shop['user_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this shop'
            ];
        }

        // Validate email format if provided
        if (isset($data['contact_email']) && !filter_var($data['contact_email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format'
            ];
        }

        // Handle image upload if provided
        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/uploads/shops/';

            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate unique filename
            $fileName = uniqid() . '_' . basename($file['image']['name']);
            $uploadPath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($file['image']['tmp_name'], $uploadPath)) {
                $data['img'] = '/uploads/shops/' . $fileName;

                // Remove old image if it exists
                if (!empty($shop['img'])) {
                    $oldImagePath = __DIR__ . '/../public' . $shop['img'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }
        }

        // Update shop
        $success = $this->shopModel->update($id, $data);

        if (!$success) {
            return [
                'success' => false,
                'message' => 'Failed to update shop. Please try again.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Shop updated successfully'
        ];
    }

    /**
     * Delete a shop
     * @param int $id Shop ID
     * @return array Result with success status and message
     */
    public function deleteShop($id)
    {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to delete a shop'
            ];
        }

        // Check if shop exists
        $shop = $this->shopModel->getById($id);
        if (!$shop) {
            return [
                'success' => false,
                'message' => 'Shop not found'
            ];
        }

        // Check if user owns the shop
        $currentUser = $this->authController->getCurrentUser();
        if ($shop['user_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this shop'
            ];
        }

        // Delete shop image if it exists
        if (!empty($shop['img'])) {
            $imagePath = __DIR__ . '/../public' . $shop['img'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete shop
        $success = $this->shopModel->delete($id);

        if (!$success) {
            return [
                'success' => false,
                'message' => 'Failed to delete shop. Please try again.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Shop deleted successfully'
        ];
    }
}
