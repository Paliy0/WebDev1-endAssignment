<?php

use App\Controllers\UserController;

Route::add('/users', function () {
    $userController = new UserController(); // create a new user controller
    $users = $userController->getAll(); // get data data for the view
    require_once(__DIR__ . "/../views/pages/users.php"); // load the view
});


Route::add('/user/([a-z-0-9-]*)', function ($userId) {
    $userController = new UserController(); // create a new user controller
    $user = $userController->get($userId); // get data for the view
    require_once(__DIR__ . "/../views/pages/user.php"); // load the view
});
