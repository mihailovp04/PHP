<?php
/**
 * Шаблон просмотра рецепта
 * @var array $recipe Данные рецепта
 * @var array $category Данные категории
 */
ob_start();
?>
<h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
<p><strong>Категория:</strong> <?php echo htmlspecialchars($category['name']); ?></p>
<p><strong>Ингредиенты:</strong> <?php echo htmlspecialchars($recipe['ingredients'] ?? ''); ?></p>
<p><strong>Описание:</strong> <?php echo htmlspecialchars($recipe['description'] ?? ''); ?></p>
<p><strong>Теги:</strong> <?php echo htmlspecialchars($recipe['tags'] ?? ''); ?></p>
<p><strong>Шаги:</strong> <?php echo nl2br(htmlspecialchars($recipe['steps'] ?? '')); ?></p>
<a href="<?php echo BASE_URL; ?>?action=edit&id=<?php echo $recipe['id']; ?>">Редактировать</a>
<form method="POST" action="<?php echo BASE_URL; ?>?action=delete&id=<?php echo $recipe['id']; ?>" style="display:inline;">
    <button type="submit" onclick="return confirm('Удалить рецепт?')">Удалить</button>
</form>
<?php
$content = ob_get_clean();
$title = htmlspecialchars($recipe['title']);
require_once __DIR__ . '/../layout.php';