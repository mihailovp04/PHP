<?php
/**
 * Базовый шаблон для всех страниц
 * @var string $title Заголовок страницы
 * @var string $content Содержимое страницы
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title ?? 'Книга рецептов'); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/style.css">
</head>
<body>
    <header>
        <h1>Книга рецептов</h1>
        <nav>
            <a href="<?php echo BASE_URL; ?>">Главная</a>
            <a href="<?php echo BASE_URL; ?>?action=create">Добавить рецепт</a>
        </nav>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer>
        <p>© 2025 Книга рецептов</p>
    </footer>
</body>
</html>