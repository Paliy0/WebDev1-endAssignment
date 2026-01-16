<?php

/**
 * NOTE! this base model handles initializing PDO
 * 
 * To use PDO in a derived class, use self::$pdo
 */

namespace App\Models;

use PDO;

class BaseModel
{

    protected static $pdo;

    function __construct()
    {
        if (!self::$pdo) {

            $host = $_ENV["DB_HOST"];
            $port = $_ENV["DB_PORT"] ?? 3306;
            $db = $_ENV["DB_NAME"];
            $user = $_ENV["DB_USER"];
            $pass = $_ENV["DB_PASSWORD"];
            $charset = $_ENV["DB_CHARSET"];

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            self::$pdo = new PDO($dsn, $user, $pass, $options);
        }
    }
}
