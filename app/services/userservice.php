<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Repositories\UserRepository;
use App\Exceptions\User\InvalidRoleException;
use App\Exceptions\User\EmailAlreadyExistsException;

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

    public function createUser(string $email, string $password, string $roleStr): User
    {
        // Check if email exists
        if ($this->validateEmail($email)) {
            throw new \Exception('Email already exists');
        }

        // Convert string role to Role enum
        $role = match (strtolower($roleStr)) {
            'customer' => Role::customer,
            'business' => Role::business,
            'admin' => Role::admin,
            default => throw new \Exception('Invalid role')
        };

        // Create and set up user
        $user = new User();
        $user->setEmail($email)
            ->setPassword($this->hashPassword($password))
            ->setRole($role);  // Now passing the Role enum

        // Save user
        if (!$this->userRepository->insert($user)) {
            throw new \Exception('Failed to create user');
        }

        return $user;
    }

    public function login(string $email, string $password): ?User
    {
        try {
            $user = $this->userRepository->getByEmail($email);

            if (!$user) {
                throw new \Exception('Invalid email or password');
            }

            if (!password_verify($password, $user->getPassword())) {
                throw new \Exception('Invalid email or password');
            }

            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function validateEmail($email)
    {
        $user = $this->userRepository->getByEmail($email);

        if (!empty($user)) {
            return true;
        }
        return false;
    }

    public function save($user)
    {
        // Hash the password before saving it to the database
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);

        return $this->userRepository->save($user);
    }
}
