<?php

require_once(__DIR__ . "/BaseModel.php");

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
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
                SELECT * FROM users WHERE id = :id LIMIT 1
            ");

            $stmt->execute([':id' => $id]);
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
                SELECT id, username, email, role, created_at 
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
     * Update user profile
     * @param int $id User ID
     * @param array $data User data to update
     * @return bool Success or failure
     */
    public function update($id, $data)
    {
        try {
            $allowedFields = ['username', 'email'];
            $sets = [];
            $params = [':id' => $id];

            foreach ($data as $key => $value) {
                if (in_array($key, $allowedFields)) {
                    $sets[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }

            if (empty($sets)) {
                return false;
            }

            $sql = "UPDATE users SET " . implode(', ', $sets) . " WHERE id = :id";
            $stmt = self::$pdo->prepare($sql);

            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Log error
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
