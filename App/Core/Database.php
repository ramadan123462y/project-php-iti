<?php

namespace App\Core;

use PDO;

class Database
{
    private static $connection;

    public static function connect()
    {
        if (!self::$connection) {

            $config = require __DIR__ . "/../../config/database.php";

            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4";

            self::$connection = new PDO($dsn, $config["user"], $config["password"]);
        }

        return self::$connection;
    }
}
