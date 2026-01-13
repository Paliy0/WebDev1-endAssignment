<?php

use App\Controllers\AuthController;
use App\Controllers\ShopController;

// Login page route
Route::add('/login', function () {
    require(__DIR__ . "/../views/pages/login.php");
}, 'get');

// Login form processing
Route::add('/login', function () {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $authController = new AuthController();
    $success = $authController->login($email, $password);

    if ($success) {
        header('Location: /');
        exit;
    } else {
        $_SESSION['error'] = 'Invalid credentials. Please try again.';
        header('Location: /login');
        exit;
    }
}, 'post');

// Register page route
Route::add('/register', function () {
    require(__DIR__ . "/../views/pages/register.php");
}, 'get');

// Register form processing
Route::add('/register', function () {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $role = $_POST['role'] ?? '';

    $authController = new AuthController();
    $result = $authController->register($email, $password, $passwordConfirm, $role);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header('Location: /login');
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /register');
        exit;
    }
}, 'post');

// Logout route
Route::add('/logout', function () {
    $authController = new AuthController();
    $authController->logout();

    header('Location: /login');
    exit;
}, 'get');

// Profile page route
Route::add('/profile', function () {
    $authController = new AuthController();
    $shopController = new ShopController();

    if (!$authController->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    $user = $authController->getCurrentUser();
    $shops = $shopController->getUserShops();

    require(__DIR__ . "/../views/pages/profile/profile.php");
}, 'get');

Route::add('/profile/edit', function () {
    $authController = new AuthController();
    $shopController = new ShopController();

    if (!$authController->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    $user = $authController->getCurrentUser();
    $shops = $shopController->getUserShops();

    require(__DIR__ . "/../views/pages/profile/edit.php");
}, 'get');

// Handle profile edit form submission
Route::add('/profile/edit', function () {
    $authController = new AuthController();

    if (!$authController->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    $email = $_POST['email'] ?? '';
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $result = $authController->updateProfile($email, $currentPassword, $newPassword, $confirmPassword);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }

    header('Location: /profile/edit');
    exit;
}, 'post');
