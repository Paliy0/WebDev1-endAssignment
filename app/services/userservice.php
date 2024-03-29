<?php

namespace App\Services;

use Exception;

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new \App\Repository\UserRepository();
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function validate($user)
    {
        $errors = array();

        if (empty($user->getUsername())) {
            $errors['username'] = 'Username is required';
        }

        if (empty($user->getPassword())) {
            $errors['password'] = 'Password is required';
        }

        // Additional validation for other fields, such as name, address, etc.
        return $errors;
    }

    public function validateLogin($username, $password)
    {
        $errors = array();

        if (empty($username)) {
            $errors['username'] = 'Username is required';
        }

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }

    public function register($user)
    {
        // Hash the password before saving it to the database
        $password = $user->getPassword();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
    }

    public function login($username, $password)
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user) {
            throw new Exception('User not found');
        }

        $passwordIsValid = password_verify($password, $user->getPassword());

        if (!$passwordIsValid) {
            throw new Exception('Invalid password');
        }

        return $user;
    }
}
