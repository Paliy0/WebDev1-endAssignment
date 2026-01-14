<?php

use App\Controllers\AuthController;
use App\Controllers\ShopController;

Route::add('/login', function () {
    require(__DIR__ . "/../views/pages/login.php");
}, 'get');

Route::add('/login', function () {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $authController = new AuthController();
    $success = $authController->login($email, $password);

    if ($success) {
        $redirect = $authController->hasRole('admin') ? '/admin/dashboard' : '/';
        header('Location: ' . $redirect);
        exit;
    } else {
        $_SESSION['error'] = 'Invalid credentials. Please try again.';
        header('Location: /login');
        exit;
    }
}, 'post');

Route::add('/register', function () {
    require(__DIR__ . "/../views/pages/register.php");
}, 'get');

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

Route::add('/logout', function () {
    $authController = new AuthController();
    $authController->logout();

    header('Location: /login');
    exit;
}, 'get');

Route::add('/profile', function () {
    $authController = new AuthController();
    $shopController = new ShopController();

    if (!$authController->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    $user = $authController->getCurrentUser();
    $shops = $shopController->getUserShops();

    require(__DIR__ . "/../views/pages/users/profile.php");
}, 'get');
