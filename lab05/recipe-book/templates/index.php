<?php
/**
 * Шаблон главной страницы со списком рецептов
 * @var array $recipes Список рецептов
 * @var array $categories Список категорий
 * @var int $page Текущая страница
 * @var int $totalPages Общее количество страниц
 */
ob_start();
?>
<h2>Все рецепты</h2>
<?php if (empty($recipes)): ?>
    <p>Рецепты отсутствуют.</p>
<?php else: ?>
    <ul>
        <?php foreach ($recipes as $recipe): ?>
            <li>
                <a href="<?php echo BASE_URL; ?>?action=show&id=<?php echo $recipe['id']; ?>">
                    <?php echo htmlspecialchars($recipe['title']); ?>
                </a>
                (<?php echo htmlspecialchars($categories[$recipe['category']]['name']); ?>)
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?php echo BASE_URL; ?>?page=<?php echo $i; ?>" <?php echo $page == $i ? 'style="font-weight:bold;"' : ''; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>
<?php
$content = ob_get_clean();
$title = 'Список рецептов';
require_once __DIR__ . '/layout.php';