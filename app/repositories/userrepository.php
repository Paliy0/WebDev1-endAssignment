<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;

use PDO;
use PDOException;

class UserRepository extends Repository
{

    public function save(User $user)
    {
        try {
            if ($user->getId()) {
                // Update existing user
                $query = 'UPDATE users SET email = :email, password = :password WHERE user_id = :id';
                $stmt = $this->connection->prepare($query);
                $stmt->bindValue(':email', $user->getEmail());
                $stmt->bindValue(':password', $user->getPassword());
                $stmt->bindValue(':id', $user->getId());
            } else {
                // Insert new user
                $query = 'INSERT INTO users (email, password, role) VALUES (:email, :password, :role)';
                $stmt = $this->connection->prepare($query);
                $stmt->bindValue(':email', $user->getEmail());
                $stmt->bindValue(':password', $user->getPassword());
                $stmt->bindValue(':role', $user->getRole());
            }

            // Execute the prepared statement
            $success = $stmt->execute();

            // Return true if the execution was successful, otherwise false
            return $success;
        } catch (PDOException $e) {
            // Handle any exceptions that occur during execution
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function insert(User $user): bool
    {
        try {
            $query = 'INSERT INTO users (email, password, role) VALUES (:email, :password, :role)';
            $stmt = $this->connection->prepare($query);

            $params = [
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':role' => $user->getRole()->name
            ];

            $success = $stmt->execute($params);

            if ($success) {
                // Set the auto-generated ID back on the user object
                $user->setId($this->connection->lastInsertId());
            }

            return $success;
        } catch (PDOException $e) {
            // Check for duplicate entry error (MySQL error code 1062)
            if ($e->getCode() == '23000') {
                throw new \Exception('Email already exists');
            }
            throw new \Exception('Database error: ' . $e->getMessage());
        }
    }



    public function getByEmail(string $email): ?User
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            $user = new User();
            $user->setId($row['user_id'])
                ->setEmail($row['email'])
                ->setPassword($row['password'])
                ->setRole(match ($row['role']) {
                    'customer' => Role::customer,
                    'business' => Role::business,
                    'admin' => Role::admin,
                    default => throw new \Exception('Invalid role in database')
                })
                ->setCreatedAt($row['created_at'])
                ->setUpdatedAt($row['updated_at']);

            return $user;
        } catch (PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage());
        }
    }


    function getAll()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\\Models\\User');
            $users = $stmt->fetchAll();
            return $users;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
