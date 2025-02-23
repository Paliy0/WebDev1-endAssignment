<?php

namespace App\Controllers;

use \App\Services\UserService;
use \App\Models\Role;

class LoginController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            require __DIR__ . '/../views/login/index.php';
            return;
        }

        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                throw new \Exception('Email and password are required');
            }

            $user = $this->userService->login($email, $password);

            // Set session variables
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_role'] = $user->getRole()->name;
            $_SESSION['user_email'] = $user->getEmail();

            // Redirect based on role
            switch ($user->getRole()) {
                case Role::business:
                    header('Location: /shop/dashboard');
                    break;
                case Role::admin:
                    header('Location: /admin/dashboard');
                    break;
                default:
                    header('Location: /home');
            }
            exit();
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            require __DIR__ . '/../views/login/index.php';
        }
    }

    public function logout()
    {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header('Location: /login');
        exit();
    }

    public function register()
    {
        // If already logged in, redirect to home
        if (isset($_SESSION['user_id'])) {
            header('Location: /home');
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $passwordConfirmation = $_POST['confirm_password'] ?? '';
                $selectedRole = $_POST["role"] ?? '';

                if ($password !== $passwordConfirmation) {
                    throw new \Exception('Passwords do not match');
                }

                $user = $this->userService->createUser($email, $password, $selectedRole);

                // Set session variables
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_role'] = $user->getRole()->name;
                $_SESSION['user_email'] = $user->getEmail();

                header('Location: /home');
                exit();
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        require __DIR__ . '/../views/login/register.php';
    }
}
