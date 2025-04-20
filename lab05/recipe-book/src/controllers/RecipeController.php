<?php
require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../helpers.php';

/**
 * Контроллер для управления рецептами
 */
class RecipeController {
    private Recipe $recipeModel;
    private Category $categoryModel;

    /**
     * Конструктор контроллера
     */
    public function __construct() {
        $this->recipeModel = new Recipe();
        $this->categoryModel = new Category();
    }

    /**
     * Отобразить список рецептов с пагинацией
     */
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 5;
        $recipes = $this->recipeModel->getAll($page, $perPage);
        $totalPages = ceil($this->recipeModel->getTotalCount() / $perPage);
        $categories = array_column($this->categoryModel->getAll(), null, 'id');
        require_once __DIR__ . '/../../templates/index.php';
    }

    /**
     * Отобразить форму создания рецепта
     */
    public function create() {
        $categories = $this->categoryModel->getAll();
        $errors = [];
        require_once __DIR__ . '/../../templates/recipe/create.php';
    }

    /**
     * Сохранить новый рецепт
     */
    public function store() {
        $data = [
            'title' => $_POST['title'] ?? '',
            'category' => $_POST['category'] ?? '',
            'ingredients' => $_POST['ingredients'] ?? '',
            'description' => $_POST['description'] ?? '',
            'tags' => $_POST['tags'] ?? '',
            'steps' => $_POST['steps'] ?? '',
        ];
        $errors = $this->validate($data);

        if (empty($errors)) {
            if ($this->recipeModel->create($data)) {
                redirect(BASE_URL);
            } else {
                $errors['general'] = 'Ошибка при сохранении рецепта';
            }
        }

        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../../templates/recipe/create.php';
    }

    /**
     * Отобразить рецепт
     * @param int $id ID рецепта
     */
    public function show($id) {
        $recipe = $this->recipeModel->find($id);
        if (!$recipe) {
            die('Рецепт не найден');
        }
        $category = $this->categoryModel->find($recipe['category']);
        if (!$category) {
            die('Категория не найдена');
        }
        require_once __DIR__ . '/../../templates/recipe/show.php';
    }

    /**
     * Отобразить форму редактирования
     * @param int $id ID рецепта
     */
    public function edit($id) {
        $recipe = $this->recipeModel->find($id);
        if (!$recipe) {
            die('Рецепт не найден');
        }
        $categories = $this->categoryModel->getAll();
        $errors = [];
        require_once __DIR__ . '/../../templates/recipe/edit.php';
    }

    /**
     * Обновить рецепт
     * @param int $id ID рецепта
     */
    public function update($id) {
        $recipe = $this->recipeModel->find($id);
        if (!$recipe) {
            die('Рецепт не найден');
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'category' => $_POST['category'] ?? '',
            'ingredients' => $_POST['ingredients'] ?? '',
            'description' => $_POST['description'] ?? '',
            'tags' => $_POST['tags'] ?? '',
            'steps' => $_POST['steps'] ?? '',
        ];
        $errors = $this->validate($data);

        if (empty($errors)) {
            if ($this->recipeModel->update($id, $data)) {
                redirect(BASE_URL . "?action=show&id=$id");
            } else {
                $errors['general'] = 'Ошибка при обновлении рецепта';
            }
        }

        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../../templates/recipe/edit.php';
    }

    /**
     * Удалить рецепт
     * @param int $id ID рецепта
     */
    public function delete($id) {
        $recipe = $this->recipeModel->find($id);
        if (!$recipe) {
            die('Рецепт не найден');
        }
        $this->recipeModel->delete($id);
        redirect(BASE_URL);
    }

    /**
     * Валидация данных рецепта
     * @param array $data Данные формы
     * @return array Ошибки валидации
     */
    private function validate(array $data): array {
        $errors = [];
        if (empty($data['title'])) {
            $errors['title'] = 'Название обязательно';
        } elseif (strlen($data['title']) > 255) {
            $errors['title'] = 'Название слишком длинное';
        }
        if (empty($data['category']) || !$this->categoryModel->find($data['category'])) {
            $errors['category'] = 'Выберите действительную категорию';
        }
        return $errors;
    }
}