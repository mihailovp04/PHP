<?php
require_once __DIR__ . '/../db.php';

/**
 * Модель для работы с категориями
 */
class Category {
    private PDO $pdo;

    /**
     * Конструктор модели
     */
    public function __construct() {
        $this->pdo = getDBConnection();
    }

    /**
     * Получить все категории
     * @return array Список категорий
     */
    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Получить категорию по ID
     * @param int $id ID категории
     * @return array|null Данные категории или null
     */
    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}