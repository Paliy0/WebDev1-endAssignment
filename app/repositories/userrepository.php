<?php

namespace App\Repositories;

use App\Models\User;

use PDO;
use PDOException;

class UserRepository extends Repository
{

    public function save(User $user)
    {
        try {
            if ($user->getId()) {
                // Update existing user
                $query = 'UPDATE users SET email = :email, password = :password WHERE id = :id';
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



    public function getByEmail($email)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\\Models\\User');
            $row = $stmt->fetch();

            if (!$row) {
                return null;
            }

            $user = new User();
            $user->setId($row['id']);
            $user->setEmail($row['email']);
            $user->setPassword($row['password']);
            $user->setRole($row['role']);
            $user->setCreatedAt($row['created_at']);
            $user->setUpdatedAt($row['updated_at']);

            return $user;
        } catch (PDOException $e) {
            // Handle any exceptions that occur during execution
            echo "Error: " . $e->getMessage();
            return false;
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
