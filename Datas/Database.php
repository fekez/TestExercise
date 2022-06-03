<?php

define('SERVER_NAME', '127.0.0.1');
define('PORT', 3306);
define('DATABASE_NAME', 'porthu');
define('USER_NAME', 'root');
define('PASSWORD', '');


class Database
{
    public static function getConnection(): PDO
    {
        $conn = new PDO(
            'mysql:host=' . SERVER_NAME . ':' . PORT . ';dbname=' . DATABASE_NAME,
            USER_NAME, PASSWORD);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}