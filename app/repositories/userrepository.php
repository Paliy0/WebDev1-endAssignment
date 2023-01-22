<?php
require __DIR__ . '/repository.php';
require __DIR__ . '/../models/user.php';
class UserRepository extends Repository
{

    public function save(User $user)
    {
        if ($user->getId()) {
            // Update existing user
            $query = 'UPDATE users SET username = :username, password = :password WHERE id = :id';
            $stmt = $this->prepare($query);
            $stmt->bindValue(':username', $user->getUsername());
            $stmt->bindValue(':password', $user->getPassword());
            $stmt->bindValue(':id', $user->getId());
            $stmt->execute();
        } else {
            // Insert new user
            $query = 'INSERT INTO user (username, password) VALUES (:username, :password)';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':username', $user->getUsername());
            $stmt->bindValue(':password', $user->getPassword());
            $stmt->execute();
        }
    }

    public function findByUsername($username)
    {
        $query = 'SELECT * FROM  WHERE username = :username';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $username);
        $stmt->execute();
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $user = new User();
        $user->setId($row['id']);
        $user->setUsername($row['username']);
        $user->setPassword($row['password']);

        return $user;
    }

    function getAll()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM user");
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $users = $stmt->fetchAll();

            return $users;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
