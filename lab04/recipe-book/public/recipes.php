<?php
require_once '../src/helpers.php';

/**
 * Отображает все рецепты с пагинацией.
 * 
 * @param array $_GET GET-параметр page для выбора текущей страницы
 * @return void
 */
$recipes = getRecipes();
$perPage = 5;
$page = max(1, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1);
$offset = ($page - 1) * $perPage;
$paginatedRecipes = array_slice($recipes, $offset, $perPage);
$totalPages = ceil(count($recipes) / $perPage);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Все рецепты</title>
</head>
<body>
    <h1>Все рецепты</h1>
    <?php foreach ($paginatedRecipes as $recipe): ?>
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

    <?php if ($totalPages > 1): ?>
        <div>
            <?php if ($page > 1): ?>
                <a href="/recipe-book/public/recipes.php?page=<?php echo $page - 1; ?>">Назад</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="/recipe-book/public/recipes.php?page=<?php echo $i; ?>" <?php echo $i === $page ? 'style="font-weight: bold;"' : ''; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="/recipe-book/public/recipes.php?page=<?php echo $page + 1; ?>">Вперед</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <a href="/recipe-book/public/index.php">На главную</a>
</body>
</html>