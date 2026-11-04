<?php

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnexion(): PDO
    {
        if (self::$pdo === null) {
            $config = parse_ini_file(__DIR__ . '/../config/database.ini');

            self::$pdo = new PDO(
                "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset=utf8mb4",
                $config['username'],
                $config['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        }

        return self::$pdo;
    }
}
