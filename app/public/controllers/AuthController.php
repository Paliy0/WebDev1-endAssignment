<?php

require_once(__DIR__ . "/../models/UserModel.php");

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login($email, $password)
    {
        $user = $this->userModel->verifyPassword($email, $password);

        if (!$user) {
            return false;
        }

        // Set user session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true;

        return true;
    }

    public function register($email, $password, $passwordConfirm, $role)
    {
        // Validate inputs
        if (empty($email) || empty($password) || empty($passwordConfirm) || empty($role)) {
            return [
                'success' => false,
                'message' => 'All fields are required'
            ];
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format'
            ];
        }

        // Check if passwords match
        if ($password !== $passwordConfirm) {
            return [
                'success' => false,
                'message' => 'Passwords do not match'
            ];
        }

        // Check password length
        if (strlen($password) < 8) {
            return [
                'success' => false,
                'message' => 'Password must be at least 8 characters'
            ];
        }

        // Check if email already exists
        if ($this->userModel->findByEmail($email)) {
            return [
                'success' => false,
                'message' => 'Email already in use'
            ];
        }

        // Validate role
        if (!in_array($role, ['customer', 'business'])) {
            return [
                'success' => false,
                'message' => 'Invalid role selected'
            ];
        }

        // Create user
        $userId = $this->userModel->create($email, $password, $role);

        if (!$userId) {
            return [
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Registration successful. You can now log in.',
            'user_id' => $userId
        ];
    }

    public function logout()
    {
        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        return true;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function getCurrentUser()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }

        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['email'],
            'role' => $_SESSION['role']
        ];
    }

    public function hasRole($role)
    {
        if (!$this->isLoggedIn()) {
            return false;
        }

        return $_SESSION['role'] === $role;
    }
}
