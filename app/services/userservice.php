<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class UserService
{
    const LOGIN_SUCCESS = 1;
    const LOGIN_INVALID_CREDENTIALS = 2;
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function validateEmail($email)
    {
        $user = $this->userRepository->getByEmail($email);

        if (empty($user)) {
            return false;
        }
    }

    public function save($user)
    {
        // Hash the password before saving it to the database
        $password = $user->getPassword();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
    }

    public function login($username, $password)
    {
        $user = $this->userRepository->getByEmail($username);

        // Verify if the provided password matches the hashed password stored in the database
        if ($user != null && password_verify($password, $user->getPassword())) {
            $_SESSION['loggedin'] = $user->getId();
            return self::LOGIN_SUCCESS;
        } else {
            return self::LOGIN_INVALID_CREDENTIALS;
        }
    }
}
