<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ShopModel;
use App\Controllers\AuthController;

class AdminController
{
    private $userModel;
    private $shopModel;
    private $authController;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->shopModel = new ShopModel();
        $this->authController = new AuthController();
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        // Redirect if not admin
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        // Simple dashboard, perhaps stats
        $userCount = count($this->userModel->getAll());
        $shopCount = count($this->shopModel->getAll());

        require __DIR__ . '/../views/pages/admin_dashboard.php';
    }

    /**
     * List all users
     */
    public function getAllUsers()
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        $users = $this->userModel->getAll();
        require __DIR__ . '/../views/pages/admin_users.php';
    }

    /**
     * Edit user form
     */
    public function editUser($id)
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            header('Location: /admin/users');
            exit;
        }

        if ($user['role'] === 'admin') {
            $_SESSION['error'] = 'Cannot edit admin user';
            header('Location: /admin/users');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $result = $this->updateUser($id, $data);
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: /admin/users');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: /admin/users');
                exit;
            }
        }

        // If GET request (not used with modal, but kept for backward compatibility)
        require __DIR__ . '/../views/pages/admin_user_edit.php';
    }

    /**
     * Update user
     */
    private function updateUser($id, $data)
    {
        // Validate email
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Valid email is required'];
        }

        // Validate role
        $validRoles = ['customer', 'business'];
        if (empty($data['role']) || !in_array($data['role'], $validRoles)) {
            return ['success' => false, 'message' => 'Valid role is required'];
        }

        $updateData = ['email' => $data['email'], 'role' => $data['role']];
        $success = $this->userModel->updateAdmin($id, $updateData);

        if (!$success) {
            return ['success' => false, 'message' => 'Failed to update user'];
        }

        return ['success' => true, 'message' => 'User updated successfully'];
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        $currentUser = $this->authController->getCurrentUser();
        if ($currentUser['id'] == $id) {
            $_SESSION['error'] = 'Cannot delete yourself';
            header('Location: /admin/users');
            exit;
        }

        $success = $this->userModel->delete($id);
        if ($success) {
            $_SESSION['success'] = 'User deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }

        header('Location: /admin/users');
        exit;
    }

    /**
     * Create user
     */
    public function createUser()
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Validate email
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Valid email is required';
                header('Location: /admin/users');
                exit;
            }

            // Validate password
            if (empty($data['password']) || strlen($data['password']) < 8) {
                $_SESSION['error'] = 'Password must be at least 8 characters';
                header('Location: /admin/users');
                exit;
            }

            // Validate role
            if (empty($data['role']) || !in_array($data['role'], ['customer', 'business'])) {
                $_SESSION['error'] = 'Valid role is required';
                header('Location: /admin/users');
                exit;
            }

            // Check if email already exists
            $existingUser = $this->userModel->findByEmail($data['email']);
            if ($existingUser) {
                $_SESSION['error'] = 'Email already exists';
                header('Location: /admin/users');
                exit;
            }

            // Create user
            $userData = [
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role' => $data['role']
            ];

            $success = $this->userModel->create($userData);
            if ($success) {
                $_SESSION['success'] = 'User created successfully';
            } else {
                $_SESSION['error'] = 'Failed to create user';
            }

            header('Location: /admin/users');
            exit;
        }

        // If GET request, redirect to users list
        header('Location: /admin/users');
        exit;
    }

    /**
     * List all shops
     */
    public function getAllShops()
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        $shops = $this->shopModel->getAll();

        // Get business users for owner dropdown in edit modal
        $businessUsers = array_filter($this->userModel->getAll(), function($user) {
            return $user['role'] === 'business';
        });

        require __DIR__ . '/../views/pages/admin_shops.php';
    }

    /**
     * Edit shop form
     */
    public function editShop($id)
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        $shop = $this->shopModel->getById($id);
        if (!$shop) {
            $_SESSION['error'] = 'Shop not found';
            header('Location: /admin/shops');
            exit;
        }

        // Get business users for owner dropdown
        $businessUsers = array_filter($this->userModel->getAll(), function($user) {
            return $user['role'] === 'business';
        });

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $result = $this->updateShop($id, $data);
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: /admin/shops');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: /admin/shops');
                exit;
            }
        }

        // If GET request (not used with modal, but kept for backward compatibility)
        require __DIR__ . '/../views/pages/admin_shop_edit.php';
    }

    /**
     * Update shop
     */
    private function updateShop($id, $data)
    {
        // Validate required fields
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Name is required'];
        }

        // Validate owner
        if (empty($data['owner_id'])) {
            return ['success' => false, 'message' => 'Owner is required'];
        }

        $updateData = [
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'address' => $data['address'] ?? '',
            'contact_email' => $data['contact_email'] ?? '',
            'contact_number' => $data['contact_number'] ?? '',
            'user_id' => $data['owner_id']  // Note: owner_id in form, but column is user_id
        ];

        $success = $this->shopModel->update($id, $updateData);

        if (!$success) {
            return ['success' => false, 'message' => 'Failed to update shop'];
        }

        return ['success' => true, 'message' => 'Shop updated successfully'];
    }

    /**
     * Delete shop
     */
    public function deleteShop($id)
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        $success = $this->shopModel->delete($id);
        if ($success) {
            $_SESSION['success'] = 'Shop deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete shop';
        }

        header('Location: /admin/shops');
        exit;
    }

    /**
     * Create shop
     */
    public function createShop()
    {
        if (!$this->authController->hasRole('admin')) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Validate name
            if (empty($data['name'])) {
                $_SESSION['error'] = 'Shop name is required';
                header('Location: /admin/shops');
                exit;
            }

            // Validate owner
            if (empty($data['owner_id'])) {
                $_SESSION['error'] = 'Owner is required';
                header('Location: /admin/shops');
                exit;
            }

            // Verify owner exists and is a business user
            $owner = $this->userModel->findById($data['owner_id']);
            if (!$owner || $owner['role'] !== 'business') {
                $_SESSION['error'] = 'Invalid owner selected';
                header('Location: /admin/shops');
                exit;
            }

            // Create shop
            $shopData = [
                'name' => $data['name'],
                'description' => $data['description'] ?? '',
                'address' => $data['address'] ?? '',
                'contact_email' => $data['contact_email'] ?? '',
                'contact_number' => $data['contact_number'] ?? '',
                'user_id' => $data['owner_id']
            ];

            $success = $this->shopModel->create($shopData);
            if ($success) {
                $_SESSION['success'] = 'Shop created successfully';
            } else {
                $_SESSION['error'] = 'Failed to create shop';
            }

            header('Location: /admin/shops');
            exit;
        }

        // If GET request, redirect to shops list
        header('Location: /admin/shops');
        exit;
    }
}