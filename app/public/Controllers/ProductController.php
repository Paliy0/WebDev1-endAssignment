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

    public function getAllProducts($filters = [])
    {
        return $this->productModel->getAll($filters);
    }

    public function getProduct($id)
    {
        return $this->productModel->getById($id);
    }

    public function getShopProducts($shopId)
    {
        return $this->productModel->getByStoreId($shopId);
    }

    public function createProduct($data, $file = null)
    {
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to create a product'
            ];
        }

        if (!$this->authController->hasRole('business')) {
            return [
                'success' => false,
                'message' => 'Only business accounts can create products'
            ];
        }

        $requiredFields = ['name', 'price', 'stock', 'shop_id'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return [
                    'success' => false,
                    'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
                ];
            }
        }

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

        $imgPath = '';
        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            try {

                $upload = new UploadApi();
                $result = $upload->upload($file['image']['tmp_name'], [
                    'folder' => 'products',
                    'public_id' => 'product_' . time(),
                    'overwrite' => true
                ]);

                $imgPath = $result['secure_url'];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Image upload failed: ' . $e->getMessage()
                ];
            }
        }

        $productData = [
            'store_id' => $data['shop_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
            'stock' => $data['stock'],
            'img' => $imgPath
        ];

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

    public function updateProduct($id, $data, $file = null)
    {
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to update a product'
            ];
        }

        $product = $this->productModel->getById($id);
        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }

        $currentUser = $this->authController->getCurrentUser();
        if ($product['store_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this product'
            ];
        }

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

        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            try {

                $upload = new UploadApi();
                $result = $upload->upload($file['image']['tmp_name'], [
                    'folder' => 'products',
                    'public_id' => 'product_' . $id . '_' . time(),
                    'overwrite' => true
                ]);

                $data['img'] = $result['secure_url'];

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

    public function deleteProduct($id)
    {
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to delete a product'
            ];
        }

        $product = $this->productModel->getById($id);
        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }

        $currentUser = $this->authController->getCurrentUser();
        if ($product['store_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this product'
            ];
        }

        if (!empty($product['img'])) {
            $upload = new UploadApi();
            $upload->destroy($this->extractPublicId($product['img']), []);
        }

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
        $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
        $filename = $pathInfo['filename'];

        // If the URL is from Cloudinary, it will contain folder structure
        $parts = explode('/', $pathInfo['dirname']);
        $folder = end($parts);

        // Return the folder/filename as public_id
        return 'products/' . $filename;
    }
}
