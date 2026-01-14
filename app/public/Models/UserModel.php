<?php

namespace App\Models;

use PDO;
use PDOException;

class UserModel extends BaseModel
{
    public function __construct()
    {
        new BaseModel();
    }

    public function create($email, $password, $role)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = self::$pdo->prepare("
                INSERT INTO users (email, password, role, created_at) 
                VALUES (:email, :password, :role, NOW())
            ");

            $stmt->execute([
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);

            return self::$pdo->lastInsertId();
        } catch (PDOException $e) {
            // Log error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Find user by email
     * @param string $email User email
     * @return array|bool User data or false if not found
     */
    public function findByEmail($email)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT * FROM users WHERE email = :email LIMIT 1
            ");

            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? $user : false;
        } catch (PDOException $e) {
            // Log error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Find user by ID
     * @param int $id User ID
     * @return array|bool User data or false if not found
     */
    public function findById($id)
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT * FROM users WHERE user_id = :user_id LIMIT 1
            ");

            $stmt->execute([':user_id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? $user : false;
        } catch (PDOException $e) {
            // Log error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Get all users
     * @return array Array of users
     */
    public function getAll()
    {
        try {
            $stmt = self::$pdo->prepare("
                SELECT user_id as id, email, role, created_at
                FROM users
                ORDER BY created_at DESC
            ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Update user profile (limited fields)
     * @param int $id User ID
     * @param array $data User data to update
     * @return bool Success or failure
     */
    public function update($id, $data)
    {
        try {
            $allowedFields = ['email'];
            $sets = [];
            $params = [':user_id' => $id];

            foreach ($data as $key => $value) {
                if (in_array($key, $allowedFields)) {
                    $sets[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }

            if (empty($sets)) {
                return false;
            }

            $sql = "UPDATE users SET " . implode(', ', $sets) . " WHERE user_id = :user_id";
            $stmt = self::$pdo->prepare($sql);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Log error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Update user by admin (includes role)
     * @param int $id User ID
     * @param array $data User data to update
     * @return bool Success or failure
     */
    public function updateAdmin($id, $data)
    {
        try {
            $allowedFields = ['email', 'role'];
            $sets = [];
            $params = [':user_id' => $id];

            foreach ($data as $key => $value) {
                if (in_array($key, $allowedFields)) {
                    $sets[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }

            if (empty($sets)) {
                return false;
            }

            $sql = "UPDATE users SET " . implode(', ', $sets) . " WHERE user_id = :user_id";
            $stmt = self::$pdo->prepare($sql);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Log error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Delete user
     * @param int $id User ID
     * @return bool Success or failure
     */
    public function delete($id)
    {
        try {
            $stmt = self::$pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
            return $stmt->execute([':user_id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Update user password
     * @param int $id User ID
     * @param string $password New password (will be hashed)
     * @return bool Success or failure
     */
    public function updatePassword($id, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = self::$pdo->prepare("
                UPDATE users 
                SET password = :password 
                WHERE id = :id
            ");

            return $stmt->execute([
                ':id' => $id,
                ':password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            // Log error
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Verify password for a given user
     * @param string $email User email
     * @param string $password Password to verify
     * @return array|bool User data if successful, false otherwise
     */
    public function verifyPassword($email, $password)
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
