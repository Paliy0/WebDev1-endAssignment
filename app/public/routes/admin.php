<?php

use App\Controllers\AdminController;

Route::add('/admin/dashboard', function () {
    $adminController = new AdminController();
    $adminController->dashboard();
});

Route::add('/admin/users', function () {
    $adminController = new AdminController();
    $adminController->getAllUsers();
});

Route::add('/admin/users/edit/([0-9]+)', function ($userId) {
    $adminController = new AdminController();
    $adminController->editUser($userId);
});

Route::add('/admin/users/delete/([0-9]+)', function ($userId) {
    $adminController = new AdminController();
    $adminController->deleteUser($userId);
}, 'post');

Route::add('/admin/users/create', function () {
    $adminController = new AdminController();
    $adminController->createUser();
}, 'post');

Route::add('/admin/shops', function () {
    $adminController = new AdminController();
    $adminController->getAllShops();
});

Route::add('/admin/shops/edit/([0-9]+)', function ($shopId) {
    $adminController = new AdminController();
    $adminController->editShop($shopId);
});

Route::add('/admin/shops/delete/([0-9]+)', function ($shopId) {
    $adminController = new AdminController();
    $adminController->deleteShop($shopId);
}, 'post');

Route::add('/admin/shops/create', function () {
    $adminController = new AdminController();
    $adminController->createShop();
}, 'post');