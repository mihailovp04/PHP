<?php
require_once '../src/helpers.php';

// Включаем отладку для выявления ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Определяет маршрут на основе URL и выполняет соответствующую логику.
 * 
 * @return void
 */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim(str_replace('/recipe-book/public', '', $path), '/');

if ($route === '' || $route === 'index.php') {
    // Главная страница
    $recipes = getRecipes();
    $latestRecipes = array_slice($recipes, -2);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Книга рецептов</title>
    </head>
    <body>
        <h1>Последние рецепты</h1>
        <?php foreach ($latestRecipes as $recipe): ?>
            <div>
                <h2><?php echo htmlspecialchars($recipe->title); ?></h2>
                <p><strong>Категория:</strong> <?php echo htmlspecialchars($recipe->category); ?></p>
                <p><strong>Ингредиенты:</strong> <?php echo htmlspecialchars($recipe->ingredients); ?></p>
                <p><strong>Описание:</strong> <?php echo htmlspecialchars($recipe->description); ?></p>
                <p><strong>Тэги:</strong> <?php echo htmlspecialchars(implode(', ', $recipe->tags)); ?></p>
                <p><strong>Шаги:</strong></p>
                <ol>
                    <?php foreach ($recipe->steps as $step): ?>
                        <li><?php echo htmlspecialchars($step); ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <hr>
        <?php endforeach; ?>
        <a href="/recipe-book/public/create.php">Добавить новый рецепт</a>
        <a href="/recipe-book/public/recipes.php">Посмотреть все рецепты</a>
    </body>
    </html>
    <?php
} elseif ($route === 'create.php') {
    include 'create.php';
} elseif ($route === 'recipes.php') {
    include 'recipes.php';
} elseif ($route === 'add-recipe' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * Обрабатывает данные формы добавления рецепта, выполняет валидацию и сохранение.
     * 
     * @param array $_POST Данные формы из POST-запроса
     * @return void Перенаправляет на главную страницу или форму с ошибками
     */
    $errors = [];
    $data = [
        'title' => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS),
        'category' => filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS),
        'ingredients' => filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_SPECIAL_CHARS),
        'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS),
        'tags' => filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) ?? [],
        'steps' => filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_SPECIAL_CHARS),
        'created_at' => date('Y-m-d H:i:s')
    ];

    if (empty($data['title'])) {
        $errors['title'] = 'Название обязательно';
    }
    if (empty($data['ingredients'])) {
        $errors['ingredients'] = 'Ингредиенты обязательны';
    }

    if (!empty($errors)) {
        $query = http_build_query([
            'errors' => $errors,
            'title' => $data['title'],
            'ingredients' => $data['ingredients'],
            'description' => $data['description'],
            'steps' => $data['steps']
        ]);
        header("Location: /recipe-book/public/create.php?$query");
        exit;
    }

    $data['steps'] = array_filter(explode("\n", trim($data['steps'])));
    file_put_contents('../storage/recipes.txt', json_encode($data) . PHP_EOL, FILE_APPEND);
    header('Location: /recipe-book/public/index.php');
    exit;
} else {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>404 - Страница не найдена</title>
    </head>
    <body>
        <h1>404 - Страница не найдена</h1>
    </body>
    </html>
    <?php
}