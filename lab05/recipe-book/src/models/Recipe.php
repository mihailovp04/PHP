<?php
require_once __DIR__ . '/../db.php';

/**
 * Модель для работы с рецептами
 */
class Recipe {
    private PDO $pdo;

    /**
     * Конструктор модели
     */
    public function __construct() {
        $this->pdo = getDBConnection();
    }

    /**
     * Получить все рецепты с пагинацией
     * @param int $page Номер страницы
     * @param int $perPage Количество записей на странице
     * @return array Список рецептов
     */
    public function getAll(int $page = 1, int $perPage = 5): array {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare("SELECT * FROM recipes ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Получить общее количество рецептов
     * @return int
     */
    public function getTotalCount(): int {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM recipes")->fetchColumn();
    }

    /**
     * Получить рецепт по ID
     * @param int $id ID рецепта
     * @return array|null Данные рецепта или null
     */
    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM recipes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Создать новый рецепт
     * @param array $data Данные рецепта
     * @return bool Успешность операции
     */
    public function create(array $data): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO recipes (title, category, ingredients, description, tags, steps)
            VALUES (:title, :category, :ingredients, :description, :tags, :steps)
        ");
        return $stmt->execute([
            'title' => $data['title'],
            'category' => $data['category'],
            'ingredients' => $data['ingredients'],
            'description' => $data['description'],
            'tags' => $data['tags'],
            'steps' => $data['steps'],
        ]);
    }

    /**
     * Обновить рецепт
     * @param int $id ID рецепта
     * @param array $data Новые данные
     * @return bool Успешность операции
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare("
            UPDATE recipes
            SET title = :title, category = :category, ingredients = :ingredients,
                description = :description, tags = :tags, steps = :steps
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'category' => $data['category'],
            'ingredients' => $data['ingredients'],
            'description' => $data['description'],
            'tags' => $data['tags'],
            'steps' => $data['steps'],
        ]);
    }

    /**
     * Удалить рецепт
     * @param int $id ID рецепта
     * @return bool Успешность операции
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM recipes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}