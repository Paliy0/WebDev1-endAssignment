<?php

namespace App\Controllers;

use \App\Services\UserService;
use \App\Models\User;

class LoginController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        //$model = $this->userService->getAll();

        require __DIR__ . '/../views/login/index.php';
    }

    public function logout()
    {
        // session_start();
        // $_SESSION['loggedin'] = false;
        // session_destroy();
        // header('Location: /login/index');
        require __DIR__ . '/../views/login/logout.php';
    }

    public function login()
    {
        echo 'Login controller method called';

        $username = $_POST['email'];
        $password = $_POST['password'];

        $loginResult = $this->userService->validateEmail($username, $password);

        switch ($loginResult) {
            case UserService::LOGIN_SUCCESS:
                // If login is successful, start a session and redirect the user to the dashboard
                session_start();
                //redirect depeding if store or customer
                header('Location: /home');
                break;
            case UserService::LOGIN_INVALID_CREDENTIALS:
                // If login credentials are invalid, display an error message
                echo "Invalid username or password";
                break;
        }
        require __DIR__ . '/../views/login/index.php';
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo 'this is a post req';

            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['confirm_password'];
            $selectedRole = $_POST["role"];

            $newUser = new User();
            $newUser->setEmail($email);
            $newUser->setPassword($password);
            $newUser->setRole($selectedRole);

            if ($this->userService->validateEmail($email)) {
                echo "Email already exists";
                return;
            } else if ($password != $passwordConfirmation) {
                echo "Passwords do not match";
                return;
            } else {
                $this->userService->save($newUser);
                header('Location: /home');
            }
        }

        require __DIR__ . '/../views/login/register.php';
    }
}
