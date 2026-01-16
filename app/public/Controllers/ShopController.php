<?php

namespace App\Controllers;

use App\Models\ShopModel;
use App\Controllers\AuthController;
use Cloudinary\Api\Upload\UploadApi;

class ShopController
{
    private $shopModel;
    private $authController;

    public function __construct()
    {
        $this->shopModel = new ShopModel();
        $this->authController = new AuthController();
    }

    public function getAllShops()
    {
        return $this->shopModel->getAll();
    }

    public function getShop($id)
    {
        return $this->shopModel->getById($id);
    }

    public function getUserShops()
    {
        if (!$this->authController->isLoggedIn()) {
            return [];
        }

        $currentUser = $this->authController->getCurrentUser();
        return $this->shopModel->getByUserId($currentUser['id']);
    }

    public function createShop($data, $file = null)
    {
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to create a shop'
            ];
        }

        if (!$this->authController->hasRole('business')) {
            return [
                'success' => false,
                'message' => 'Only business accounts can create shops'
            ];
        }

        $requiredFields = ['name', 'description', 'contact_email'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return [
                    'success' => false,
                    'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
                ];
            }
        }

        if (!filter_var($data['contact_email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format'
            ];
        }

        $imgPath = '';
        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $upload = new UploadApi();
                $result = $upload->upload($file['image']['tmp_name'], [
                    'folder' => 'shops',
                    'public_id' => 'shop_' . time(),
                    'overwrite' => true
                ]);
                $imgPath = $result['secure_url'];
            } catch (\Exception $e) {
                error_log('Cloudinary upload error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Image upload failed: ' . $e->getMessage()
                ];
            }
        }

        $currentUser = $this->authController->getCurrentUser();
        $shopData = [
            'owner_id' => $currentUser['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'address' => $data['address'] ?? null,
            'contact_email' => $data['contact_email'],
            'contact_number' => $data['contact_number'] ?? null,
            'img' => $imgPath
        ];

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

    public function updateShop($id, $data, $file = null)
    {
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to update a shop'
            ];
        }

        $shop = $this->shopModel->getById($id);
        if (!$shop) {
            return [
                'success' => false,
                'message' => 'Shop not found'
            ];
        }

        $currentUser = $this->authController->getCurrentUser();
        if ($shop['owner_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this shop'
            ];
        }

        if (isset($data['contact_email']) && !filter_var($data['contact_email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format'
            ];
        }

        if ($file && isset($file['image']) && $file['image']['error'] === UPLOAD_ERR_OK) {
            try {
                $upload = new UploadApi();
                $result = $upload->upload($file['image']['tmp_name'], [
                    'folder' => 'shops',
                    'public_id' => 'shop_' . time(),
                    'overwrite' => true
                ]);
                $data['img'] = $result['secure_url'];

                if (!empty($shop['img'])) {
                    $publicId = extract_cloudinary_public_id($shop['img']);
                    if ($publicId) {
                        try {
                            $upload->destroy($publicId, ['resource_type' => 'image']);
                        } catch (\Exception $e) {
                            error_log('Failed to delete old Cloudinary image: ' . $e->getMessage());
                        }
                    }
                }
            } catch (\Exception $e) {
                error_log('Cloudinary upload error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Image upload failed: ' . $e->getMessage()
                ];
            }
        }

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

    public function deleteShop($id)
    {
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to delete a shop'
            ];
        }

        $shop = $this->shopModel->getById($id);
        if (!$shop) {
            return [
                'success' => false,
                'message' => 'Shop not found'
            ];
        }

        $currentUser = $this->authController->getCurrentUser();
        if ($shop['owner_id'] != $currentUser['id']) {
            return [
                'success' => false,
                'message' => 'You do not own this shop'
            ];
        }

        if (!empty($shop['img'])) {
            $publicId = extract_cloudinary_public_id($shop['img']);
            if ($publicId) {
                try {
                    $upload = new UploadApi();
                    $upload->destroy($publicId, ['resource_type' => 'image']);
                } catch (\Exception $e) {
                    error_log('Failed to delete Cloudinary image: ' . $e->getMessage());
                }
            }
        }

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
