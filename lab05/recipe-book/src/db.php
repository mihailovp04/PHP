<?php
/**
 * Подключение к базе данных через PDO
 * @return PDO
 * @throws PDOException
 */
function getDBConnection(): PDO {
    $config = require __DIR__ . '/../config/db.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";
    
    try {
        $pdo = new PDO($dsn, $config['user'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}