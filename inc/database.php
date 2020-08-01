<?php

class Database
{
    private static $pdo = null;
    private static $isActive = false;

    public static function init($config)
    {
        $db_name = $config['dbname'] ?? '';
        $db_host = $config['host'] ?? '';
        $db_user = $config['username'] ?? '';
        $db_password = $config['password'] ?? '';

        $dsn = "mysql:dbname={$db_name};host={$db_host};charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        static::$isActive = true;

        try {
            static::$pdo = new PDO($dsn, $db_user, $db_password, $options);
        } catch (PDOException $e) {
            static::$isActive = false;
        }
    }

    public static function getPdo()
    {
        return static::$pdo;
    }

    public static function isActive()
    {
        return static::$isActive;
    }
}
