<?php

namespace App\Core;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $instance = null;

    private const OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false,
    ];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): PDO
    {
        try {
            if (self::$instance === null) {

                $host = DB_HOST;
                $port = DB_PORT;
                $database = DB_DATABASE;
                $charset = DB_CHARSET;
                $username = DB_USERNAME;
                $password = DB_PASSWORD;

                $dsn = sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                    $host,
                    $port,
                    $database,
                    $charset
                );

                self::$instance = new PDO(
                    $dsn,
                    $username,
                    $password,
                    self::OPTIONS
                );
            }
        } catch (PDOException $PDOException) {
            throw new \RuntimeException("Erro na conexão: " . $PDOException->getMessage(), 500);
        }

        return self::$instance;
    }
}