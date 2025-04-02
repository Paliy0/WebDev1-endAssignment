<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ShopModel;
use App\Controllers\AuthController;

use Cloudinary\Api\Upload\UploadApi;

class ProductController
{
    private $productModel;
    private $shopModel;
    private $authController;

    public function __construct()
    {
        $this->productModel = new \App\Models\ProductModel();
        $this->shopModel = new \App\Models\ShopModel();
        $this->authController = new AuthController();
    }

    /**
     * Get all products with optional filtering
     * @param array $filters Optional filters (shop_id, search)
     * @return array Products data
     */
    public function getAllProducts($filters = [])
    {
        return $this->productModel->getAll($filters);
    }

    /**
     * Get product by ID
     * @param int $id Product ID
     * @return array|bool Product data or false if not found
     */
    public function getProduct($id)
    {
        return $this->productModel->getById($id);
    }

    /**
     * Get products for a specific shop
     * @param int $shopId Shop ID
     * @return array Products data
     */
    public function getShopProducts($shopId)
    {
        return $this->productModel->getByStoreId($shopId);
    }

    /**
     * Create a new product
     * @param array $data Product data
     * @param array $file Uploaded file data (from $_FILES)
     * @return array Result with success status and message
     */
    public function createProduct($data, $file = null)
    {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to create a product'
            ];
        }

        // Check if user is a business
        if (!$this->authController->hasRole('business')) {
            return [
                'success' => false,
                'message' => 'Only business accounts can create products'
            ];
        }

        // Validate required fields
        $requiredFields = ['name', 'price', 'stock', 'shop_id'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return [
                    'success' => false,
                    'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
                ];
            }
        }

        // Validate price and stock are numeric
        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            return [
                'success' => false,
                'message' => 'Price must be a positive number'
            ];
        }

        if (!is_numeric($data['stock']) || $data['stock'] < 0) {
            return [
                'success' => false,
                'message' => 'Stock must be a non-negative number'
            ];
        }

        // Handle image upload with Cloudinary if provided
        $imgPath = '';
        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            try {

                // Upload to Cloudinary
                $upload = new UploadApi();
                $result = $upload->upload($file['image']['tmp_name'], [
                    'folder' => 'products',
                    'public_id' => 'product_' . time(),
                    'overwrite' => true
                ]);

                // Get secure URL from result
                $imgPath = $result['secure_url'];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Image upload failed: ' . $e->getMessage()
                ];
            }
        }

        // Prepare data for database
        $productData = [
            'store_id' => $data['shop_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
            'stock' => $data['stock'],
            'img' => $imgPath
        ];

        // Create product
        $productId = $this->productModel->create($productData);

        if (!$productId) {
            return [
                'success' => false,
                'message' => 'Failed to create product. Please try again.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Product created successfully',
            'product_id' => $productId
        ];
    }

    /**
     * Update existing product
     * @param int $id Product ID
     * @param array $data Product data
     * @param array $file Uploaded file data (from $_FILES)
     * @return array Result with success status and message
     */
    public function updateProduct($id, $data, $file = null)
    {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to update a product'
            ];
        }

        // Get product to check ownership
        $product = $this->productModel->getById($id);
        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }

        // Check if user owns the product
        $currentUser = $this->authController->getCurrentUser();
        if ($product['store_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this product'
            ];
        }

        // Validate price and stock if provided
        if (isset($data['price']) && (!is_numeric($data['price']) || $data['price'] <= 0)) {
            return [
                'success' => false,
                'message' => 'Price must be a positive number'
            ];
        }

        if (isset($data['stock']) && (!is_numeric($data['stock']) || $data['stock'] < 0)) {
            return [
                'success' => false,
                'message' => 'Stock must be a non-negative number'
            ];
        }

        // Handle image upload with Cloudinary if provided
        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            try {

                // Upload to Cloudinary
                $upload = new UploadApi();
                $result = $upload->upload($file['image']['tmp_name'], [
                    'folder' => 'products',
                    'public_id' => 'product_' . $id . '_' . time(),
                    'overwrite' => true
                ]);

                // Get secure URL from result
                $data['img'] = $result['secure_url'];

                // Remove old image if it exists
                if (!empty($product['img'])) {
                    $upload = new UploadApi();
                    $upload->destroy($this->extractPublicId($product['img']), []);
                }
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Image upload failed: ' . $e->getMessage()
                ];
            }
        }

        // Update product
        $success = $this->productModel->update($id, $data);

        if (!$success) {
            return [
                'success' => false,
                'message' => 'Failed to update product. Please try again.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Product updated successfully'
        ];
    }

    /**
     * Delete a product
     * @param int $id Product ID
     * @return array Result with success status and message
     */
    public function deleteProduct($id)
    {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to delete a product'
            ];
        }

        // Get product to check ownership
        $product = $this->productModel->getById($id);
        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }

        // Check if user owns the product
        $currentUser = $this->authController->getCurrentUser();
        if ($product['store_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this product'
            ];
        }

        // Delete product image if it exists
        if (!empty($product['img'])) {
            $upload = new UploadApi();
            $upload->destroy($this->extractPublicId($product['img']), []);
        }

        // Delete product
        $success = $this->productModel->delete($id);

        if (!$success) {
            return [
                'success' => false,
                'message' => 'Failed to delete product. Please try again.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Product deleted successfully'
        ];
    }

    private function extractPublicId($url)
    {
        // Extract the filename without extension
        $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
        $filename = $pathInfo['filename'];

        // If the URL is from Cloudinary, it will contain folder structure
        $parts = explode('/', $pathInfo['dirname']);
        $folder = end($parts);

        // Return the folder/filename as public_id
        return 'products/' . $filename;
    }
}
